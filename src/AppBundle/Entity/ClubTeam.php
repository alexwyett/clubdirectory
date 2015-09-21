<?php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class ClubTeam
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64, nullable=false)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\HomeTeam", mappedBy="clubTeam")
     */
    private $homeTeam;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AwayTeam", mappedBy="clubTeam")
     */
    private $awayTeam;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Club", inversedBy="clubTeam")
     * @ORM\JoinColumn(name="club_id", referencedColumnName="id", nullable=false)
     */
    private $club;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->homeTeam = new \Doctrine\Common\Collections\ArrayCollection();
        $this->awayTeam = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return ClubTeam
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add homeTeam
     *
     * @param \AppBundle\Entity\HomeTeam $homeTeam
     * @return ClubTeam
     */
    public function addHomeTeam(\AppBundle\Entity\HomeTeam $homeTeam)
    {
        $this->homeTeam[] = $homeTeam;

        return $this;
    }

    /**
     * Remove homeTeam
     *
     * @param \AppBundle\Entity\HomeTeam $homeTeam
     */
    public function removeHomeTeam(\AppBundle\Entity\HomeTeam $homeTeam)
    {
        $this->homeTeam->removeElement($homeTeam);
    }

    /**
     * Get homeTeam
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHomeTeam()
    {
        return $this->homeTeam;
    }

    /**
     * Add awayTeam
     *
     * @param \AppBundle\Entity\AwayTeam $awayTeam
     * @return ClubTeam
     */
    public function addAwayTeam(\AppBundle\Entity\AwayTeam $awayTeam)
    {
        $this->awayTeam[] = $awayTeam;

        return $this;
    }

    /**
     * Remove awayTeam
     *
     * @param \AppBundle\Entity\AwayTeam $awayTeam
     */
    public function removeAwayTeam(\AppBundle\Entity\AwayTeam $awayTeam)
    {
        $this->awayTeam->removeElement($awayTeam);
    }

    /**
     * Get awayTeam
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAwayTeam()
    {
        return $this->awayTeam;
    }

    /**
     * Set club
     *
     * @param \AppBundle\Entity\Club $club
     * @return ClubTeam
     */
    public function setClub(\AppBundle\Entity\Club $club)
    {
        $this->club = $club;

        return $this;
    }

    /**
     * Get club
     *
     * @return \AppBundle\Entity\Club 
     */
    public function getClub()
    {
        return $this->club;
    }
}
