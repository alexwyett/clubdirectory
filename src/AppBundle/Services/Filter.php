<?php

namespace AppBundle\Services;
use \Symfony\Component\DependencyInjection\ContainerInterface;
use \Doctrine\ORM\QueryBuilder;
use \Doctrine\ORM\EntityManager;

/**
 * Filter service.  Provides first level filtering for entities.
 *
 * @category  Services
 * @package   ClubDirectory
 * @author    Alex <alex@wyett.co.uk>
 * @link      http://www.wyett.co.uk
 */
class Filter
{
    /**
     * Object manager
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * Request Stack
     *
     * @var \Symfony\Component\HttpFoundation\Request
     */
    private $request;

    /**
     * Valid filters array
     *
     * @var array
     */
    private $validFilters = array();

    /**
     * Total results
     *
     * @var integer
     */
    private $total = 0;

    /**
     * Total time
     *
     * @var float
     */
    private $time = 0;

    /**
     * Elements array.  Required for output.
     *
     * @var array
     */
    private $elements = array();

    /**
     * Creates a new Customer object
     *
     * @param \Doctrine\ORM\EntityManager $em The entity manager
     *
     * @return void
     */
    public function __construct($em)
    {
        $this->em = $em;
    }

    /**
     * Return a filtered array of entities
     *
     * @param string  $entityName Full entity name (inluding Bundle Name)
     * @param boolean $setTotal   Flag to set total
     *
     * @return array
     */
    public function getEntities($entityName)
    {
        $start = microtime(true);

        $qb = $this->em->createQueryBuilder();
        $qb->select('w');
        $qb->from($entityName, 'w');

        $bookingFilters = $this->_getArrayFilter();
        foreach ($bookingFilters as $name => $value) {
            $filterSetting = $this->_getFilter($name);
            $value = $this->_getNestedFilter($filterSetting, $value);
            $this->addExpression($qb, 'w', $filterSetting['mapping'], $value);
        }

        $this->total = $qb->select(
            'COUNT(w)'
        )->getQuery()->getSingleScalarResult();

        $qb->select('w');
        $qb->setFirstResult($this->getPage());
        $qb->setMaxResults($this->getLimit());

        $query = $qb->getQuery();

        // Use dql to retrieve property objects
        $result = $query->getResult();

        $this->time = microtime(true) - $start;

        return $result;
    }

    /**
     * Set the request
     *
     * @param ContainerInterface $container
     *
     * @return FilterService
     */
    public function setRequest(ContainerInterface $container)
    {
        $this->request = $container->get('request');

        return $this;
    }

    /**
     * Return the total results
     *
     * @return integer
     */
    public function getTotal()
    {
        return (integer) $this->total;
    }

    /**
     * Return the time of the last transaction
     *
     * @return float
     */
    public function getTime()
    {
        return (float) $this->time;
    }

    /**
     * Set the valid filters
     *
     * @param array $validFilters Valid filters array
     *
     * @return \TOCC\BusinessBundle\Services\FilterService
     */
    public function setValidFilters(array $validFilters)
    {
        $this->validFilters = $validFilters;

        return $this;
    }

    /**
     * Add an element to the array
     *
     * @param mixed $element Element to add to array
     *
     * @return \TOCC\BusinessBundle\Services\FilterService
     */
    public function addElement($element)
    {
        array_push($this->elements, $element);

        return $this;
    }

    /**
     * Return the elements array
     *
     * @return array
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * Return an array of array filters
     *
     * @return array|boolean
     */
    private function _getArrayFilter()
    {
        $filter = $this->request->query->get('filter', false);
        $filters = array();
        $_filters = array();
        if ($filter) {
            parse_str(str_replace(':', '&', $filter), $filters);
            foreach ($filters as $_filter => $value) {
                if (trim($value) != '' && $this->_getFilter($_filter)) {
                    $_filters[$_filter] = $value;
                }
            }
        }

        return $_filters;
    }

    /**
     * Return valid filters array
     *
     * @return array
     */
    private function _getValidFilters()
    {
        return $this->validFilters;
    }

