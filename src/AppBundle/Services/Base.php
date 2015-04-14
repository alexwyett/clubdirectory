<?php

namespace AppBundle\Services;

use \AppBundle\Exceptions\APIException;
use \AppBundle\Exceptions\EntityNotFoundException;
use \AppBundle\Exceptions\ValidationException;
use Symfony\Component\HttpFoundation\Request;

/**
 * Base for all other Services
 *
 * @category  Services
 * @package   TOCC
 * @author    Alex <alex@wyett.co.uk>
 * @link      http://www.wyett.co.uk
 */
abstract class Base
{
    /**
     * Doctrine em
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * Symfony validator
     *
     * @var \Symfony\Component\Validator
     */
    protected $validator;

    /**
     * Symfony router used for path generation
     *
     * @var \Symfony\Bundle\FrameworkBundle\Routing\Router
     */
    protected $router;

    /**
     * Symfony current request
     *
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * Constructor
     *
     * @param \Doctrine\ORM\EntityManager $em The entity manager
     */
    public function __construct($em)
    {
        $this->em = $em;
    }

    /**
     * Set the validator
     *
     * @param \Symfony\Component\Validator $validator Symfony validator
     *
     * @return \AppBundle\Services\Base
     */
    public function setValidator($validator)
    {
        $this->validator = $validator;

        return $this;
    }

    /**
     * Return the validator component
     *
     * @return \Symfony\Component\Validator
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * Return the entity manager
     *
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEm()
    {
        return $this->em;
    }

    /**
     * Set the request object
     *
     * @param \Symfony\Component\HttpFoundation\Request $rs Request
     *
     * @return \AppBundle\Services\Base
     */
    public function setRequest(Request $rs)
    {
        $this->request = $rs;

        return $this;
    }

    /**
     * Return the request object
     *
     * @return \Symfony\Component\HttpFoundation\Reques
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Set the router
     *
     * @param \Symfony\Bundle\FrameworkBundle\Routing\Router $router Router
     *
     * @return \AppBundle\Services\Base
     */
    public function setRouter(\Symfony\Bundle\FrameworkBundle\Routing\Router $router)
    {
        $this->router = $router;

        return $this;
    }

    /**
     * Return the routing component
     *
     * @return \Symfony\Bundle\FrameworkBundle\Routing\Router
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * Returns the Class of an entity
     *
     * @param object $entity - the entity
     *
     * @return string
     */
    protected function _getEntityClass($entity)
    {
        $class = get_class($entity);

        if (!$class) {
            return false;
        }

        $classArray = explode('\\', $class);
        $entityName = end($classArray);
        return $entityName;
    }


    /**
     * Returns an Entity of the specified type, with the specified field having
     * the specified value!
     *
     * @param string   $entityName  - name of the entity to retrieve, e.g.
     *                                 ContactMethod
     * @param string   $searchValue - the value the $fieldName must be equal to
     *                                 for the entity to be returned
     * @param integer  $errorCode   - error number to return if entity not
     *                                 found, e.g. 120034
     * @param string   $fieldName   - name of the search field, e.g.
     *                                 Contactmethod (default = 'Id')
     * @param string   $statusCode  - HTTP error code to return if entity not
     *                                 found (default = '404')
     * @param boolean  $expected    - whether the caller expects to find the
     *                                 entity (false if checking for duplicates etc)
     *
     * @return object
     */
    protected function _findOneBy(
        $entityName,
        $searchValue,
        $errorCode,
        $fieldName = 'Id',
        $statusCode = '404',
        $expected = true
    ) {
        // create function name
        $function = 'findOneBy';

        if (!is_array($searchValue)) {
            $function .= ucfirst(strtolower($fieldName));
        }

        // get entity
        $entity = $this->getRepository(
            'AppBundle:'.$entityName
        )->$function($searchValue);

        if ($expected && !$entity) {
            throw new EntityNotFoundException(
                $entityName . ' not found',
                $errorCode,
                $statusCode
            );
        }

        return $entity;
    }

    /**
     * Validate and persist a given entity
     *
     * @param mixed $entity Entity you wish to validate
     *
     * @throws ValidationException
     *
     * @return \AppBundle\Services\Base
     */
    public function validateAndPersist(&$entity)
    {
        $this->validate($entity);

        $this->em->persist($entity);

        return $this;
    }

