<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use HMACBundle\Exceptions\APIException;
use HMACBundle\Annotations\HMAC;

abstract class DefaultController extends \HMACBundle\Controller\DefaultController
{
    /**
     * Throw a new not found error
     * 
     * @param string $code Code
     * 
     * @throws \AppBundle\Exceptions\EntityNotFoundException
     */
    public function throwNotFoundError($code)
    {
        throw new \AppBundle\Exceptions\EntityNotFoundException(
            $code,
            decbin(ord($code))
        );
    }

    /**
     * Return the filter service
     *
     * @return \AppBundle\Services\Filter
     */
    public function getFilterService()
    {
        return $this->get('filter_service');
    }
}
