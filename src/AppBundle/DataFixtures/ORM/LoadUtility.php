<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUtility extends \AppBundle\DataFixtures\Fixture implements \Doctrine\Common\DataFixtures\OrderedFixtureInterface
{
    /**
     * @inheritDoc
     */
    public function getOrder()
    {
        return 1;
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
        $this->loadFromFile('titles.csv', 'AppBundle\Entity\Title', $manager);
        $this->loadFromFile('addresses.csv', 'AppBundle\Entity\Address', $manager);
        $this->loadFromFile('timeslotdays.csv', 'AppBundle\Entity\TimeslotDay', $manager);
    }
}