<?php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class ClubLink
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Link", inversedBy="clubLink")
     * @ORM\JoinColumn(name="link_id", referencedColumnName="id", nullable=false)
     */
    private $link;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Club", inversedBy="clubLink")
     * @ORM\JoinColumn(name="club_id", referencedColumnName="id", nullable=false)
     */
    private $club;

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
     * @param \AppBundle\Entity\Link $link
     * @return ClubLink
     */
    public function setLink(\AppBundle\Entity\Link $link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return \AppBundle\Entity\Link 
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set club
     *
     * @param \AppBundle\Entity\Club $club
     * @return ClubLink
     */
    public function setClub(\AppBundle\Entity\Club $club)
    {
        $this->club = $club;

        return $this;
    }

    /**
     * Get club
     *
     * @return \AppBundle\Entity\Club 
     */
    public function getClub()
    {
        return $this->club;
    }
}
