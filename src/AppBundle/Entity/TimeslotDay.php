<?php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class TimeslotDay extends \AppBundle\EntityExtended\TimeslotDay
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
    private $day;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $daynumber;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Timeslot", mappedBy="timeslotDay")
     */
    private $timeslot;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timeslot = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set day
     *
     * @param string $day
     * @return TimeslotDay
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return string 
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set daynumber
     *
     * @param integer $daynumber
     * @return TimeslotDay
     */
    public function setDaynumber($daynumber)
    {
        $this->daynumber = $daynumber;

        return $this;
    }

    /**
     * Get daynumber
     *
     * @return integer 
     */
    public function getDaynumber()
    {
        return $this->daynumber;
    }

    /**
     * Add timeslot
     *
     * @param \AppBundle\Entity\Timeslot $timeslot
     * @return TimeslotDay
     */
    public function addTimeslot(\AppBundle\Entity\Timeslot $timeslot)
    {
        $this->timeslot[] = $timeslot;

        return $this;
    }

    /**
     * Remove timeslot
     *
     * @param \AppBundle\Entity\Timeslot $timeslot
     */
    public function removeTimeslot(\AppBundle\Entity\Timeslot $timeslot)
    {
        $this->timeslot->removeElement($timeslot);
    }

    /**
     * Get timeslot
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTimeslot()
    {
        return $this->timeslot;
    }
}
