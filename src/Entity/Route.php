<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2017-11-05 06:44:45
 * @Email:  dan.marinescu79@icloud.com
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2017-11-05 06:45:19
 * @Last Modified email: dan.marinescu79@icloud.com
 */

namespace AclAdmin\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Route
 *
 * @ORM\Table(name="route")
 * @ORM\Entity
 */
class Route
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
     * @ORM\Column(name="route", type="string", length=150, nullable=false)
     */
    private $route = '';

    /**
     * @ORM\ManyToMany(targetEntity="Role", mappedBy="routes")
     */
    private $roles;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set route
     *
     * @param string $route
     *
     * @return Route
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Add role
     *
     * @param \AclAdmin\Entity\Role $role
     *
     * @return Route
     */
    public function addRole(\AclAdmin\Entity\Role $role)
    {
        $this->roles[] = $role;

        return $this;
    }

    /**
     * Remove role
     *
     * @param \AclAdmin\Entity\Role $role
     */
    public function removeRole(\AclAdmin\Entity\Role $role)
    {
        $this->roles->removeElement($role);
    }

    /**
     * Get roles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoles()
    {
        return $this->roles;
    }
}
