<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadVenues extends \AppBundle\DataFixtures\Fixture implements \Doctrine\Common\DataFixtures\OrderedFixtureInterface
{
    /**
     * @inheritDoc
     */
    public function getOrder()
    {
        return 2;
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
        $this->loadFromFile('venues.csv', 'AppBundle\Entity\Venue', $manager);
    }
}