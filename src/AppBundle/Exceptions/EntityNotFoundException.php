<?php

namespace AppBundle\Exceptions;

/**
 * Exception class for TOCC.
 *
 * @category  Exceptions
 * @package   TOCC
 * @author    Carlton Software <support@carltonsoftware.co.uk>
 * @copyright 2014 Carlton Software
 * @license   All rights reserved
 * @link      http://www.carltonsoftware.co.uk
 */
class EntityNotFoundException extends APIException
{
    /**
     * Creates a new EntityNotFoundException object
     *
     * @param string $errorDescription Description associated with this error
     * @param string $errorCode        Code associated with this error
     *
     * @return void
     */
    public function __construct($errorDescription, $errorCode)
    {
        parent::__construct($errorDescription, $errorCode, 404);
    }
}
