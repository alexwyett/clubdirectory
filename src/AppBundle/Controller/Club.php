<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use HMACBundle\Annotations\HMAC;

class Club extends DefaultController
{
    /**
     * @Route("/club", name="club_list", defaults={"_format": "_json"})
     * @Method("GET")
     *
     * @return array
     */
    public function listAction()
    {
        $filter = $this->getFilterService();
        $filter->setValidFilters($this->_getClubFilters());
        $clubs = $filter->getEntities('AppBundle:Club');

        foreach ($clubs as $club) {
            $filter->addElement(
                $club->toArray()
            );
        }

        return $this->jsonResponse(
            $filter->toArray()
        );
    }

    /**
     * Lists all filters.
     * 
     * @Route("/club", name="club_filter", defaults={"_format": "_json"})     *
     * @Method("OPTIONS")
     *
     * @return array
     */
    public function filterAction()
    {
        $filters = array();
        foreach ($this->_getClubFilters() as $index => $filter) {
            $filters[$index] = $filter['description'];
        }
        return $filters;
    }
    
    /**
     * @Route("/club/{id}", name="club_get", defaults={"_format": "_json"})
     * @Method("GET")
     * @param integer $id Club Id
     *
     * @return array
     */
    public function getAction($id)
    {
        return $this->getClubService()->getEntityById($id)->toArray();
    }
    
    /**
     * @Route("/club/{id}", name="club_update")
     * @Method("PUT")
     * @param integer $id Club Id
     *
     * @HMAC(public=false, roles="UPDATE")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateAction($id)
    {
        $this->getClubService()->update(
            $this->getClubService()->getEntityById($id),
            $this->getPostData(true)
        );

        return $this->okResponse();
    }
    
    /**
     * @Route("/club", name="club_create")
     * @Method("POST")
     *
     * @HMAC(public=false, roles="CREATE")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction()
    {
        $club = $this->getClubService()->create(
            $this->getPostData(true)
        );
            
        return $this->createdResponse(
            $this->generateUrl(
                'club_get',
                array(
                    'id' => $club->getId()
                )
            )
        );
    }
    
    /**
     * @Route("/club/{id}/contact/{cid}", name="club_contact_add")
     * @Method("PUT")
     * 
     * @param integer $id  Club Id
     * @param integer $cid Contact Id
     *
     * @HMAC(public=false, roles="WRITE")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addContactToClubAction($id, $cid)
    {
        $this->getClubService()->addContact(
            $this->getClubService()->getEntityById($id),
            $this->getContactService()->getEntityById($cid)
        );

        return $this->okResponse(201);
    }
    
    /**
     * @Route("/club/{id}/contact/{cid}", name="club_contact_delete")
     * @Method("DELETE")
     * 
     * @param integer $id  Club Id
     * @param integer $cid Contact Id
     *
     * @HMAC(public=false, roles="DELETE")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function removeContactFromClubAction($id, $cid)
    {
        $this->getClubService()->removeContact(
            $this->getClubService()->getEntityById($id),
            $this->getContactService()->getEntityById($cid)
        );

        return $this->okResponse();
    }
    
    /**
     * @Route("/club/{id}/tag/{tid}", name="club_tag_add")
     * @Method("PUT")
     * 
     * @param integer $id  Club Id
     * @param integer $tid Tag Id
     *
     * @HMAC(public=false, roles="WRITE")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addTagToClubAction($id, $tid)
    {
        $this->getClubService()->addTag(
            $this->getClubService()->getEntityById($id),
            $this->getTagService()->getEntityById($tid)
        );

        return $this->okResponse(201);
    }
    
    /**
     * @Route("/club/{id}/tag/{tid}", name="club_tag_delete")
     * @Method("DELETE")
     * 
     * @param integer $id  Club Id
     * @param integer $tid Tag Id
     *
     * @HMAC(public=false, roles="DELETE")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function removeTagFromClubAction($id, $tid)
    {
        $this->getClubService()->removeTag(
            $this->getClubService()->getEntityById($id),
            $this->getTagService()->getEntityById($tid)
        );

        return $this->okResponse();
    }
    
    /**
     * @Route("/club/{id}/link/{tid}", name="club_link_add")
     * @Method("PUT")
     * 
     * @param integer $id  Club Id
     * @param integer $tid Link Id
     *
     * @HMAC(public=false, roles="WRITE")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addLinkToClubAction($id, $tid)
    {
        $this->getClubService()->addLink(
            $this->getClubService()->getEntityById($id),
            $this->getLinkService()->getEntityById($tid)
        );

        return $this->okResponse(201);
    }
    
    /**
     * @Route("/club/{id}/link/{tid}", name="club_link_delete")
     * @Method("DELETE")
     * 
     * @param integer $id  Club Id
     * @param integer $tid Link Id
     *
     * @HMAC(public=false, roles="DELETE")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function removeLinkFromClubAction($id, $tid)
    {
        $this->getClubService()->removeLink(
            $this->getClubService()->getEntityById($id),
            $this->getLinkService()->getEntityById($tid)
        );

        return $this->okResponse();
    }
    
    /**
     * @Route("/club/{id}/clubvenue/{cid}", name="clubvenue_get", defaults={"_format": "_json"})
     * @Method("GET")
     * @param integer $id  Club Id
     * @param integer $cid Club venue Id
     *
     * @return array
     */
    public function getClubVenueAction($id, $cid)
    {
        return $this->getClubService()->getClubVenue(
            $this->getClubService()->getEntityById($id),
            $cid
        )->toArray();
    }
    
