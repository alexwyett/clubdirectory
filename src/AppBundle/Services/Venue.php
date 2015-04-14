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
class Venue extends Base
{
    /**
     * Return the entity name needed for the generic methods in the base service
     * 
     * @return string
     */
    public function getEntityName()
    {
        return 'AppBundle:Venue';
    }
    
    /**
     * Return the entity path needed for the generic methods in the base service
     * 
     * @return string
     */
    public function getEntityPath()
    {
        return '\AppBundle\Entity\Venue';
    }
    
    /**
     * Create a new contact
     * 
     * @param stdClass $request Request object
     * 
     * @return \AppBundle\Entity\Contact
     */
    public function create($request)
    {
        $contact = new \AppBundle\Entity\Venue();
        $contact->setAuthorised(false);
        $address = new \AppBundle\Entity\Venue();
        $contact->setAddress($address);
        
        return $this->update($contact, $request);
    }
    
    /**
     * Populate a venue object
     * 
     * @param \AppBundle\Entity\Venue $venue   Venue
     * @param stdClass                $request Request object
     * 
     * @return \AppBundle\Services\Contact
     */
    public function populateObject(&$venue, $request)
    {
        if (isset($request->address)) {
            $address = $venue->getAddress();
            $this->populateObject($address, $request->address);
            $venue->setAddress($address);
            $address->setContact($venue);
            $this->validateAndPersist($address);
            
            unset($request->address);
        }
        
        parent::populateObject($venue, $request);
        
        return $this;
    }
}