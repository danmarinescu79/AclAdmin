<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2017-11-05 05:35:03
 * @Email:  dan.marinescu79@icloud.com
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2017-11-06 13:28:07
 * @Last Modified email: dan.marinescu79@icloud.com
 */

namespace AclAdmin;

use Zend\Console\Request as ConsoleRequest;
use Zend\EventManager\EventInterface as Event;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;

class Module
{
    const VERSION = '0.1';

    private $role = "Guest";

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(Event $event)
    {
        $application = $event->getApplication();
        if (!$application->getRequest() instanceof ConsoleRequest) {
            $services    = $application->getServiceManager();
            $authService = $services->get('doctrine.authenticationservice.orm_default');
            if ($authService->hasIdentity()) {
                $this->role = $authService->getIdentity()->getRole()->getRole();
            }

            $acl = $services->get(\AclAdmin\Service\Acl::class)->create($this->role);

            // $application->getEventManager()->attach(MvcEvent::EVENT_DISPATCH, [$this, 'onDispatch'], 10000);
        }
    }

    public function onDispatch(Event $event)
    {
        $application = $event->getApplication();
        $services    = $application->getServiceManager();
        $route       = $application->getMvcEvent()->getRouteMatch()->getMatchedRouteName();
        $acl         = $services->get(\Acl\Service\Acl::class)->getAcl();

        if (!$acl->hasResource($route)) {
            $event->getResponse()->getHeaders()->addHeaderLine('Location', '/');
            $event->getResponse()->setStatusCode(302);
            return $event->getResponse();
            exit();
        }

        if (!$acl->isAllowed($this->role, $route)) {
            if ($this->role == "Guest") {
                $event->getResponse()->getHeaders()->addHeaderLine('Location', '/login');
                $event->getResponse()->setStatusCode(302);
                return $event->getResponse();
                exit();
            }

            try {
                $response = $event->getResponse();
            } catch (\Exception $e) {
                $response = new \Zend\Http\PhpEnvironment\Response;
            }

            $viewModel = $event->getViewModel();

            $viewChild = new ViewModel([]);
            $viewChild->setTemplate('error/403');
            $viewModel->addChild($viewChild, 'content');
            $event->setViewModel($viewModel);
            $response->setStatusCode(403);
            $response->sendHeaders();
            $event->stopPropagation(true);
        }
    }
}
