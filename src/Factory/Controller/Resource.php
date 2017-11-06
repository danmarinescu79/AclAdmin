<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2017-11-06 13:20:00
 * @Email:  dan.marinescu79@icloud.com
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2017-11-06 13:21:20
 * @Last Modified email: dan.marinescu79@icloud.com
 */

namespace AclAdmin\Factory\Controller;

use AclAdmin\Controller\Resource as Controller;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class Resource implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new Controller(
            $container->get(\AclAdmin\Service\Resource::class),
            $container->get(\AppCache::class)
        );
    }
}
