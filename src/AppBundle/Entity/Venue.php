<?php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class Venue extends \AppBundle\Entity\BaseContact
{
    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ClubVenue", mappedBy="venue")
     */
    private $clubVenue;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->clubVenue = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Venue
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
     * Add clubVenue
     *
     * @param \AppBundle\Entity\ClubVenue $clubVenue
     * @return Venue
     */
    public function addClubVenue(\AppBundle\Entity\ClubVenue $clubVenue)
    {
        $this->clubVenue[] = $clubVenue;

        return $this;
    }

    /**
     * Remove clubVenue
     *
     * @param \AppBundle\Entity\ClubVenue $clubVenue
     */
    public function removeClubVenue(\AppBundle\Entity\ClubVenue $clubVenue)
    {
        $this->clubVenue->removeElement($clubVenue);
    }

    /**
     * Get clubVenue
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClubVenue()
    {
        return $this->clubVenue;
    }
}
