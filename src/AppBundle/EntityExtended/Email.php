<?php
namespace AppBundle\EntityExtended;

class Email
{
    /**
     * To array function
     * 
     * @return array
     */
    public function toArray()
    {
        return array(
            'id' => $this->getId(),
            'email' => $this->getEmail()
        );
    }
}
