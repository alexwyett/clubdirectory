<?php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class Telephone extends \AppBundle\EntityExtended\Telephone
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
    private $telephoneNumber;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $telephoneNumberType;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BaseContact", inversedBy="contactTelephone")
     * @ORM\JoinColumn(name="contact_id", referencedColumnName="id", nullable=false)
     */
    private $contact;

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
     * Set telephoneNumber
     *
     * @param string $telephoneNumber
     * @return Telephone
     */
    public function setTelephoneNumber($telephoneNumber)
    {
        $this->telephoneNumber = $telephoneNumber;

        return $this;
    }

    /**
     * Get telephoneNumber
     *
     * @return string 
     */
    public function getTelephoneNumber()
    {
        return $this->telephoneNumber;
    }

    /**
     * Set telephoneNumberType
     *
     * @param string $telephoneNumberType
     * @return Telephone
     */
    public function setTelephoneNumberType($telephoneNumberType)
    {
        $this->telephoneNumberType = $telephoneNumberType;

        return $this;
    }

    /**
     * Get telephoneNumberType
     *
     * @return string 
     */
    public function getTelephoneNumberType()
    {
        return $this->telephoneNumberType;
    }

    /**
     * Set contact
     *
     * @param \AppBundle\Entity\BaseContact $contact
     * @return Telephone
     */
    public function setContact(\AppBundle\Entity\BaseContact $contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return \AppBundle\Entity\BaseContact 
     */
    public function getContact()
    {
        return $this->contact;
    }
}
