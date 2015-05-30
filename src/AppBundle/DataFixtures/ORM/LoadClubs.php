<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadClubs extends \AppBundle\DataFixtures\Fixture implements \Doctrine\Common\DataFixtures\OrderedFixtureInterface
{
    /**
     * @inheritDoc
     */
    public function getOrder()
    {
        return 3;
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
        $this->loadFromFile('clubs.csv', 'AppBundle\Entity\Club', $manager);
        $this->loadFromFile('clubvenues.csv', 'AppBundle\Entity\ClubVenue', $manager);
        $this->loadFromFile('tags.csv', 'AppBundle\Entity\Tag', $manager);
        $this->loadFromFile('clubtags.csv', 'AppBundle\Entity\ClubTag', $manager);
        $this->loadFromFile('links.csv', 'AppBundle\Entity\Link', $manager);
        $this->loadFromFile('clublinks.csv', 'AppBundle\Entity\ClubLink', $manager);
    }
}
