<?php

namespace AppBundle\Exceptions;

/**
 * Validation exception class for TOCC.
 *
 * @category  Exceptions
 * @package   TOCC
 * @author    Carlton Software <support@carltonsoftware.co.uk>
 * @copyright 2014 Carlton Software
 * @license   All rights reserved
 * @link      http://www.carltonsoftware.co.uk
 */
class ValidationException extends APIException
{
    /**
     * Array of validation errors
     *
     * @var array
     */
    private $validationError = array();
    
    /**
     * Creates a new ValidationException object
     *
     * @param string $message         A human readable message describing the 
     *                                error
     * @param string $errorCode       The error code associated with this error
     * @param string $httpStatusCode  The HTTP status code that should be sent 
     *                                with this error
     * @param array  $validationError Array of validation errors
     *
     * @return void
     */
    public function __construct(
        $message,
        $errorCode,
        $httpStatusCode = 501,
        $validationError = array()
    ) {
        $this->validationError = $validationError;
        parent::__construct($message, $errorCode, $httpStatusCode);
    }

    /**
     * Returns the validation errors in this exception
     *
     * @access public
     *
     * @return array
     */
    public function getValidationError()
    {
        return $this->validationError;
    }
}