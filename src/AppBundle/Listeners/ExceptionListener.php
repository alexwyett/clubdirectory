<?php

namespace AppBundle\Listeners;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Exceptions\APIException;
use AppBundle\Exceptions\ValidationException;
use HMACBundle\Exceptions\APIException as HMACException;
use AppBundle\Responses\ErrorResponse;

/**
 * Listener for exceptions
 *
 * @category  Listener
 * @package   TOCC
 * @author    Carlton Software <support@carltonsoftware.co.uk>
 * @copyright 2014 Carlton Software
 * @license   All rights reserved
 * @link      http://www.carltonsoftware.co.uk
 */
class ExceptionListener
{
    /**
     * kernel
     *
     * @var mixed
     * @access protected
     */
    protected $kernel;

    /**
     * __construct
     *
     * @param ContainerInterface $kernel
     *
     * @access public
     * @return void
     */
    public function __construct($kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * Listen to kernel exceptions and handle them appropriately by returning 
     * their contents in the response
     *
     * @param Event $event the event that has occurred
     *
     * @todo add an appropriate HTTP status code in addition to the exception contents
     * @see http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html
     *
     * @return void
     */
    public function onKernelException(Event $event)
    {
        $exception = $event->getException();
        $errorCode = $exception->getCode();
        $errorDescription = $exception->getMessage();

        // If the exception is of type 'APIException', get the statusCode 
        // from the exception, otherwise default to 500 (Internal Server Error)
        if ($exception instanceof APIException 
            || $exception instanceof HMACException
        ) {
            $statusCode = $exception->getHTTPStatusCode();
        } else {
            $statusCode = 500;
        }
        
        // Add in errors if required
        if ($exception instanceof ValidationException) {
            $errors = array();
            foreach ($exception->getValidationError() as $error) {
                $errors[$error->getPropertyPath()] = $error->getMessage();
            }
            
            $errorDescription = json_encode(
                array(
                    'description' => $exception->getMessage(),
                    'errors' => $errors
                )
            );
        }
        
        if ($this->kernel->getEnvironment() == 'dev' 
            || $this->kernel->getEnvironment() == 'test'
        ) {
            $errorTrace = $exception->getTrace();
            $errorLocation = sprintf(
                '%s +%d', 
                $exception->getFile(), 
                $exception->getLine()
            );
            //Log the error using monolog
            $this->kernel->getContainer()->get('logger')->err($errorDescription,
                                              array('exception' => $exception));
        } else {
            $errorTrace = null;
            $errorLocation = null;
        }

        // Generate an error response, and send back
        $errorResponse = new ErrorResponse(
            $statusCode, 
            $errorCode, 
            $errorDescription, 
            $errorTrace, 
            $errorLocation,
            get_class($exception)
        );
        $event->setResponse($errorResponse);
    }
}