    /**
     * Validate and persist a given entity
     *
     * @param mixed $entity Entity you wish to validate
     *
     * @throws ValidationException
     *
     * @return \AppBundle\Services\Base
     */
    public function validate(&$entity)
    {
        $errors = $this->getValidator()->validate($entity);
        if (count($errors) > 0) {
            throw new ValidationException(
                'Validation exception',
                0,
                400,
                $errors
            );
        }

        return $this;
    }

    /**
     * Populate the object
     *
     * @param mixed    $object  Object to populate
     * @param stdClass $request Request object
     *
     * @return void
     */
    public function populateObject(&$object, $request)
    {
        // Remove not allowed fields
        $notAlloweds = array('id', 'authorised');
        foreach ($notAlloweds as $notAllowed) {
            if (isset($request->$notAllowed)) {
                unset($request->$notAllowed);
            }
        }
        
        foreach ($request as $key => $value) {

            // TODO: Use reflection to do this better (once annotations are
            // correct in the entities)

            if (in_array($value, array('true', 'false'), true)) {
                // cast value as a boolean
                $value = ($value == 'true') ? true : false;
            }

            $setter = 'set' . ucfirst($key);
            if (method_exists($object, $setter)) {
                // set method exists

                if($this->endsWith($key, 'datetime')) {
                    // cast value to DateTime
                    $value = new \DateTime($value);
                }

                if($this->endsWith($key, 'date')) {
                    // cast value to DateTime
                    $value = new \DateTime($value);
                }

                // set object property 'key' to $value
                $object->$setter($value);
            }
        }
    }


    /**
     * Check whether 'haystack' starts with 'needle'
     *
     * @param string $haystack string to check
     * @param string $needle   string to check for
     *
     * @return boolean
     */
    public function startsWith($haystack, $needle)
    {
         $length = strlen($needle);
         return (substr($haystack, 0, $length) === $needle);
    }

    /**
     * Check whether 'haystack' ends with 'needle'
     *
     * @param string $haystack string to check
     * @param string $needle   string to check for
     *
     * @return boolean
     */
    public function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }

    /**
     * Return an object repository
     *
     * @param string $respositoryName Repo name
     *
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    public function getRepository($respositoryName)
    {
        return $this->em->getRepository($respositoryName);
    }
    
    /**
     * Update an new entity from a request object
     * 
     * @param \AppBundle\Entity\Base $entity  Entity
     * @param stdClass               $request Request json
     * 
     * @return \AppBundle\EntityExtended\Base
     */
    public function update($entity, $request)
    {
        $this->populateObject($entity, $request);
        $this->validateAndPersist($entity);
        $this->getEm()->flush();
        
        return $entity;
    }
    
    /**
     * Return the entity repo
     * 
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    public function getEntityRepo()
    {
        return $this->getRepository(
            $this->getEntityName()
        );
    }
    
    /**
     * Return an array of tags
     * 
     * @return \AppBundle\EntityExtended\Base[]
     */
    public function getEntities()
    {
        return $this->getEntityRepo()->findAll();
    }
    
    /**
     * Return a entity by its id
     * 
     * @param integer $id Id
     * 
     * @return \AppBundle\EntityExtended\Base
     */
    public function getEntityById($id)
    {
        $ent = $this->getEntityRepo()->findOneById($id);
        if (!$ent) {
            throw new EntityNotFoundException('Entity not found', -1);
        }
        
        return $ent;
    }
    
    /**
     * Create a new entity from a request object
     * 
     * @param stdClass $request Request json
     * 
     * @return \AppBundle\EntityExtended\Base
     */
    public function create($request)
    {
        $entName = $this->getEntityPath();
        $ent = new $entName();
        
        return $this->update($ent, $request);
    }
    
    /**
     * Delete a given entity
     * 
     * @param \AppBundle\EntityExtended\Base $entity Entity
     * 
     * @return \AppBundle\Services\Base
     */
    public function delete($entity)
    {
        $this->getEm()->remove($entity);
        $this->getEm()->flush();
        
        return $this;
    }
}