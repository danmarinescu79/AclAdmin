<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2017-11-06 13:07:47
 * @Email:  dan.marinescu79@icloud.com
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2017-11-06 13:14:08
 * @Last Modified email: dan.marinescu79@icloud.com
 */

namespace AclAdmin\Factory\Service;

use AclAdmin\Service\Role as Service;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class Role implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new Service(
            $container->get(\Doctrine\ORM\EntityManager::class)
        );
    }
}
