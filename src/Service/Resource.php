<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2017-11-06 13:08:40
 * @Email:  dan.marinescu79@icloud.com
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2017-11-06 13:09:26
 * @Last Modified email: dan.marinescu79@icloud.com
 */

namespace AclAdmin\Service;

use AclAdmin\Entity\Route as Entity;
use Doctrine\Common\Persistence\ObjectManager;

class Resource
{
    protected $objectManager;
    protected $config;
    protected $routes = [];

    public function __construct(ObjectManager $objectManager, array $config)
    {
        $this->objectManager = $objectManager;
        $this->config        = $config;
    }

    public function getAll()
    {
        return $this->objectManager->getRepository(Entity::class)->findAll();
    }

    public function refreshRoutes(array $childRoutes = [], $parent = null)
    {
        if (empty($childRoutes)) {
            $routes = $this->config['router']['routes'];
        } else {
            $routes = $childRoutes;
        }

        foreach ($routes as $route => $options) {
            $currentRoute = !empty($parent) ? $parent . '/' . $route : $route;
            $this->setRoutes($currentRoute);
            if (isset($options['child_routes']) && !empty($options['child_routes'])) {
                $this->refreshRoutes($options['child_routes'], $currentRoute);
            }
        }
        return $this;
    }

    public function saveAll(array $routes)
    {
        foreach ($routes as $route) {
            $this->objectManager->persist($route);
        }
        $this->objectManager->flush();
    }

    /**
     * Gets the value of routes.
     *
     * @return mixed
     */
    public function getRoutes()
    {
        if (empty($this->routes)) {
            $this->refreshRoutes();
            foreach ($this->getAll() as $route) {
                if (isset($this->routes[$route->getRoute()])) {
                    unset($this->routes[$route->getRoute()]);
                }
            }
        }
        return array_values($this->routes);
    }

    /**
     * Sets the value of routes.
     *
     * @param mixed $routes the routes
     *
     * @return self
     */
    protected function setRoutes($route)
    {
        $this->routes[$route] = (new Entity())->setRoute($route);

        return $this;
    }
}
