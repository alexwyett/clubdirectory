<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use HMACBundle\Exceptions\APIException;
use HMACBundle\Annotations\HMAC;

class Link extends DefaultController
{
    /**
     * @Route("/link", name="link_list", defaults={"_format": "_json"})
     * @Method("GET")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        $links = array();
        foreach ($this->getLinkService()->getEntities() as $link) {
            $links[] = $link->toArray();
        }
        
        return $links;
    }
    
    /**
     * @Route("/link/{id}", name="link_get", defaults={"_format": "_json"})
     * @Method("GET")
     * @param integer $id Link Id
     *
     * @return array
     */
    public function getAction($id)
    {
        return $this->getLinkService()->getEntityById($id)->toArray();
    }
    
    /**
     * @Route("/link", name="link_create")
     * @Method("POST")
     *
     * @HMAC(public=false, roles="CREATE")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction()
    {
        $link = $this->getLinkService()->create(
            $this->getPostData(true)
        );
            
        return $this->createdResponse(
            $this->generateUrl(
                'link_get',
                array(
                    'id' => $link->getId()
                )
            )
        );
    }
    
    /**
     * @Route("/link/{id}", name="link_update")
     * @Method("PUT")
     * @param integer $id Link Id
     *
     * @HMAC(public=false, roles="UPDATE")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateAction($id)
    {
        $this->getLinkService()->update(
            $this->getLinkService()->getEntityById($id),
            $this->getPostData(true)
        );

        return $this->okResponse();
    }
    
    /**
     * Get the link service
     * 
     * @return \AppBundle\Services\Link
     */
    public function getLinkService()
    {
        return $this->get('link_service');
    }
}
