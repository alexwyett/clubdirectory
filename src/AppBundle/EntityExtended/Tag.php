<?php
namespace AppBundle\EntityExtended;

class Tag extends Base
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
            'name' => $this->getName(),
            'slug' => $this->slugify($this->getName())
        );
    }
}
