<?php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class Timeslot extends \AppBundle\EntityExtended\Timeslot
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
    private $fromTime;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $tillTime;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ClubVenueTimeSlot", mappedBy="timeslot")
     */
    private $clubVenueTimeSlot;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TimeslotDay", inversedBy="timeslot")
     * @ORM\JoinColumn(name="timeslot_day_id", referencedColumnName="id", nullable=false)
     */
    private $timeslotDay;
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
     * Set fromTime
     *
     * @param string $fromTime
     * @return Timeslot
     */
    public function setFromTime($fromTime)
    {
        $this->fromTime = $fromTime;

        return $this;
    }

    /**
     * Get fromTime
     *
     * @return string 
     */
    public function getFromTime()
    {
        return $this->fromTime;
    }

    /**
     * Set tillTime
     *
     * @param string $tillTime
     * @return Timeslot
     */
    public function setTillTime($tillTime)
    {
        $this->tillTime = $tillTime;

        return $this;
    }

    /**
     * Get tillTime
     *
     * @return string 
     */
    public function getTillTime()
    {
        return $this->tillTime;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Timeslot
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add clubVenueTimeSlot
     *
     * @param \AppBundle\Entity\ClubVenueTimeSlot $clubVenueTimeSlot
     * @return Timeslot
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
     * Set timeslotDay
     *
     * @param \AppBundle\Entity\TimeslotDay $timeslotDay
     * @return Timeslot
     */
    public function setTimeslotDay(\AppBundle\Entity\TimeslotDay $timeslotDay)
    {
        $this->timeslotDay = $timeslotDay;

        return $this;
    }

    /**
     * Get timeslotDay
     *
     * @return \AppBundle\Entity\TimeslotDay 
     */
    public function getTimeslotDay()
    {
        return $this->timeslotDay;
    }
}
