<?php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class ClubVenue extends \AppBundle\EntityExtended\ClubVenue
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ClubVenueTimeSlot", mappedBy="clubVenue")
     */
    private $clubVenueTimeSlot;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Club", inversedBy="clubVenue")
     * @ORM\JoinColumn(name="club_id", referencedColumnName="id", nullable=false)
     */
    private $club;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Venue", inversedBy="clubVenue")
     * @ORM\JoinColumn(name="venue_id", referencedColumnName="id", nullable=false)
     */
    private $venue;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->clubVenueTimeSlot = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add clubVenueTimeSlot
     *
     * @param \AppBundle\Entity\ClubVenueTimeSlot $clubVenueTimeSlot
     * @return ClubVenue
     */
    public function addClubVenueTimeSlot(\AppBundle\Entity\ClubVenueTimeSlot $clubVenueTimeSlot)
    {
        $this->clubVenueTimeSlot[] = $clubVenueTimeSlot;

        return $this;
    }

    /**
     * Remove clubVenueTimeSlot
     *
     * @param \AppBundle\Entity\ClubVenueTimeSlot $clubVenueTimeSlot
     */
    public function removeClubVenueTimeSlot(\AppBundle\Entity\ClubVenueTimeSlot $clubVenueTimeSlot)
    {
        $this->clubVenueTimeSlot->removeElement($clubVenueTimeSlot);
    }

    /**
     * Get clubVenueTimeSlot
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClubVenueTimeSlot()
    {
        return $this->clubVenueTimeSlot;
    }

    /**
     * Set club
     *
     * @param \AppBundle\Entity\Club $club
     * @return ClubVenue
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

    /**
     * Set venue
     *
     * @param \AppBundle\Entity\Venue $venue
     * @return ClubVenue
     */
    public function setVenue(\AppBundle\Entity\Venue $venue)
    {
        $this->venue = $venue;

        return $this;
    }

    /**
     * Get venue
     *
     * @return \AppBundle\Entity\Venue 
     */
    public function getVenue()
    {
        return $this->venue;
    }
}
