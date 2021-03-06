<?php

namespace AppBundle\Services;

use \AppBundle\Exceptions\APIException;
use \AppBundle\Exceptions\EntityNotFoundException;
use \AppBundle\Exceptions\ValidationException;
use Symfony\Component\HttpFoundation\Request;

/**
 * Link service
 *
 * @category  Services
 * @package   TOCC
 * @author    Alex <alex@wyett.co.uk>
 * @link      http://www.wyett.co.uk
 */
class Link extends Base
{
    /**
     * Return the entity name needed for the generic methods in the base service
     * 
     * @return string
     */
    public function getEntityName()
    {
        return 'AppBundle:Link';
    }
    
    /**
     * Return the entity path needed for the generic methods in the base service
     * 
     * @return string
     */
    public function getEntityPath()
    {
        return '\AppBundle\Entity\Link';
    }
}