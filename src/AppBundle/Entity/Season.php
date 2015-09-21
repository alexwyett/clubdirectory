<?php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class Season
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
     * @ORM\Column(type="date", nullable=false)
     */
    private $startDate;

    /**
     * @ORM\Column(type="date", nullable=false)
     */
    private $expiryDate;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $active;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\LeagueSeason", mappedBy="season")
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
     * @return Season
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
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return Season
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set expiryDate
     *
     * @param \DateTime $expiryDate
     * @return Season
     */
    public function setExpiryDate($expiryDate)
    {
        $this->expiryDate = $expiryDate;

        return $this;
    }

    /**
     * Get expiryDate
     *
     * @return \DateTime 
     */
    public function getExpiryDate()
    {
        return $this->expiryDate;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Season
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Add leagueSeason
     *
     * @param \AppBundle\Entity\LeagueSeason $leagueSeason
     * @return Season
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
