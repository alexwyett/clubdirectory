<?php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class Club extends \AppBundle\Entity\BaseEntity
{
    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ClubVenue", mappedBy="club")
     */
    private $clubVenue;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ClubTag", mappedBy="club")
     */
    private $clubTag;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ClubContact", mappedBy="club")
     */
    private $clubContact;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ClubLink", mappedBy="club")
     */
    private $clubLink;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->clubVenue = new \Doctrine\Common\Collections\ArrayCollection();
        $this->clubTag = new \Doctrine\Common\Collections\ArrayCollection();
        $this->clubContact = new \Doctrine\Common\Collections\ArrayCollection();
        $this->clubLink = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Club
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
     * Set description
     *
     * @param string $description
     * @return Club
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
     * Add clubVenue
     *
     * @param \AppBundle\Entity\ClubVenue $clubVenue
     * @return Club
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

    /**
     * Add clubTag
     *
     * @param \AppBundle\Entity\ClubTag $clubTag
     * @return Club
     */
    public function addClubTag(\AppBundle\Entity\ClubTag $clubTag)
    {
        $this->clubTag[] = $clubTag;

        return $this;
    }

    /**
     * Remove clubTag
     *
     * @param \AppBundle\Entity\ClubTag $clubTag
     */
    public function removeClubTag(\AppBundle\Entity\ClubTag $clubTag)
    {
        $this->clubTag->removeElement($clubTag);
    }

    /**
     * Get clubTag
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClubTag()
    {
        return $this->clubTag;
    }

    /**
     * Add clubContact
     *
     * @param \AppBundle\Entity\ClubContact $clubContact
     * @return Club
     */
    public function addClubContact(\AppBundle\Entity\ClubContact $clubContact)
    {
        $this->clubContact[] = $clubContact;

        return $this;
    }

    /**
     * Remove clubContact
     *
     * @param \AppBundle\Entity\ClubContact $clubContact
     */
    public function removeClubContact(\AppBundle\Entity\ClubContact $clubContact)
    {
        $this->clubContact->removeElement($clubContact);
    }

    /**
     * Get clubContact
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClubContact()
    {
        return $this->clubContact;
    }

    /**
     * Add clubLink
     *
     * @param \AppBundle\Entity\ClubLink $clubLink
     * @return Club
     */
    public function addClubLink(\AppBundle\Entity\ClubLink $clubLink)
    {
        $this->clubLink[] = $clubLink;

        return $this;
    }

    /**
     * Remove clubLink
     *
     * @param \AppBundle\Entity\ClubLink $clubLink
     */
    public function removeClubLink(\AppBundle\Entity\ClubLink $clubLink)
    {
        $this->clubLink->removeElement($clubLink);
    }

    /**
     * Get clubLink
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClubLink()
    {
        return $this->clubLink;
    }
}
