<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2017-11-06 13:21:31
 * @Email:  dan.marinescu79@icloud.com
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2017-11-06 13:31:59
 * @Last Modified email: dan.marinescu79@icloud.com
 */

namespace AclAdmin\Factory\Controller;

use AclAdmin\Controller\Role as Controller;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class Role implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new Controller(
            $container->get(\AclAdmin\Service\Role::class)
        );
    }
}
