<?php
namespace AppBundle\EntityExtended;

class Telephone
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
            'number' => $this->getTelephoneNumber(),
            'type' => $this->getTelephoneNumberType()
        );
    }
}