    /**
     * Return the filter
     *
     * @param string $filter Prospective filter
     *
     * @throws \TOCC\DefaultBundle\Exceptions\APIException
     *
     * @return string
     */
    private function _getFilter($filter)
    {
        $filters = $this->_getValidFilters();
        if (in_array($filter, array_keys($filters))) {
            return $filters[$filter];
        } else {
            throw new \AppBundle\Exceptions\APIException(
                'Invalid filter specified: ' . $filter,
                -1,
                400
            );
        }
    }

    /**
     * Return the limit for the filter
     *
     * @return integer
     */
    public function getLimit()
    {
        $limit = $this->request->query->get('limit', 10);

        return (integer) (is_numeric($limit) ? $limit : 10);
    }

    /**
     * Return the page for the filter
     *
     * @return integer
     */
    public function getPageInt()
    {
        $page = $this->request->query->get('page', 1);
        return (integer) (is_numeric($page) && $page > 1) ? $page : 1;
    }

    /**
     * Return the page number
     *
     * @return integer
     */
    public function getPage()
    {
        return (integer) ($this->getPageInt() - 1) * $this->getLimit();
    }

    /**
     * Recursive function to retrieve database values from the database.
     *
     * @param array $filter Mapping array
     * @param mixed $value  Mapping value
     *
     * @return mixed
     */
    private function _getNestedFilter($filter, $value)
    {
        if (isset($filter['dependancy'])) {
            $value = $this->_getNestedFilter($filter['dependancy'], $value);
        }

        if (isset($filter['entity']) && isset($filter['parent'])) {
            $value = $this->_getEntityIds(
                $filter['entity'],
                $filter['mapping'],
                $filter['parent'],
                $value
            );
        }

        return $value;
    }

    /**
     * Return an array of ids from given parameters
     *
     * @param string $entity Full entity name
     * @param string $field  Field to filter by
     * @param string $method Method to call
     * @param string $value  Comparison value
     *
     * @return array
     */
    private function _getEntityIds($entity, $field, $method, $value)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('w');
        $qb->from($entity, 'w');

        $this->addExpression($qb, 'w', $field, $value);

        $query = $qb->getQuery();

        $entities = $query->getResult();

        $ids = array();
        foreach ($entities as $entity) {
            if (method_exists($entity->$method(), 'getId')) {
                $ids[] = $entity->$method()->getId();
            } else if (method_exists($entity->$method(), 'filter')) {
                foreach ($entity->$method() as $ele) {
                    $ids[] = $ele->getId();
                }
            }
        }

        if (count($ids) == 0) {
            $ids = array(0);
        }

        return $ids;
    }

    /**
     * Add a query expression to the query
     *
     * @param QueryBuilder $qb    Query builder object
     * @param string       $alias Column alias
     * @param string       $field Field to query
     * @param mixed        $value Value to query
     *
     * @return void
     */
    public function addExpression(&$qb, $alias, $field, $value)
    {
        if (is_array($value)) {
            $expr = $qb->expr()->in($alias . '.' . $field, ':' . $field);
            $qb->andWhere($expr);
            $qb->setParameter($field, $value);
        } else {
            if (stristr($value, '|')) {
                $values = explode('|', $value);
                $expr = $qb->expr()->orx();
                foreach ($values as $i => $value) {
                    $expr->add(
                        $qb->expr()->eq($alias .'.'. $field, ':' . $field . $i)
                    );
                    $qb->setParameter($field . $i, $value);
                }
                $qb->andWhere($expr);
            } else if (substr($value, 0, 1) == '~') {
                $expr = $qb->expr()->like(
                    $alias . '.' . $field,
                    $qb->expr()->literal('%'. substr($value, 1) . '%')
                );
                $qb->andWhere($expr);
            } else {
                $expr = $qb->expr()->eq($alias . '.' . $field, ':' . $field);
                $qb->andWhere($expr);
                $qb->setParameter($field, $value);
            }
        }
    }

    /**
     * Array mapping function
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            'total' => $this->getTotal(),
            'page' => $this->getPageInt(),
            'limit' => $this->getLimit(),
            'time' => $this->getTime(),
            'elements' => $this->getElements()
        );
    }
}
