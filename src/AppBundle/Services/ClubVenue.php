<?php

namespace AppBundle\Services;

use \AppBundle\Exceptions\APIException;
use \AppBundle\Exceptions\EntityNotFoundException;
use \AppBundle\Exceptions\ValidationException;
use Symfony\Component\HttpFoundation\Request;

/**
 * Venue service
 *
 * @category  Services
 * @package   TOCC
 * @author    Alex <alex@wyett.co.uk>
 * @link      http://www.wyett.co.uk
 */
class ClubVenue extends Base
{
    /**
     * Return the entity name needed for the generic methods in the base service
     * 
     * @return string
     */
    public function getEntityName()
    {
        return 'AppBundle:ClubVenue';
    }
    
    /**
     * Return the entity path needed for the generic methods in the base service
     * 
     * @return string
     */
    public function getEntityPath()
    {
        return '\AppBundle\Entity\ClubVenue';
    }
    
    /**
     * Create a new club venue
     * 
     * @param \AppBundle\Entity\Club  $club  Club
     * @param \AppBundle\Entity\Venue $venue Venue
     * 
     * @return \AppBundle\Entity\ClubVenue
     */
    public function createClubVenue($club, $venue)
    {
        // Check venue hasn't already been added
        foreach ($club->getClubVenue() as $cv) {
            if ($cv->getVenue() == $venue) {
                throw new APIException(
                    'Venue has already been added to club',
                    -1,
                    400
                );
            }
        }
        
        
        return $this->create((object) array(
            'club_id' => $club->getId(),
            'venue_id' => $venue->getId()
        ));
    }
    
    /**
     * Remove a club venue
     * 
     * @param \AppBundle\Entity\ClubVenue $clubVenue Club venue object
     * 
     * @return \AppBundle\Services\ClubVenue
     */
    public function removeClubVenue($clubVenue)
    {
        // Get and remove timeslot refs
        foreach ($clubVenue->getClubVenueTimeSlot() as $ts) {
            $clubVenue->removeClubVenueTimeSlot($ts);
            $this->getEm()->remove($ts);
        }
        $this->getEm()->persist($clubVenue);
        $this->getEm()->flush();
        
        $this->getEm()->remove($clubVenue);
        $this->getEm()->flush();
        
        return $this;
    }
    
    /**
     * Create a new club venue
     * 
     * @param stdClass $request Request object
     * 
     * @return \AppBundle\Entity\ClubVenue
     */
    public function create($request)
    {
        $clubVenue = new \AppBundle\Entity\ClubVenue();
        return $this->update($clubVenue, $request);
    }
    
    /**
     * Update a given club venue object
     * 
     * @param \AppBundle\Entity\ClubVenue $clubVenue Club Venue
     * @param stdClass                    $request   Request object
     * 
     * @return \AppBundle\Entity\ClubVenue
     * 
     * @throws EntityNotFoundException
     */
    public function update($clubVenue, $request)
    {
        if (!isset($request->club_id)) {
            throw new EntityNotFoundException(
                'Club not found',
                -1
            );
        }
        if (!isset($request->venue_id)) {
            throw new EntityNotFoundException(
                'Venue not found',
                -1
            );
        }
        
        $club = $this->_getClubRepo()->findOneById($request->club_id);
        if (!$club) {
            throw new EntityNotFoundException('Club not found', -1);
        }
        
        $venue = $this->_getVenueRepo()->findOneById($request->venue_id);
        if (!$venue) {
            throw new EntityNotFoundException('Venue not found', -1);
        }
        
        $clubVenue->setClub($club)->setVenue($venue);
        $this->validateAndPersist($clubVenue);
        $this->getEm()->flush();
        
        return $clubVenue;
    }
    
    /**
     * Add a timeslot to a club venue
     * 
     * @param \AppBundle\Entity\ClubVenue $clubVenue Club Venue
     * @param \AppBundle\Entity\Timeslot  $timeslot  Time slot
     * 
     * @return \AppBundle\Entity\ClubVenueTimeSlot
     */
    public function addTimeslot($clubVenue, $timeslot)
    {
        // Check venue hasn't already been added
        foreach ($clubVenue->getClubVenueTimeSlot() as $cvts) {
            if ($cvts->getTimeslot() == $timeslot) {
                throw new APIException(
                    'Timeslot has already been added',
                    -1,
                    400
                );
            }
        }
        
        $cvts = new \AppBundle\Entity\ClubVenueTimeSlot();
        $cvts->setClubVenue($clubVenue)->setTimeslot($timeslot);
        $this->validateAndPersist($cvts);
        $this->getEm()->flush();
        
        return $cvts;
    }
    
    /**
     * Remove a timeslot to a club venue
     * 
     * @param \AppBundle\Entity\ClubVenue $clubVenue Club Venue
     * @param \AppBundle\Entity\Timeslot  $timeslot  Time slot
     * 
     * @return \AppBundle\Services\ClubVenue
     */
    public function removeTimeslot($clubVenue, $timeslot)
    {
        $clubVenueTimeSlot = false;
        foreach ($clubVenue->getClubVenueTimeSlot() as $cvts) {
            if ($cvts->getTimeslot() == $timeslot) {
                $clubVenueTimeSlot = $cvts;
            }
        }
        
        if (!$clubVenueTimeSlot) {
            throw new EntityNotFoundException(
                'Timeslot not found',
                -1
            );
        } else {
            $this->getEm()->remove($clubVenueTimeSlot);
            $this->getEm()->flush();
        }
        return $this;
    }
    
    /**
     * Return the club repo
     * 
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    private function _getClubRepo()
    {
        return $this->getRepository('AppBundle:Club');
    }
    
    /**
     * Return the venue repo
     * 
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    private function _getVenueRepo()
    {
        return $this->getRepository('AppBundle:Venue');
    }
}