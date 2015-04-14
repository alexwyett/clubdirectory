<?php

namespace AppBundle\Responses;
use Symfony\Component\HttpFoundation\Response;

/**
 * This class is used to generate a response
 *
 * @category  Responses
 * @package   TOCC
 * @author    Carlton Software <support@carltonsoftware.co.uk>
 * @copyright 2014 Carlton Software
 * @license   All rights reserved
 * @link      http://www.carltonsoftware.co.uk
 */
class ErrorResponse extends Response
{
    /**
     * Creates a new ErrorResponse object
     *
     * @param int    $statusCode       The HTTP response code to send back
     * @param int    $errorCode        The code associated with the error
     * @param string $errorDescription A human readable description of the error
     * @param string $errorTrace       The stack trace from the error
     * @param string $errorLocation    The location of the error
     * @param string $errorType        Type of error (normally the class name of the exception)
     *
     * @return ErrorResponse
     */
    public function __construct(
        $statusCode,
        $errorCode,
        $errorDescription,
        $errorTrace = null,
        $errorLocation = null,
        $errorType = 'Unhandled'
    ) {
        // Build the response
        $content['errorCode'] = $errorCode;
        $content['errorDescription'] = $errorDescription;
        
        if ($errorType != null) {
            $types = explode("\\", $errorType);
            $content['errorType'] = array_pop($types);
        }
        
        if ($errorLocation != null) {
            $content['errorLocation'] = $errorLocation;
        }
        
        if ($errorTrace != null) {
            $content['errorTrace'] = $errorTrace;
        }

        // Call the parent constructor
        parent::__construct(
            json_encode($content),
            $statusCode,
            array('Content-Type' => 'application/json')
        );
    }
}