<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2017-11-05 06:43:18
 * @Email:  dan.marinescu79@icloud.com
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2017-11-05 06:44:17
 * @Last Modified email: dan.marinescu79@icloud.com
 */

namespace AclAdmin\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Role
 *
 * @ORM\Table(name="role")
 * @ORM\Entity
 */
class Role
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=100, nullable=false)
     */
    private $role = '';

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_admin", type="smallint", nullable=false)
     */
    private $isAdmin = 0;

    /**
     * One Role has Many Roles.
     * @ORM\OneToMany(targetEntity="Role", mappedBy="parent")
     */
    private $children;

    /**
     * Many Roles have One Role.
     * @ORM\ManyToOne(targetEntity="Role", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;

    /**
     * One Role has Many Users.
     * @ORM\OneToMany(targetEntity="UserAdmin\Entity\User", mappedBy="role")
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity="Route", inversedBy="roles")
     * @ORM\JoinTable(name="role_route")
     */
    private $routes;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
        $this->users    = new \Doctrine\Common\Collections\ArrayCollection();
        $this->routes   = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set role
     *
     * @param string $role
     *
     * @return Role
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set isAdmin
     *
     * @param integer $isAdmin
     *
     * @return Role
     */
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    /**
     * Get isAdmin
     *
     * @return integer
     */
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * Add child
     *
     * @param \AclAdmin\Entity\Role $child
     *
     * @return Role
     */
    public function addChild(\AclAdmin\Entity\Role $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \AclAdmin\Entity\Role $child
     */
    public function removeChild(\AclAdmin\Entity\Role $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param \AclAdmin\Entity\Role $parent
     *
     * @return Role
     */
    public function setParent(\AclAdmin\Entity\Role $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \AclAdmin\Entity\Role
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add user
     *
     * @param \UserAdmin\Entity\User $user
     *
     * @return Role
     */
    public function addUser(\UserAdmin\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \UserAdmin\Entity\User $user
     */
    public function removeUser(\UserAdmin\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add route
     *
     * @param \AclAdmin\Entity\Route $route
     *
     * @return Role
     */
    public function addRoute(\AclAdmin\Entity\Route $route)
    {
        $this->routes[] = $route;

        return $this;
    }

    /**
     * Remove route
     *
     * @param \AclAdmin\Entity\Route $route
     */
    public function removeRoute(\AclAdmin\Entity\Route $route)
    {
        $this->routes->removeElement($route);
    }

    /**
     * Add routes
     *
     * @param \Doctrine\Common\Collections\ArrayCollection $routes
     *
     * @return Role
     */
    public function addRoutes(\Doctrine\Common\Collections\ArrayCollection $routes)
    {
        foreach ($routes as $route) {
            $this->addRoute($route);
        }

        return $this;
    }

    /**
     * Remove routes
     *
     * @param \Doctrine\Common\Collections\ArrayCollection $routes
     */
    public function removeRoutes(\Doctrine\Common\Collections\ArrayCollection $routes)
    {
        foreach ($routes as $route) {
            $this->routes->removeElement($route);
        }
    }

    /**
     * Get routes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoutes()
    {
        return $this->routes;
    }
}
