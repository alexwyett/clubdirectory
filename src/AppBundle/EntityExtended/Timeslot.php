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
            'fromTime' => $this->getFromtime(),
            'tillTime' => $this->getTilltime(),
            'description' => $this->getDescription(),
            'day' => $this->getTimeslotDay()->toArray()
        );
    }
}
