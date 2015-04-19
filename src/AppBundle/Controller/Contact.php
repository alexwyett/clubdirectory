<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use HMACBundle\Exceptions\APIException;
use HMACBundle\Annotations\HMAC;

class Contact extends DefaultController
{
    /**
     * @Route("/contact/{id}", name="contact_get", defaults={"_format": "_json"})
     * @Method("GET")
     * @param integer $id Contact Id
     *
     * @return array
     */
    public function getAction($id)
    {
        return $this->getContactService()->getEntityById($id)->toArray();
    }
    
    /**
     * @Route("/contact", name="contact_create")
     * @Method("POST")
     *
     * @HMAC(public=false, roles="CREATE")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction()
    {
        $contact = $this->getContactService()->create(
            $this->getPostData(true)
        );
        
        return $this->createdResponse(
            $this->generateUrl(
                'contact_get',
                array(
                    'id' => $contact->getId()
                )
            )
        );
    }
    
    /**
     * @Route("/contact/{id}", name="contact_update")
     * @Method("PUT")
     * 
     * @param integer $id Contact Id
     *
     * @HMAC(public=false, roles="UPDATE")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateAction($id)
    {
        $this->getContactService()->update(
            $this->getContactService()->getEntityById($id),
            $this->getPostData(true)
        );
        
        return $this->okResponse();
    }
    
    /**
     * @Route("/contact/{id}/email/{eid}", name="contact_email_get", defaults={"_format": "_json"})
     * @Method("GET")
     * 
     * @param integer $id  Contact Id
     * @param integer $eid Email Id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getEmailAction($id, $eid)
    {
        return $this->getContactService()->getContactAndEmailById(
            $id,
            $eid
        )->toArray();
    }
    
    /**
     * @Route("/contact/{id}/email", name="contact_email_create")
     * @Method("POST")
     * 
     * @param integer $id Contact Id
     *
     * @HMAC(public=false, roles="CREATE")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addEmailAction($id)
    {
        $email = $this->getContactService()->addEmail(
            $this->getContactService()->getEntityById($id),
            $this->getPostData(true)
        );
        
        return $this->createdResponse(
            $this->generateUrl(
                'contact_email_get',
                array(
                    'id' => $id,
                    'eid' => $email->getId()
                )
            )
        );
    }
    
    /**
     * @Route("/contact/{id}/email/{eid}", name="contact_email_delete")
     * @Method("DELETE")
     * 
     * @param integer $id  Contact Id
     * @param integer $eid Email Id
     *
     * @HMAC(public=false, roles="DELETE")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function removeEmailAction($id, $eid)
    {
        $this->getContactService()->removeEmail(
            $this->getContactService()->getEntityById($id),
            $this->getContactService()->getEmailById($eid)
        );
        
        return $this->okResponse();
    }
    
    /**
     * @Route("/contact/{id}/telephonenumber/{nid}", name="contact_telephonenumber_get", defaults={"_format": "_json"})
     * @Method("GET")
     * 
     * @param integer $id  Contact Id
     * @param integer $nid Number Id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getNumberAction($id, $nid)
    {
        return $this->getContactService()->getContactAndNumberById(
            $id,
            $nid
        )->toArray();
    }
    
    /**
     * @Route("/contact/{id}/telephonenumber", name="contact_telephonenumber_create")
     * @Method("POST")
     * 
     * @param integer $id Contact Id
     *
     * @HMAC(public=false, roles="CREATE")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addNumberAction($id)
    {
        $number = $this->getContactService()->addNumber(
            $this->getContactService()->getEntityById($id),
            $this->getPostData(true)
        );
        
        return $this->createdResponse(
            $this->generateUrl(
                'contact_telephonenumber_get',
                array(
                    'id' => $id,
                    'nid' => $number->getId()
                )
            )
        );
    }
    
    /**
     * @Route("/contact/{id}/telephonenumber/{nid}", name="contact_telephonenumber_delete")
     * @Method("DELETE")
     * 
     * @param integer $id  Contact Id
     * @param integer $nid Number Id
     *
     * @HMAC(public=false, roles="DELETE")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function removeNumberAction($id, $nid)
    {
        $this->getContactService()->removeNumber(
            $this->getContactService()->getEntityById($id),
            $this->getContactService()->getNumberById($nid)
        );
        
        return $this->okResponse();
    }
    
    /**
     * Get the contact service
     * 
     * @return \AppBundle\Services\Contact
     */
    public function getContactService()
    {
        return $this->get('contact_service');
    }
}
