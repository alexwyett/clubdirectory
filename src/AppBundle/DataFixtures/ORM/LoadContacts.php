<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadContacts extends \AppBundle\DataFixtures\Fixture implements \Doctrine\Common\DataFixtures\OrderedFixtureInterface
{
    /**
     * @inheritDoc
     */
    public function getOrder()
    {
        return 5;
    }
    
    /**
     * Load common fixtures
     *
     * @param ObjectManager $manager The entity manager
     *
     * @access public
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $this->loadFromFile('contacts.csv', 'AppBundle\Entity\Contact', $manager);
        $this->loadFromFile('emailaddresses.csv', 'AppBundle\Entity\Email', $manager);
        $this->loadFromFile('telephonenumbers.csv', 'AppBundle\Entity\Telephone', $manager);
        $this->loadFromFile('clubcontacts.csv', 'AppBundle\Entity\ClubContact', $manager);
    }
}