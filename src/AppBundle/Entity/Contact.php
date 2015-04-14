<?php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class Contact extends \AppBundle\Entity\BaseContact
{
    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $surname;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $role;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ClubContact", mappedBy="contact")
     */
    private $clubContact;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Title", inversedBy="contact")
     * @ORM\JoinColumn(name="title_id", referencedColumnName="id", nullable=false)
     */
    private $title;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->clubContact = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return Contact
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set surname
     *
     * @param string $surname
     * @return Contact
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string 
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set role
     *
     * @param string $role
     * @return Contact
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Add clubContact
     *
     * @param \AppBundle\Entity\ClubContact $clubContact
     * @return Contact
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
     * Set title
     *
     * @param \AppBundle\Entity\Title $title
     * @return Contact
     */
    public function setTitle(\AppBundle\Entity\Title $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return \AppBundle\Entity\Title 
     */
    public function getTitle()
    {
        return $this->title;
    }
}
