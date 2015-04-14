<?php
namespace AppBundle\EntityExtended;

class Timeslot
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
            'from' => $this->getFromtime(),
            'till' => $this->getTilltime(),
            'description' => $this->getDescription(),
            'day' => $this->getTimeslotDay()->toArray()
        );
    }
}
