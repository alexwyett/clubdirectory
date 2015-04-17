<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use HMACBundle\Exceptions\APIException;
use HMACBundle\Annotations\HMAC;

class Tag extends DefaultController
{
    /**
     * @Route("/tag", name="tag_list", defaults={"_format": "_json"})
     * @Method("GET")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        $tags = array();
        foreach ($this->getTagService()->getEntities() as $tag) {
            $tags[] = $tag->toArray();
        }
        
        return $tags;
    }
    
    /**
     * @Route("/tag/{id}", name="tag_get", defaults={"_format": "_json"})
     * @Method("GET")
     * @param integer $id Tag Id
     *
     * @return array
     */
    public function getAction($id)
    {
        return $this->getTagService()->getEntityById($id)->toArray();
    }
    
    /**
     * @Route("/tag", name="tag_create")
     * @Method("POST")
     *
     * @HMAC(public=false, roles="CREATE")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction()
    {   
        $tag = $this->getTagService()->create(
            $this->getPostData(true)
        );
            
        return $this->createdResponse(
            $this->generateUrl(
                'tag_get',
                array(
                    'id' => $tag->getId()
                )
            )
        );
    }
    
    /**
     * @Route("/tag/{id}", name="tag_update")
     * @Method("PUT")
     * @param integer $id Tag Id
     *
     * @HMAC(public=false, roles="UPDATE")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateAction($id)
    {
        $this->getTagService()->update(
            $this->getTagService()->getEntityById($id),
            $this->getPostData(true)
        );

        return $this->okResponse();
    }
    
    /**
     * Get the tag service
     * 
     * @return \AppBundle\Services\Tag
     */
    public function getTagService()
    {
        return $this->get('tag_service');
    }
}
