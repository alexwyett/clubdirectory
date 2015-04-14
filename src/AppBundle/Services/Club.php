<?php

namespace AppBundle\Services;

use \AppBundle\Exceptions\APIException;
use \AppBundle\Exceptions\EntityNotFoundException;
use \AppBundle\Exceptions\ValidationException;
use Symfony\Component\HttpFoundation\Request;

/**
 * Club service
 *
 * @category  Services
 * @package   ClubDirectory
 * @author    Alex <alex@wyett.co.uk>
 * @link      http://www.wyett.co.uk
 */
class Club extends Base
{
    /**
     * Return the entity name needed for the generic methods in the base service
     * 
     * @return string
     */
    public function getEntityName()
    {
        return 'AppBundle:Club';
    }
    
    /**
     * Return the entity path needed for the generic methods in the base service
     * 
     * @return string
     */
    public function getEntityPath()
    {
        return '\AppBundle\Entity\Club';
    }
    
    /**
     * Create a new club object
     * 
     * @param stdClass $request Request object
     * 
     * @return \AppBundle\Entity\Club
     */
    public function create($request)
    {
        $club = new \AppBundle\Entity\Club();
        $club->setAuthorised(false);
        
        return $this->update($club, $request);
    }
    
    /**
     * Add a contact to a club
     * 
     * @param \AppBundle\Entity\Club    $club    Club
     * @param \AppBundle\Entity\Contact $contact Contact
     * 
     * @return \AppBundle\Services\Club
     */
    public function addContact($club, $contact)
    {
        $found = false;
        foreach ($club->getClubContact() as $clubContact) {
            if ($clubContact->getContact() == $contact) {
                $found = true;
            }
        }
        
        if (!$found) {
            $clubContact = new \AppBundle\Entity\ClubContact();
            $clubContact->setClub($club)->setContact($contact);
            $this->validateAndPersist($clubContact);
            $club->addClubContact($clubContact);
            $this->getEm()->persist($club);
            $this->getEm()->flush();
        }
        
        return $this;
    }
    
    /**
     * Remove a contact from a club
     * 
     * @param \AppBundle\Entity\Club    $club    Club
     * @param \AppBundle\Entity\Contact $contact Contact
     * 
     * @return \AppBundle\Services\Club
     * 
     * @throws \AppBundle\Exceptions\FieldNotFoundException
     */
    public function removeContact($club, $contact)
    {
        $clubContactEntity = false;
        foreach ($club->getClubContact() as $clubContact) {
            if ($clubContact->getContact() == $contact) {
                $clubContactEntity = $clubContact;
            }
        }
        
        if ($clubContactEntity) {
            $club->removeClubContact($clubContactEntity);
            $this->getEm()->remove($clubContactEntity);
            $this->getEm()->persist($club);
            $this->getEm()->flush();
        } else {
            throw new EntityNotFoundException(
                'Contact does not exist for this club',
                -1
            );
        }
        
        return $this;
    }
    
    /**
     * Add a tag to a club
     * 
     * @param \AppBundle\Entity\Club $club Club
     * @param \AppBundle\Entity\Tag  $tag  Tag
     * 
     * @return \AppBundle\Services\Club
     */
    public function addTag($club, $tag)
    {
        $found = false;
        foreach ($club->getClubTag() as $clubTag) {
            if ($clubTag->getTag() == $tag) {
                $found = true;
            }
        }
        
        if (!$found) {
            $clubTag = new \AppBundle\Entity\ClubTag();
            $clubTag->setClub($club)->setTag($tag);
            $this->validateAndPersist($clubTag);
            $club->addClubTag($clubTag);
            $this->getEm()->persist($club);
            $this->getEm()->flush();
        }
        
        return $this;
    }
    
    /**
     * Remove a tag from a club
     * 
     * @param \AppBundle\Entity\Club $club Club
     * @param \AppBundle\Entity\Tag  $tag  Tag
     * 
     * @return \AppBundle\Services\Club
     * 
     * @throws \AppBundle\Exceptions\FieldNotFoundException
     */
    public function removeTag($club, $tag)
    {
        $clubTagEntity = false;
        foreach ($club->getClubTag() as $clubTag) {
            if ($clubTag->getTag() == $tag) {
                $clubTagEntity = $clubTag;
            }
        }
        
        if ($clubTagEntity) {
            $club->removeClubTag($clubTagEntity);
            $this->getEm()->remove($clubTagEntity);
            $this->getEm()->persist($club);
            $this->getEm()->flush();
        } else {
            throw new EntityNotFoundException(
                'Tag does not exist for this club',
                -1
            );
        }
        
        return $this;
    }
    
    /**
     * Add a link to a club
     * 
     * @param \AppBundle\Entity\Club $club Club
     * @param \AppBundle\Entity\Link $link Link
     * 
     * @return \AppBundle\Services\Club
     */
    public function addLink($club, $link)
    {
        $found = false;
        foreach ($club->getClubLink() as $clubLink) {
            if ($clubLink->getLink() == $link) {
                $found = true;
            }
        }
        
        if (!$found) {
            $clubLink = new \AppBundle\Entity\ClubLink();
            $clubLink->setClub($club)->setLink($link);
            $this->validateAndPersist($clubLink);
            $club->addClubLink($clubLink);
            $this->getEm()->persist($club);
            $this->getEm()->flush();
        }
        
        return $this;
    }
    
    /**
     * Remove a link from a club
     * 
     * @param \AppBundle\Entity\Club $club Club
     * @param \AppBundle\Entity\Link $link Link
     * 
     * @return \AppBundle\Services\Club
     * 
     * @throws \AppBundle\Exceptions\FieldNotFoundException
     */
    public function removeLink($club, $link)
    {
        $clubLinkEntity = false;
        foreach ($club->getClubLink() as $clubLink) {
            if ($clubLink->getLink() == $link) {
                $clubLinkEntity = $clubLink;
            }
        }
        
        if ($clubLinkEntity) {
            $club->removeClubLink($clubLinkEntity);
            $this->getEm()->remove($clubLinkEntity);
            $this->getEm()->persist($club);
            $this->getEm()->flush();
        } else {
            throw new EntityNotFoundException(
                'Link does not exist for this club',
                -1
            );
        }
        
        return $this;
    }
    
    /**
     * Get a club venue
     * 
     * @param \AppBundle\Entity\Club $club Club
     * @param integer                $id   Club Venue Id
     * 
     * @return \AppBundle\Entity\ClubVenue
     */
    public function getClubVenue($club, $id)
    {
        $clubVenue = false;
        foreach ($club->getClubVenue() as $cv) {
            if ($cv->getId() == $id) {
                $clubVenue = $cv;
            }
        }
        
        if (!$clubVenue) {
            throw new EntityNotFoundException(
                'Club Venue does not exist for this club',
                -1
            );
        }
        
        return $clubVenue;
    }
}