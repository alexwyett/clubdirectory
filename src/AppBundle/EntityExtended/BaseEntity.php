<?php
namespace AppBundle\EntityExtended;
use \Doctrine\Common\Collections\Criteria;

class BaseEntity extends Base
{
    /**
     * To array function
     *
     * @return array
     */
    public function toArray()
    {
        $data = array(
            'id' => $this->getId(),
            'published' => $this->getPublished(),
            'authorised' => $this->getAuthorised(),
            'type' => $this->getEntityClass($this)
        );
        
        switch ($this->getEntityClass($this)) {
        case 'Venue':
            $data['name'] = $this->getName();
            $data['address'] = ($this->getAddress()) ? $this->getAddress()->toArray() : null;
            
            break;
        case 'Club':
            $data['name'] = $this->getName();
            $data['description'] = $this->getDescription();
            
            $contacts = array();
            foreach ($this->getClubContact() as $contact) {
                $contacts[] = $contact->getContact()->toArray();
            }
            $data['contacts'] = $contacts;
            
            $clubVenues = array();
            foreach ($this->getClubVenue() as $clubVenue) {
                $clubVenues[] = $clubVenue->toArray();
            }
            $data['clubVenues'] = $clubVenues;
            
            $links = array();
            foreach ($this->getClubLink() as $clubLink) {
                $links[] = $clubLink->getLink()->toArray();
            }
            $data['links'] = $links;
            
            $tags = array();
            foreach ($this->getClubTag() as $clubTag) {
                $tags[] = $clubTag->getTag()->toArray();
            }
            $data['tags'] = $tags;
            
            break;
        case 'Contact':
            $data['title'] = $this->getTitle()->toArray();
            $data['firstName'] = $this->getFirstName();
            $data['surname'] = $this->getSurname();
            $data['role'] = $this->getRole();
            $data['private'] = $this->getPrivate();
            $data['address'] = ($this->getAddress()) ? $this->getAddress()->toArray() : null;
            
            $emails = array();
            foreach ($this->getContactEmail() as $email) {
                $emails[] = $email->toArray();
            }
            $data['contactEmails'] = $emails;
            
            $telephoneNumbers = array();
            foreach ($this->getContactTelephone() as $number) {
                $telephoneNumbers[] = $number->toArray();
            }
            $data['telephoneNumbers'] = $telephoneNumbers;
            
            break;
        }
        
        return $data;
    }
    
    /**
     * Search for an existing email address
     * 
     * @param string $emailAddress Email address
     * 
     * @return boolean
     */
    public function contactHasEmail($emailAddress)
    {
        $found = false;
        foreach ($this->getContactEmail() as $email) {
            if ($emailAddress == $email->getEmail()) {
                $found = true;
            }
        }
        
        return $found;
    }
}
