<?php
namespace AppBundle\EntityExtended;

class ClubVenue
{
    /**
     * To array function
     * 
     * @return array
     */
    public function toArray()
    {
        $timeSlots = array();
        foreach ($this->getClubVenueTimeSlot() as $clubVenueTimeSlot) {
            $timeSlots[] = $clubVenueTimeSlot->getTimeslot()->toArray();
        }
        
        return array(
            'id' => $this->getId(),
            'venue' => $this->getVenue()->toArray(),
            'timeslots' => $timeSlots
        );
    }
}
