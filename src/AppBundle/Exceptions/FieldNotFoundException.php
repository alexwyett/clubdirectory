<?php

namespace AppBundle\Exceptions;

class FieldNotFoundException extends APIException
{
    /**
     * Creates a new FieldNotFoundException object
     *
     * @param string $errorDescription Description associated with this error
     * @param string $errorCode        Code associated with this error
     *
     * @return void
     */
    public function __construct($errorDescription, $errorCode)
    {
        parent::__construct($errorDescription, $errorCode, 400);
    }
}