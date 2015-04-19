<?php
namespace AppBundle\EntityExtended;

class Address
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
            'line1' => $this->getLine1(),
            'line2' => $this->getLine2(),
            'town' => $this->getTown(),
            'county' => $this->getCounty(),
            'postcode' => $this->getPostcode(),
            'latitude' => (float) $this->getLatitude(),
            'longitude' => (float) $this->getLongitude()
        );
    }
}
