<?php

namespace AppBundle\EntityExtended;

abstract class Base
{
    /**
     * Returns the Class of an entity
     *
     * @param object $entity The entity
     *
     * @return string
     */
    protected function getEntityClass($entity)
    {
        $class = get_class($entity);
        
        if(!$class) {
            return false;
        }

        $classArray = explode('\\', $class);
        $entityName = end($classArray);
        return $entityName;
    }
    
    /**
     * Slugify a string
     * 
     * @param string $string String to turn into a slug
     * 
     * @return string
     */
    protected function slugify($string)
    {
        $search = array('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
        $replace = array('s', 't', 's', 't', 's', 't', 's', 't', 'i', 'a', 'a', 'i', 'a', 'a', 'e', 'E');
        $str = str_ireplace($search, $replace, strtolower(trim($string)));
        $str = preg_replace('/[^\w\d\-\ ]/', '', $str);
        $str = str_replace(' ', '-', $str);
        return preg_replace('/\-{2,}/', '-', $str);
    }
}