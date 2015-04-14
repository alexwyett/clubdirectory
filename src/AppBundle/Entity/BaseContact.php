<?php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discriminator", type="string")
 * @ORM\DiscriminatorMap(
 *     {
 *     "BaseContact"="AppBundle\Entity\BaseContact",
 *     "Venue"="AppBundle\Entity\Venue",
 *     "Contact"="AppBundle\Entity\Contact"
 * }
 * )
 */
class BaseContact extends \AppBundle\Entity\BaseEntity
{
    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $private;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Address", inversedBy="contact")
     * @ORM\JoinColumn(name="address_id", referencedColumnName="id", unique=true)
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Email", mappedBy="contact")
     */
    private $contactEmail;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Telephone", mappedBy="contact")
     */
    private $contactTelephone;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->contactEmail = new \Doctrine\Common\Collections\ArrayCollection();
        $this->contactTelephone = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set private
     *
     * @param boolean $private
     * @return BaseContact
     */
    public function setPrivate($private)
    {
        $this->private = $private;

        return $this;
    }

    /**
     * Get private
     *
     * @return boolean 
     */
    public function getPrivate()
    {
        return $this->private;
    }

    /**
     * Set address
     *
     * @param \AppBundle\Entity\Address $address
     * @return BaseContact
     */
    public function setAddress(\AppBundle\Entity\Address $address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return \AppBundle\Entity\Address 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Add contactEmail
     *
     * @param \AppBundle\Entity\Email $contactEmail
     * @return BaseContact
     */
    public function addContactEmail(\AppBundle\Entity\Email $contactEmail)
    {
        $this->contactEmail[] = $contactEmail;

        return $this;
    }

    /**
     * Remove contactEmail
     *
     * @param \AppBundle\Entity\Email $contactEmail
     */
    public function removeContactEmail(\AppBundle\Entity\Email $contactEmail)
    {
        $this->contactEmail->removeElement($contactEmail);
    }

    /**
     * Get contactEmail
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContactEmail()
    {
        return $this->contactEmail;
    }

    /**
     * Add contactTelephone
     *
     * @param \AppBundle\Entity\Telephone $contactTelephone
     * @return BaseContact
     */
    public function addContactTelephone(\AppBundle\Entity\Telephone $contactTelephone)
    {
        $this->contactTelephone[] = $contactTelephone;

        return $this;
    }

    /**
     * Remove contactTelephone
     *
     * @param \AppBundle\Entity\Telephone $contactTelephone
     */
    public function removeContactTelephone(\AppBundle\Entity\Telephone $contactTelephone)
    {
        $this->contactTelephone->removeElement($contactTelephone);
    }

    /**
     * Get contactTelephone
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContactTelephone()
    {
        return $this->contactTelephone;
    }
}
