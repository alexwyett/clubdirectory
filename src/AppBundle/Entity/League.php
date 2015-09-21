<?php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class League
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $maxGames;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\LeagueSeason", mappedBy="league")
     */
    private $leagueSeason;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->leagueSeason = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return League
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
     * Set maxGames
     *
     * @param integer $maxGames
     * @return League
     */
    public function setMaxGames($maxGames)
    {
        $this->maxGames = $maxGames;

        return $this;
    }

    /**
     * Get maxGames
     *
     * @return integer 
     */
    public function getMaxGames()
    {
        return $this->maxGames;
    }

    /**
     * Add leagueSeason
     *
     * @param \AppBundle\Entity\LeagueSeason $leagueSeason
     * @return League
     */
    public function addLeagueSeason(\AppBundle\Entity\LeagueSeason $leagueSeason)
    {
        $this->leagueSeason[] = $leagueSeason;

        return $this;
    }

    /**
     * Remove leagueSeason
     *
     * @param \AppBundle\Entity\LeagueSeason $leagueSeason
     */
    public function removeLeagueSeason(\AppBundle\Entity\LeagueSeason $leagueSeason)
    {
        $this->leagueSeason->removeElement($leagueSeason);
    }

    /**
     * Get leagueSeason
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLeagueSeason()
    {
        return $this->leagueSeason;
    }
}
