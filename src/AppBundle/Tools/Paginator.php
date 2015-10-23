<?php

namespace AppBundle\Tools;

use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Symfony\Component\Routing\RouterInterface;

class Paginator implements \Iterator
{
    const LIMIT = 10;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var int limit the number of result
     */
    private $limit;

    /**
     * @var string the parameter name for page number
     */
    private $page_parameter_name;

    /**
     * @var Query the request
     */
    private $query;

    /**
     * @var DoctrinePaginator the doctrine paginator
     */
    private $doctrine_paginator;

    /**
     * @var \ArrayIterator the doctrine iterator
     */
    private $iterator;

    /**
     * @var int the current page
     */
    private $current_page = 1;

    /**
     * @var int the total number of result
     */
    private $count;

    /**
     * @var null the route name for pagination link
     */
    private $route = null;

    /**
     * @var array additional parameters for route
     */
    private $route_parameters = [];

    /**
     * @param RouterInterface $router
     * @param int $limit
     * @param string $page_parameter_name
     */
    public function __construct(RouterInterface $router, $limit = self::LIMIT, $page_parameter_name = 'page')
    {
        $this->router = $router;
        $this->limit = $limit;
        $this->page_parameter_name = $page_parameter_name;
    }

    /**
     * Init the query
     * @param Query $query
     * @return $this
     */
    public function setQuery(Query $query)
    {
        $this->query = $query;
        return $this;
    }

    /**
     * Set the current page
     * @param int $current_page
     * @return $this
     */
    public function setCurrentPage($current_page)
    {
        $this->current_page = (int)$current_page;
        return $this;
    }

    /**
     * Set the number items by page
     * @param int $limit
     * @return $this
     */
    public function setLimit($limit)
    {
        $this->limit = (int)$limit;
        return $this;
    }

    /**
     * Set the page parameter name
     * @param string $page_parameter_name
     * @return $this
     */
    public function setPageParameterName($page_parameter_name)
    {
        $this->page_parameter_name = $page_parameter_name;
        return $this;
    }

    /**
     * Define the default routing parameters
     * @param $route
     * @param array $route_parameters
     * @return $this
     */
    public function setRouting($route, array $route_parameters = [])
    {
        $this->route = $route;
        $this->route_parameters = $route_parameters;
        return $this;
    }

    /**
     * Get the total number of item for query
     * @return int
     */
    public function count()
    {
        $this->initQuery();
        return $this->count;
    }

    /**
     * Get the current page
     * @return int
     */
    public function currentPage()
    {
        return $this->current_page;
    }

    /**
     * Get the number of page
     * @return int
     */
    public function nbPages()
    {
        return (int)ceil($this->count() / $this->limit);
    }

    /**
     * Indicate if current page is the first
     * @return bool
     */
    public function isFirstPage()
    {
        return 1 === $this->current_page;
    }

    /**
     * Indicate if current page is the last
     * @return bool
     */
    public function isLastPage()
    {
        return $this->nbPages() === $this->current_page;
    }

    /**
     * @param int $page
     * @param string|null $route
     * @param array $route_parameters
     * @param bool $absolute
     * @return string
     * @throws \InvalidArgumentException
     */
    public function getRoute($page, $route = null, array $route_parameters = null, $absolute = false)
    {
        if (null === $route) {
            if (null === $this->route) {
                throw new \InvalidArgumentException('route must be define');
            }

            $route = $this->route;
        }

        if (null === $route_parameters) {
            $route_parameters = $this->route_parameters;
        }

        $route_parameters[$this->page_parameter_name] = (int)$page;

        return $this->router->generate($route, $route_parameters, $absolute);
    }

    public function getFirstRoute($route = null, array $route_parameters = null, $absolute = false)
    {
        return $this->getRoute(1, $route, $route_parameters, $absolute);
    }

    public function getLastRoute($route = null, array $route_parameters = null, $absolute = false)
    {
        return $this->getRoute($this->nbPages(), $route, $route_parameters, $absolute);
    }

    public function getPreviousRoute($route = null, array $route_parameters = null, $absolute = false)
    {
        return $this->getRoute($this->current_page - 1, $route, $route_parameters, $absolute);
    }

    public function getNextRoute($route = null, array $route_parameters = null, $absolute = false)
    {
        return $this->getRoute($this->current_page + 1, $route, $route_parameters, $absolute);
    }

    /**
     * Init the query into paginator
     */
    private function initQuery()
    {
        if (null !== $this->doctrine_paginator) {
            return;
        }

        $this->query
            ->setFirstResult(($this->current_page - 1) * $this->limit)
            ->setMaxResults($this->limit)
        ;

        $this->doctrine_paginator = new DoctrinePaginator($this->query);
        $this->count = $this->doctrine_paginator->count();
        $this->iterator = $this->doctrine_paginator->getIterator();
    }

    //
    // Iterator methods
    //

    /**
     * @return mixed
     */
    public function current()
    {
        $this->initQuery();
        return $this->iterator->current();
    }

    /**
     * @return mixed
     */
    public function key()
    {
        $this->initQuery();
        return $this->iterator->key();
    }

    /**
     * @return void
     */
    public function next()
    {
        $this->initQuery();
        $this->iterator->next();
    }

    /**
     * @return void
     */
    public function rewind()
    {
        $this->initQuery();
        $this->iterator->rewind();
    }

    /**
     * @return bool
     */
    public function valid()
    {
        $this->initQuery();
        return $this->iterator->valid();
    }
}
