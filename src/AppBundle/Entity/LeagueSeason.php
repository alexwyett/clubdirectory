<?php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class LeagueSeason
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\LeagueSeasonMatch", mappedBy="leagueSeason")
     */
    private $match;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\League", inversedBy="leagueSeason")
     * @ORM\JoinColumn(name="league_id", referencedColumnName="id", nullable=false)
     */
    private $league;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Season", inversedBy="leagueSeason")
     * @ORM\JoinColumn(name="season_id", referencedColumnName="id", nullable=false)
     */
    private $season;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->match = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add match
     *
     * @param \AppBundle\Entity\LeagueSeasonMatch $match
     * @return LeagueSeason
     */
    public function addMatch(\AppBundle\Entity\LeagueSeasonMatch $match)
    {
        $this->match[] = $match;

        return $this;
    }

    /**
     * Remove match
     *
     * @param \AppBundle\Entity\LeagueSeasonMatch $match
     */
    public function removeMatch(\AppBundle\Entity\LeagueSeasonMatch $match)
    {
        $this->match->removeElement($match);
    }

    /**
     * Get match
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMatch()
    {
        return $this->match;
    }

    /**
     * Set league
     *
     * @param \AppBundle\Entity\League $league
     * @return LeagueSeason
     */
    public function setLeague(\AppBundle\Entity\League $league)
    {
        $this->league = $league;

        return $this;
    }

    /**
     * Get league
     *
     * @return \AppBundle\Entity\League 
     */
    public function getLeague()
    {
        return $this->league;
    }

    /**
     * Set season
     *
     * @param \AppBundle\Entity\Season $season
     * @return LeagueSeason
     */
    public function setSeason(\AppBundle\Entity\Season $season)
    {
        $this->season = $season;

        return $this;
    }

    /**
     * Get season
     *
     * @return \AppBundle\Entity\Season 
     */
    public function getSeason()
    {
        return $this->season;
    }
}