    /**
     * @Route("/club/{id}/clubvenue", name="clubvenue_add", defaults={"_format": "_json"})
     * @Method("POST")
     * @param integer $id  Club Id
     *
     * @HMAC(public=false, roles="WRITE")
     *
     * @return array
     */
    public function addClubVenueAction($id)
    {
        $clubVenue = $this->getClubVenueService()->createClubVenue(
            $this->getClubService()->getEntityById($id),
            $this->getPostData(true)
        );
        
        return $this->createdResponse(
            $this->generateUrl(
                'clubvenue_get',
                array(
                    'id' => $id,
                    'cid' => $clubVenue->getId()
                )
            )
        );
    }
    
    /**
     * @Route("/club/{id}/clubvenue/{cvid}", name="clubvenue_delete", defaults={"_format": "_json"})
     * @Method("DELETE")
     * @param integer $id   Club Id
     * @param integer $cvid Venue Id
     *
     * @HMAC(public=false, roles="DELETE")
     *
     * @return array
     */
    public function removeClubVenueAction($id, $cvid)
    {
        $this->getClubVenueService()->removeClubVenue(
            $this->getClubService()->getClubVenue(
                $this->getClubService()->getEntityById($id),
                $cvid
            )
        );
        
        return $this->okResponse();
    }
    
    /**
     * @Route("/club/{id}/clubvenue/{cid}/timeslot/{tid}", name="clubvenue_timeslot_add", defaults={"_format": "_json"})
     * @Method("POST")
     * @param integer $id  Club Id
     * @param integer $cid Club Venue Id
     * @param integer $tid Venue Id
     *
     * @HMAC(public=false, roles="WRITE")
     *
     * @return array
     */
    public function addTimeslotClubVenueAction($id, $cid, $tid)
    {
        $this->getClubVenueService()->addTimeslot(
            $this->getClubVenueService()->getEntityById($cid),
            $this->getTimeslotService()->getEntityById($tid)
        );
        
        return $this->okResponse(201);
    }
    
    /**
     * @Route("/club/{id}/clubvenue/{cid}/timeslot/{tid}", name="clubvenue_timeslot_delete", defaults={"_format": "_json"})
     * @Method("DELETE")
     * @param integer $id  Club Id
     * @param integer $cid Club Venue Id
     * @param integer $tid Venue Id
     *
     * @HMAC(public=false, roles="DELETE")
     *
     * @return array
     */
    public function removeTimeslotClubVenueAction($id, $cid, $tid)
    {
        $this->getClubVenueService()->removeTimeslot(
            $this->getClubVenueService()->getEntityById($cid),
            $this->getTimeslotService()->getEntityById($tid)
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
     * Get the tag service
     * 
     * @return \AppBundle\Services\Tag
     */
    public function getTagService()
    {
        return $this->get('tag_service');
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
    
    /**
     * Get the link service
     * 
     * @return \AppBundle\Services\Link
     */
    public function getLinkService()
    {
        return $this->get('link_service');
    }
    
    /**
     * Get the club venue service
     * 
     * @return \AppBundle\Services\ClubVenue
     */
    public function getClubVenueService()
    {
        return $this->get('clubvenue_service');
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

    /**
     * Return actor filters
     *
     * @return array
     */
    private function _getClubFilters()
    {
        return array(
            'name' => array(
                'mapping' => 'name',
                'description' => 'Name'
            ),
            'tag' => array(
                'mapping' => 'id',
                'description' => 'Tag Short Name',
                'dependancy' => array(
                    'mapping' => 'id',
                    'parent' => 'getClub',
                    'entity' => 'AppBundle:ClubTag',
                    'dependancy' => array(
                        'mapping' => 'name',
                        'parent' => 'getClubTag',
                        'entity' => 'AppBundle:Tag'
                    )
                )
            )
        );
    }
}
