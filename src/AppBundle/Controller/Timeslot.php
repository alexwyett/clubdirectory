<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use HMACBundle\Exceptions\APIException;
use HMACBundle\Annotations\HMAC;

class Timeslot extends DefaultController
{
    /**
     * @Route("/timeslot/{id}", name="timeslot_get", defaults={"_format": "_json"})
     * @Method("GET")
     * @param integer $id Tag Id
     *
     * @return array
     */
    public function getAction($id)
    {
        return $this->getTimeslotService()->getEntityById($id)->toArray();
    }
    
    /**
     * @Route("/timeslot", name="timeslot_create")
     * @Method("POST")
     *
     * @HMAC(public=false, roles="CREATE")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction()
    {
        $timeslot = $this->getTimeslotService()->create(
            $this->getPostData(true)
        );
            
        return $this->createdResponse(
            $this->generateUrl(
                'timeslot_get',
                array(
                    'id' => $timeslot->getId()
                )
            )
        );
    }
    
    /**
     * @Route("/timeslot/{id}", name="timeslot_update")
     * @Method("PUT")
     * @param integer $id Timeslot Id
     *
     * @HMAC(public=false, roles="UPDATE")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateAction($id)
    {
        $this->getTimeslotService()->update(
            $this->getTimeslotService()->getEntityById($id),
            $this->getPostData(true)
        );

        return $this->okResponse();
    }
    
    /**
     * Get the timeslot service
     * 
     * @return \AppBundle\Services\Timeslot
     */
    public function getTimeslotService()
    {
        return $this->get('timeslot_service');
    }
}
