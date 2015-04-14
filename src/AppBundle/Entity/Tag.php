<?php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class Tag extends \AppBundle\EntityExtended\Tag
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ClubTag", mappedBy="tag")
     */
    private $clubTag;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->clubTag = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Tag
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
     * Add clubTag
     *
     * @param \AppBundle\Entity\ClubTag $clubTag
     * @return Tag
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
}
