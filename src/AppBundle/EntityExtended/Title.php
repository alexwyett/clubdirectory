<?php
namespace AppBundle\EntityExtended;

class Title
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
            'title' => $this->getTitle()
        );
    }
}
