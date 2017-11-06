<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2017-11-06 13:10:25
 * @Email:  dan.marinescu79@icloud.com
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2017-11-06 13:10:44
 * @Last Modified email: dan.marinescu79@icloud.com
 */

namespace AclAdmin\Service;

use AclAdmin\Entity\Role;
use AclAdmin\Entity\Route;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\Cache\Storage\StorageInterface;
use Zend\Permissions\Acl\Acl as AclObject;
use Zend\Permissions\Acl\Resource\GenericResource;
use Zend\Permissions\Acl\Role\GenericRole;

class Acl
{
    protected $objectManager;
    protected $acl;
    protected $cache;

    public function __construct(ObjectManager $objectManager, StorageInterface $cache)
    {
        $this->objectManager = $objectManager;
        $this->cache         = $cache;
    }

    public function create($roleName)
    {
        if (!$this->cache->hasItem('acl')) {
            $this->acl = new AclObject();

            $routes = $this->objectManager->getRepository(Route::class)->findAll();
            $roles  = $this->objectManager->getRepository(Role::class)->findBy(['parent' => null]);

            foreach ($roles as $role) {
                $this->addRole($role);
            }

            foreach ($routes as $route) {
                $this->acl->addResource(new GenericResource($route->getRoute()));
                $this->addRolePermission($route);
            }
            $this->cache->setItem('acl', $this->acl);
        } else {
            $this->acl = $this->cache->getItem('acl');
        }

        \Zend\View\Helper\Navigation\AbstractHelper::setDefaultAcl($this->acl);
        \Zend\View\Helper\Navigation\AbstractHelper::setDefaultRole($roleName);

        return $this->acl;
    }

    private function addRole(Role $role)
    {
        $parent = (!empty($role->getParent())) ? $role->getParent()->getRole() : null;
        $this->acl->addRole(new GenericRole($role->getRole()), $parent);

        if ($role->getIsAdmin()) {
            $this->acl->allow($role->getRole());
        }

        if ($role->getChildren()->count() > 0) {
            foreach ($role->getChildren() as $child) :
                $this->addRole($child);
            endforeach;
        }
    }

    private function addRolePermission(Route $route)
    {
        if ($route->getRoles()->count() > 0) {
            foreach ($route->getRoles() as $role) {
                if ($role->getIsAdmin()) {
                    continue;
                }
                $this->acl->allow($role->getRole(), $route->getRoute());
            }
        }
    }

    /**
     * Gets the value of acl.
     *
     * @return mixed
     */
    public function getAcl()
    {
        return $this->acl;
    }
}
