<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2017-11-06 13:13:08
 * @Email:  dan.marinescu79@icloud.com
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2017-11-06 13:13:31
 * @Last Modified email: dan.marinescu79@icloud.com
 */

namespace AclAdmin\Factory\Service;

use AclAdmin\Service\Acl as Service;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class Acl implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new Service(
            $container->get(\Doctrine\ORM\EntityManager::class),
            $container->get(\AppCache::class)
        );
    }
}
