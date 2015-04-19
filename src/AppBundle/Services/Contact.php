<?php

namespace AppBundle\Services;

use \AppBundle\Exceptions\APIException;
use \AppBundle\Exceptions\EntityNotFoundException;
use \AppBundle\Exceptions\ValidationException;
use Symfony\Component\HttpFoundation\Request;

/**
 * Contact service
 *
 * @category  Services
 * @package   TOCC
 * @author    Alex <alex@wyett.co.uk>
 * @link      http://www.wyett.co.uk
 */
class Contact extends Base
{
    /**
     * Return the entity name needed for the generic methods in the base service
     * 
     * @return string
     */
    public function getEntityName()
    {
        return 'AppBundle:Contact';
    }
    
    /**
     * Return the entity path needed for the generic methods in the base service
     * 
     * @return string
     */
    public function getEntityPath()
    {
        return '\AppBundle\Entity\Contact';
    }
    
    /**
     * Create a new contact
     * 
     * @param stdClass $request Request object
     * 
     * @return \AppBundle\Entity\Contact
     */
    public function create($request)
    {
        $contact = new \AppBundle\Entity\Contact();
        $contact->setAuthorised(false);
        $address = new \AppBundle\Entity\Address();
        $contact->setAddress($address);
        
        return $this->update($contact, $request);
    }
    
    /**
     * Return an email by its id
     * 
     * @param integer $id  Id
     * @param integer $eid Email Id
     * 
     * @return \AppBundle\Entity\Email
     */
    public function getContactAndEmailById($id, $eid)
    {
        $contact = $this->getEntityById($id);
        foreach ($contact->getContactEmail() as $email) {
            if ($email->getId() == $eid) {
                return $email;
            }
        }
        
        throw new EntityNotFoundException('Email not found', -1);
    }
    
    /**
     * Return an email by its id
     * 
     * @param integer $id Id
     * 
     * @return \AppBundle\Entity\Email
     */
    public function getEmailById($id)
    {
        $email = $this->_getEmailRepo()->findOneById($id);
        if (!$email) {
            throw new EntityNotFoundException('Email not found', -1);
        }
        
        return $email;
    }
    
    /**
     * Return an number by its id
     * 
     * @param integer $id Id
     * 
     * @return \AppBundle\Entity\Telephone
     */
    public function getNumberById($id)
    {
        $number = $this->_getNumberRepo()->findOneById($id);
        if (!$number) {
            throw new EntityNotFoundException('Telephone not found', -1);
        }
        
        return $number;
    }
    
    
    
    /**
     * Return an phone number by its id
     * 
     * @param integer $id  Id
     * @param integer $nid Number Id
     * 
     * @return \AppBundle\Entity\TelephoneNumber
     */
    public function getContactAndNumberById($id, $nid)
    {
        $contact = $this->getEntityById($id);
        foreach ($contact->getTelephoneNumber() as $num) {
            if ($num->getId() == $nid) {
                return $num;
            }
        }
        
        throw new EntityNotFoundException('Telephone number not found', -1);
    }
    
    /**
     * Add an email address to a contact
     * 
     * @param \AppBundle\Entity\Contact $contact Contact object
     * @param stdClass                  $request Request object
     * 
     * @return \AppBundle\Entity\Contact
     * 
     * @throws \AppBundle\Exceptions\FieldNotFoundException
     */
    public function addEmail($contact, $request)
    {
        if (!isset($request->email)) {
            throw new \AppBundle\Exceptions\FieldNotFoundException(
                'Email field not found',
                -1
            );
        }
        
        if (!$contact->contactHasEmail($request->email)) {
            $email = new \AppBundle\Entity\Email();
            $email->setEmail($request->email);
            $email->setContact($contact);
            $this->validateAndPersist($email);
            $contact->addContactEmail($email);
            $this->getEm()->flush();
        
            return $email;
        } else {
            foreach ($contact->getContactEmail() as $email) {
                if ($email->getEmail() == $request->email) {
                    return $email;
                }
            }
        }
    }
    
