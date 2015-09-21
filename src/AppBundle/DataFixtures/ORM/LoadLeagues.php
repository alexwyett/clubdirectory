<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadLeagues extends \AppBundle\DataFixtures\Fixture implements \Doctrine\Common\DataFixtures\OrderedFixtureInterface
{
    /**
     * @inheritDoc
     */
    public function getOrder()
    {
        return 6;
    }
    
    /**
     * Load league fixtures
     *
     * @param ObjectManager $manager The entity manager
     *
     * @access public
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $this->loadFromFile('leagues.csv', 'AppBundle\Entity\League', $manager);
        $this->loadFromFile('seasons.csv', 'AppBundle\Entity\Season', $manager);
        $this->loadFromFile('leagueseasons.csv', 'AppBundle\Entity\LeagueSeason', $manager);
        $this->loadFromFile('clubteams.csv', 'AppBundle\Entity\ClubTeam', $manager);
    }
}