<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadTimeslots extends \AppBundle\DataFixtures\Fixture implements \Doctrine\Common\DataFixtures\OrderedFixtureInterface
{
    /**
     * @inheritDoc
     */
    public function getOrder()
    {
        return 4;
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
        $this->loadFromFile('timeslots.csv', 'AppBundle\Entity\Timeslot', $manager);
        $this->loadFromFile('clubvenuetimeslots.csv', 'AppBundle\Entity\ClubVenueTimeSlot', $manager);
    }
}