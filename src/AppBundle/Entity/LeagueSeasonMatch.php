<?php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class LeagueSeasonMatch
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=false)
     */
    private $matchDate;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\HomeTeam", inversedBy="match")
     * @ORM\JoinColumn(name="home_team_id", referencedColumnName="id", nullable=false)
     */
    private $homeTeam;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AwayTeam", inversedBy="match")
     * @ORM\JoinColumn(name="away_team_id", referencedColumnName="id", nullable=false)
     */
    private $awayTeam;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\LeagueSeason", inversedBy="match")
     * @ORM\JoinColumn(name="league_season_id", referencedColumnName="id", nullable=false)
     */
    private $leagueSeason;

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
     * Set matchDate
     *
     * @param \DateTime $matchDate
     * @return LeagueSeasonMatch
     */
    public function setMatchDate($matchDate)
    {
        $this->matchDate = $matchDate;

        return $this;
    }

    /**
     * Get matchDate
     *
     * @return \DateTime 
     */
    public function getMatchDate()
    {
        return $this->matchDate;
    }

    /**
     * Set homeTeam
     *
     * @param \AppBundle\Entity\HomeTeam $homeTeam
     * @return LeagueSeasonMatch
     */
    public function setHomeTeam(\AppBundle\Entity\HomeTeam $homeTeam)
    {
        $this->homeTeam = $homeTeam;

        return $this;
    }

    /**
     * Get homeTeam
     *
     * @return \AppBundle\Entity\HomeTeam 
     */
    public function getHomeTeam()
    {
        return $this->homeTeam;
    }

    /**
     * Set awayTeam
     *
     * @param \AppBundle\Entity\AwayTeam $awayTeam
     * @return LeagueSeasonMatch
     */
    public function setAwayTeam(\AppBundle\Entity\AwayTeam $awayTeam)
    {
        $this->awayTeam = $awayTeam;

        return $this;
    }

    /**
     * Get awayTeam
     *
     * @return \AppBundle\Entity\AwayTeam 
     */
    public function getAwayTeam()
    {
        return $this->awayTeam;
    }

    /**
     * Set leagueSeason
     *
     * @param \AppBundle\Entity\LeagueSeason $leagueSeason
     * @return LeagueSeasonMatch
     */
    public function setLeagueSeason(\AppBundle\Entity\LeagueSeason $leagueSeason)
    {
        $this->leagueSeason = $leagueSeason;

        return $this;
    }

    /**
     * Get leagueSeason
     *
     * @return \AppBundle\Entity\LeagueSeason 
     */
    public function getLeagueSeason()
    {
        return $this->leagueSeason;
    }
}
