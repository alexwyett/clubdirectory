<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use HMACBundle\Exceptions\APIException;
use HMACBundle\Annotations\HMAC;

class Venue extends DefaultController
{
    /**
     * @Route("/venue", name="venue_list", defaults={"_format": "_json"})
     * @Method("GET")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        $venues = array();
        foreach ($this->getVenueService()->getEntities() as $venue) {
            $venues[] = $venue->toArray();
        }
        
        return $venues;
    }
    
    /**
     * @Route("/venue/{id}", name="venue_get", defaults={"_format": "_json"})
     * @Method("GET")
     * @param integer $id Tag Id
     *
     * @return array
     */
    public function getAction($id)
    {
        return $this->getVenueService()->getEntityById($id)->toArray();
    }
    
    /**
     * @Route("/venue", name="venue_create")
     * @Method("POST")
     *
     * @HMAC(public=false, roles="CREATE")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction()
    {
        $venue = $this->getVenueService()->create(
            $this->getPostData(true)
        );
            
        return $this->createdResponse(
            $this->generateUrl(
                'venue_get',
                array(
                    'id' => $venue->getId()
                )
            )
        );
    }
    
    /**
     * @Route("/venue/{id}", name="venue_update")
     * @Method("PUT")
     * @param integer $id Venue Id
     *
     * @HMAC(public=false, roles="UPDATE")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateAction($id)
    {
        $this->getVenueService()->update(
            $this->getVenueService()->getEntityById($id),
            $this->getPostData(true)
        );

        return $this->okResponse();
    }
    
    /**
     * Get the venue service
     * 
     * @return \AppBundle\Services\Venue
     */
    public function getVenueService()
    {
        return $this->get('venue_service');
    }
}
