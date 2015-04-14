<?php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discriminator", type="string")
 * @ORM\DiscriminatorMap(
 *     {
 *     "BaseEntity"="AppBundle\Entity\BaseEntity",
 *     "Club"="AppBundle\Entity\Club",
 *     "BaseContact"="AppBundle\Entity\BaseContact"
 * }
 * )
 */
class BaseEntity extends \AppBundle\EntityExtended\BaseEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $published;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $authorised;

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
     * Set published
     *
     * @param boolean $published
     * @return BaseEntity
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean 
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set authorised
     *
     * @param boolean $authorised
     * @return BaseEntity
     */
    public function setAuthorised($authorised)
    {
        $this->authorised = $authorised;

        return $this;
    }

    /**
     * Get authorised
     *
     * @return boolean 
     */
    public function getAuthorised()
    {
        return $this->authorised;
    }
}
