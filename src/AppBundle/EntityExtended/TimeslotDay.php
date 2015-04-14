<?php
namespace AppBundle\EntityExtended;

class TimeslotDay
{
    /**
     * To array function
     * 
     * @return array
     */
    public function toArray()
    {
        return array(
            'day' => $this->getDay(),
            'dayNumber' => $this->getDayNumber()
        );
    }
}
