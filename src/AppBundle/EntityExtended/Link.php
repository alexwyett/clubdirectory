<?php
namespace AppBundle\EntityExtended;

class Link
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
            'link' => $this->getLink(),
            'description' => $this->getDescription(),
            'linkType' => $this->getLinkType()
        );
    }
}
