<?php

namespace AppBundle\Services;

use \AppBundle\Exceptions\APIException;
use \AppBundle\Exceptions\EntityNotFoundException;
use \AppBundle\Exceptions\ValidationException;
use Symfony\Component\HttpFoundation\Request;

/**
 * Timeslot service
 *
 * @category  Services
 * @package   TOCC
 * @author    Alex <alex@wyett.co.uk>
 * @link      http://www.wyett.co.uk
 */
class Timeslot extends Base
{
    /**
     * Return the entity name needed for the generic methods in the base service
     * 
     * @return string
     */
    public function getEntityName()
    {
        return 'AppBundle:Timeslot';
    }
    
    /**
     * Return the entity path needed for the generic methods in the base service
     * 
     * @return string
     */
    public function getEntityPath()
    {
        return '\AppBundle\Entity\Timeslot';
    }
    
    /**
     * Update a timeslot entity
     * 
     * @param \AppBundle\Entity\Timeslot $timeslot Timeslot
     * @param stdClass                   $request  Request
     * 
     * @return \AppBundle\Entity\Timeslot
     */
    public function update($timeslot, $request)
    {
        if (!isset($request->dayNumber)) {
            throw new EntityNotFoundException(
                'Day not found',
                -1
            );
        }
        
        $day = $this->_getDayRepo()->findOneByDaynumber($request->dayNumber);
        if (!$day) {
            throw new EntityNotFoundException('Day not found', -1);
        } else {
            unset($request->dayNumber);
        }
        
        $timeslot->setTimeslotDay($day);
        
        return parent::update($timeslot, $request);
    }
    
    /**
     * Return the day repo
     * 
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    private function _getDayRepo()
    {
        return $this->getRepository('AppBundle:TimeslotDay');
    }
}