<?php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class ClubVenueTimeSlot
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Timeslot", inversedBy="clubVenueTimeSlot")
     * @ORM\JoinColumn(name="timeslot_id", referencedColumnName="id", nullable=false)
     */
    private $timeslot;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ClubVenue", inversedBy="clubVenueTimeSlot")
     * @ORM\JoinColumn(name="club_venue_id", referencedColumnName="id", nullable=false)
     */
    private $clubVenue;

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
     * Set timeslot
     *
     * @param \AppBundle\Entity\Timeslot $timeslot
     * @return ClubVenueTimeSlot
     */
    public function setTimeslot(\AppBundle\Entity\Timeslot $timeslot)
    {
        $this->timeslot = $timeslot;

        return $this;
    }

    /**
     * Get timeslot
     *
     * @return \AppBundle\Entity\Timeslot 
     */
    public function getTimeslot()
    {
        return $this->timeslot;
    }

    /**
     * Set clubVenue
     *
     * @param \AppBundle\Entity\ClubVenue $clubVenue
     * @return ClubVenueTimeSlot
     */
    public function setClubVenue(\AppBundle\Entity\ClubVenue $clubVenue)
    {
        $this->clubVenue = $clubVenue;

        return $this;
    }

    /**
     * Get clubVenue
     *
     * @return \AppBundle\Entity\ClubVenue 
     */
    public function getClubVenue()
    {
        return $this->clubVenue;
    }
}
