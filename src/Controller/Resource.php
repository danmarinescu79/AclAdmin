<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2017-11-06 13:22:19
 * @Email:  dan.marinescu79@icloud.com
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2017-11-06 13:22:53
 * @Last Modified email: dan.marinescu79@icloud.com
 */

namespace AclAdmin\Controller;

use AclAdmin\Service\Resource as Service;
use Zend\Cache\Storage\StorageInterface;
use Zend\Mvc\Controller\AbstractActionController;

class Resource extends AbstractActionController
{
    protected $service;
    protected $cache;

    public function __construct(Service $service, StorageInterface $cache)
    {
        $this->service = $service;
        $this->cache   = $cache;
    }

    public function indexAction()
    {
        $this->service->saveAll($this->service->getRoutes());
        $this->cache->removeItems(['acl', 'navigation']);

        return $this->redirect()->toRoute('role');
    }
}
