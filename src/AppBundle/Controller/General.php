<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use HMACBundle\Exceptions\APIException;
use HMACBundle\Annotations\HMAC;

class General extends DefaultController
{
    /**
     * @Route("/", name="homepage", defaults={"_format": "_json"})
     * @Method("GET")
     *
     * @HMAC(public=false)
     *
     * @return array
     */
    public function indexAction()
    {
        return array();
    }
    
    /**
     * @Route("/day", name="day_get", defaults={"_format": "_json"})
     * @Method("GET")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dayAction()
    {
        $entities = array();
        foreach ($this->getDayService()->getEntities() as $entity) {
            $entities[] = $entity->toArray();
        }
        
        return $entities;
    }
    
    /**
     * @Route("/title", name="title_get", defaults={"_format": "_json"})
     * @Method("GET")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function titleAction()
    {
        $entities = array();
        foreach ($this->getTitleService()->getEntities() as $entity) {
            $entities[] = $entity->toArray();
        }
        
        return $entities;
    }
    
    /**
     * @Route("/{entity}/{id}/authorise", name="generic_authorise")
     * @Method("PUT")
     * 
     * @param string  $entity Entity Name (camelcase)
     * @param integer $id     Contact Id
     *
     * @HMAC(public=false, roles="ADMIN")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function authoriseAction($entity, $id)
    {
        $service = $this->_getServiceByEntity($entity);
        $object = $service->getEntityById($id);
        $object->setAuthorised(true);
        $this->getEm()->persist($object);
        $this->getEm()->flush();

        return $this->okResponse();
    }
    
    /**
     * @Route("/{entity}/{id}/deauthorise", name="generic_deauthorise")
     * @Method("PUT")
     * 
     * @param string  $entity Entity Name (camelcase)
     * @param integer $id     Contact Id
     *
     * @HMAC(public=false, roles="ADMIN")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deauthoriseAction($entity, $id)
    {
        $service = $this->_getServiceByEntity($entity);
        $object = $service->getEntityById($id);
        $object->setAuthorised(false);
        $this->getEm()->persist($object);
        $this->getEm()->flush();

        return $this->okResponse();
    }
    
    /**
     * @Route("/{entity}/{id}", name="generic_delete")
     * @Method("DELETE")
     * 
     * @param string  $entity Entity Name (camelcase)
     * @param integer $id     Contact Id
     *
     * @HMAC(public=false, roles="DELETE")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($entity, $id)
    {
        $service = $this->_getServiceByEntity($entity);
        $object = $service->getEntityById($id);
        $this->getEm()->remove($object);
        $this->getEm()->flush();

        return $this->okResponse();
    }
    
    /**
     * Get the day service
     * 
     * @return \AppBundle\Services\Day
     */
    public function getDayService()
    {
        return $this->get('day_service');
    }
    
    /**
     * Get the title service
     * 
     * @return \AppBundle\Services\Title
     */
    public function getTitleService()
    {
        return $this->get('title_service');
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
    
    /**
     * Get the club service
     * 
     * @return \AppBundle\Services\Club
     */
    public function getClubService()
    {
        return $this->get('club_service');
    }
    
    /**
     * Get a service by its entity name
     * 
     * @param string $entity Entity Name
     * 
     * @return \AppBundle\Services\Base
     * 
     * @throws \AppBundle\Exceptions\ServiceNotFoundException
     */
    private function _getServiceByEntity($entity)
    {
        $entityName = ucfirst($entity);
        $serviceGetter = 'get' . $entityName . 'Service';
        if (method_exists($this, $serviceGetter)) {
            return $this->$serviceGetter();
        } else {
            throw new \AppBundle\Exceptions\ServiceNotFoundException(
                'Service for ' . $entityName . ' does not exist',
                -1
            );
        }
    }
}