    /**
     * Remove an email from a contact
     * 
     * @param \AppBundle\Entity\Contact $contact Contact object
     * @param \AppBundle\Entity\Email   $email   Email object
     * 
     * @return \AppBundle\Entity\Contact
     * 
     * @throws \AppBundle\Exceptions\FieldNotFoundException
     */
    public function removeEmail($contact, $email)
    {
        if ($contact->getContactEmail()->contains($email)) {
            $contact->removeContactEmail($email);
            $this->getEm()->persist($email);
            $this->getEm()->persist($contact);
            $this->getEm()->remove($email);
            $this->getEm()->flush();
        } else {
            throw new EntityNotFoundException(
                'Email not found for this contact',
                -1
            );
        }
        
        return $contact;
    }
    
    /**
     * Add an telephone number to a contact
     * 
     * @param \AppBundle\Entity\Contact $contact Contact object
     * @param stdClass                  $request Request object
     * 
     * @return \AppBundle\Entity\Contact
     * 
     * @throws \AppBundle\Exceptions\FieldNotFoundException
     */
    public function addNumber($contact, $request)
    {
        $number = new \AppBundle\Entity\Telephone();
        $this->populateObject($number, $request);
        
        if (!$contact->contactHasNumber($number->getTelephoneNumber(), $number->getTelephoneNumberType())) {
            $number->setContact($contact);
            $this->validateAndPersist($number);

            $contact->addContactTelephone($number);
            $this->getEm()->persist($contact);
            $this->getEm()->flush();
        
            return $number;
        } else {
            foreach ($contact->getContactTelephone() as $num) {
                if ($num->getTelephoneNumber() == $number->getTelephoneNumber()
                    && $num->getTelephoneNumberType() == $number->getTelephoneNumberType()
                ) {
                    return $num;
                }
            }
        }
    }
    
    /**
     * Remove an email from a contact
     * 
     * @param \AppBundle\Entity\Contact   $contact Contact object
     * @param \AppBundle\Entity\Telephone $number  Telephone object
     * 
     * @return \AppBundle\Entity\Contact
     * 
     * @throws \AppBundle\Exceptions\FieldNotFoundException
     */
    public function removeNumber($contact, $number)
    {
        if ($contact->getContactTelephone()->contains($number)) {
            $contact->getContactTelephone()->removeElement($number);
            $this->getEm()->persist($contact);
            $this->getEm()->remove($number);
            $this->getEm()->flush();
        } else {
            throw new EntityNotFoundException(
                'Number not found for this contact',
                -1
            );
        }
        
        return $contact;
    }
    
    /**
     * Return an array of title objects
     * 
     * @return \AppBundle\Entity\Title[]
     */
    public function getTitles()
    {
        return $this->_getTitleRepo()->findAll();
    }
    
    /**
     * Populate a contact object
     * 
     * @param \AppBundle\Entity\Contact $contact Contact
     * @param stdClass                  $request Request object
     * 
     * @return \AppBundle\Services\Contact
     */
    public function populateObject(&$contact, $request)
    {
        if (isset($request->title)) {
            $title = $this->_getTitleRepo()->findOneBy(
                array(
                    'title' => $request->title
                )
            );
            
            if (!$title) {
                throw new EntityNotFoundException('Title not found', -1);
            } else {
                $contact->setTitle($title);
            }
            unset($request->title);
        }
        
        if (isset($request->address)) {
            $address = $contact->getAddress();
            $this->populateObject($address, $request->address);
            $contact->setAddress($address);
            $address->setContact($contact);
            $this->validateAndPersist($address);
            
            unset($request->address);
        }
        
        parent::populateObject($contact, $request);
        
        return $this;
    }
    
    /**
     * Return the telephone repo
     * 
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    private function _getNumberRepo()
    {
        return $this->getRepository('AppBundle:Telephone');
    }
    
    /**
     * Return the email repo
     * 
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    private function _getEmailRepo()
    {
        return $this->getRepository('AppBundle:Email');
    }
    
    /**
     * Return the title repo
     * 
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    private function _getTitleRepo()
    {
        return $this->getRepository('AppBundle:Title');
    }
}