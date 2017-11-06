<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2017-11-06 13:23:20
 * @Email:  dan.marinescu79@icloud.com
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2017-11-06 13:24:40
 * @Last Modified email: dan.marinescu79@icloud.com
 */

namespace AclAdmin\Controller;

use AclAdmin\Entity\Role as Entity;
use AclAdmin\Service\Role as Service;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class Role extends AbstractActionController
{
    protected $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function indexAction()
    {
        $results = $this->service->getAll();

        return new ViewModel([
            'results' => $results
        ]);
    }

    public function deleteAction()
    {
        $roleId = $this->params()->fromRoute('id', false);
        if ($roleId) {
            try {
                $this->service->delete($roleId);
                $this->flashMessenger()->addMessage(_('Role deleted.'));
            } catch (\Exception $e) {
                $this->flashMessenger()->addMessage(_('Role deletion error.'));
            }
        }
        return $this->redirect()->toRoute('role');
    }

    public function manageAction()
    {
        $prg = $this->prg();
        if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
            return $prg;
        }
        $roleId = $this->params()->fromRoute('id', false);
        $form   = $this->service->getForm();
        if ($roleId) {
            $role = $this->service->getOne($roleId);
        } else {
            $role = new Entity;
        }
        $form->bind($role);

        if ($prg !== false) {
            $form->setData($prg);
            if ($form->isValid()) {
                $this->service->save($role);
                $this->flashMessenger()->addMessage(_('Role saved.'));
                return $this->redirect()->toRoute('role');
            }
        }

        return new ViewModel([
            'form'   => $form,
            'roleId' => $roleId,
        ]);
    }
}
