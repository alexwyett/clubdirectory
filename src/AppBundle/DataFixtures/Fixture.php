<?php
namespace AppBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\ORM\EntityManager;

abstract class Fixture extends AbstractFixture
{
    /**
     * Creates fixtures from a CSV file.
     *
     * The first row of the csv should contain headings that match the name of 
     * the field it corresponds to in the object.
     * 
     * The first column 'ref' contains the name to give to the object, 
     * so it can be referenced from other fixtures
     *
     * Example CSV file:
     * ref,name,alpha2,alpha3
     * country-fr,France,FR,FRA
     * country-de,Germany,DE,DEU
     * country-gb,United Kingdom,GB,GBR
     *
     * @param string        $filename   Name of the csv file containing the 
     *                                  fixture data.
     * @param class         $objectType The type of object being created. eg. 
     *                                  Bundle\Entity\Country
     * @param EntityManager $manager    The object manager
     *
     * @return void
     */
    protected function loadFromFile(
        $filename,
        $objectType,
        \Doctrine\ORM\EntityManager $manager,
        $flush = true
    ) {
        $fixture = dirname(__FILE__) . '/../Resources/public/fixtures/' . $filename;
        if (!file_exists($fixture)) {
            throw new \RuntimeException('Unable to locate fixture file at ' . $fixture);
        }

        //Open the file for reading
        $fh = fopen($fixture, "r");

        //Read in the column headers
        $headers = fgetcsv($fh, 4094);

        while (!feof($fh) ) {
            $line = fgetcsv($fh, 4094);
            if (
                $line[0] != null
            ) {
                //Create a new empty object
                $object = new $objectType();

                //Set each of the fields of the object
                for ($i = 1; $i < sizeof($line); $i++) {

                    //Check to see if this field contains a reference to another fixture
                    $field = $line[$i];
                    $func = 'set' . ucfirst($headers[$i]);
                    if (substr($field, 0, 4) == 'REF-') {
                        //Reference field
                        $ref = str_replace('REF-', '', $field);
                        $object->$func($this->getReference($ref));
                        
                    } else if ($field == 'null') {
                        
                    } else if ($field == 'true') {
                        $object->$func(true);
                    } else if ($field == 'false') {
                        $object->$func(false);
                    } else {
                        //Plain old field
                        if (preg_match('/[0-9]{4}-[0-9]{2}-[0-9]{2}/', $field)) {
                            $field = new \DateTime($field);
                        }
                        $object->$func($field);
                    }
                }
            }

            //Save to the DB
            $manager->persist($object);

            //Create a reference so we can reference this object from other fixtures
            $this->addReference($line[0], $object);
        }

        if ($flush) {
            $manager->flush();
        }
    }
}