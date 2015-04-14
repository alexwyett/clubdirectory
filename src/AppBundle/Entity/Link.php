<?php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class Link extends \AppBundle\EntityExtended\Link
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
    private $link;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $description;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $linkType;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ClubLink", mappedBy="link")
     */
    private $clubLink;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->clubLink = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set link
     *
     * @param string $link
     * @return Link
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Link
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
     * Set linkType
     *
     * @param string $linkType
     * @return Link
     */
    public function setLinkType($linkType)
    {
        $this->linkType = $linkType;

        return $this;
    }

    /**
     * Get linkType
     *
     * @return string 
     */
    public function getLinkType()
    {
        return $this->linkType;
    }

    /**
     * Add clubLink
     *
     * @param \AppBundle\Entity\ClubLink $clubLink
     * @return Link
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
