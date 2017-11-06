<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2017-11-06 13:12:13
 * @Email:  dan.marinescu79@icloud.com
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2017-11-06 13:37:20
 * @Last Modified email: dan.marinescu79@icloud.com
 */

namespace AclAdmin\Service;

use AclAdmin\Entity\Role as Entity;
use Doctrine\Common\Persistence\ObjectManager;

class Role
{
    protected $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function delete($roleId)
    {
        $this->objectManager->remove($this->objectManager->find(Entity::class, $roleId));
        $this->objectManager->flush();
    }

    public function getOne($roleId)
    {
        return $this->objectManager->find(Entity::class, $roleId);
    }

    public function getAll()
    {
        return $this->objectManager->getRepository(Entity::class)->findBy([], ['id' => 'DESC']);
    }

    public function save(Entity $role)
    {
        $this->objectManager->persist($role);
        $this->objectManager->flush();
    }

    public function getForm()
    {
        return new \AclAdmin\Form\Role($this->objectManager);
    }
}
