<?php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class AwayTeam extends \AppBundle\Entity\MatchTeam
{
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\LeagueSeasonMatch", mappedBy="awayTeam")
     */
    private $match;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ClubTeam", inversedBy="awayTeam")
     * @ORM\JoinColumn(name="club_team_id", referencedColumnName="id", nullable=false)
     */
    private $clubTeam;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->match = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add match
     *
     * @param \AppBundle\Entity\LeagueSeasonMatch $match
     * @return AwayTeam
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
     * Set clubTeam
     *
     * @param \AppBundle\Entity\ClubTeam $clubTeam
     * @return AwayTeam
     */
    public function setClubTeam(\AppBundle\Entity\ClubTeam $clubTeam)
    {
        $this->clubTeam = $clubTeam;

        return $this;
    }

    /**
     * Get clubTeam
     *
     * @return \AppBundle\Entity\ClubTeam 
     */
    public function getClubTeam()
    {
        return $this->clubTeam;
    }
}
