<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2017-11-06 13:36:08
 * @Email:  dan.marinescu79@icloud.com
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2017-11-06 13:36:54
 * @Last Modified email: dan.marinescu79@icloud.com
 */

namespace AclAdmin\Form\Fieldset;

use AclAdmin\Entity\Role as RoleEntity;
use AclAdmin\Entity\Route;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Form\Element\ObjectMultiCheckbox;
use DoctrineModule\Form\Element\ObjectSelect;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Element;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class Role extends Fieldset implements InputFilterProviderInterface
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('role');

        $this->objectManager = $objectManager;

        $this->setHydrator(new DoctrineHydrator($objectManager))->setObject(new RoleEntity());

        $this->add([
            'type' => 'hidden',
            'name' => 'id'
        ]);

        $this->add([
            'type'    => Element\Text::class,
            'name'    => 'role',
            'options' => [
                'label' => _('Role Name'),
            ],
            'attributes' => [
                'placeholder' => _('Role Name'),
                'class'       => 'form-control input-sm',
            ],
        ]);

        $this->add([
            'type'    => ObjectSelect::class,
            'name'    => 'parent',
            'options' => [
                'object_manager'     => $this->objectManager,
                'target_class'       => RoleEntity::class,
                'property'           => 'role',
                'label'              => _('Role Parent'),
                'display_empty_item' => true,
                'empty_item_label'   => _(' - No Parent - '),
            ],
            'attributes' => [
                'class' => 'form-control',
            ],
        ]);

        $this->add([
            'type'    => Element\Checkbox::class,
            'name'    => 'isAdmin',
            'options' => [
                'label'              => _('Is Admin ?'),
                'checked_value'      => 1,
                'unchecked_value'    => 0,
            ],
            'attributes' => [
                'class' => 'styled',
                'id'    => 'isAdmin',
            ],
        ]);

        $this->add([
            'type'    => ObjectMultiCheckbox::class,
            'name'    => 'routes',
            'options' => [
                'object_manager'    => $this->objectManager,
                'target_class'      => Route::class,
                'property'          => 'route',
                'label_generator'   => function ($targetEntity) {
                    return $targetEntity->getRoute();
                },
                'label_attributes'   => [
                    'class' => 'checkbox',
                ],
                'option_attributes' => [
                    'class'   => 'styled',
                    'id'      => function (Route $entity) {
                        return $entity->getRoute();
                    },
                ],
            ],
        ]);
    }

     /**
      * @return array
      */
    public function getInputFilterSpecification()
    {
        return [
            'id' => [
                'required'    => true,
                'allow_empty' => true,
            ],
            'role' => [
                'required' => true,
            ],
            'parent' => [
                'required'    => true,
                'allow_empty' => true,
            ],
            'isAdmin' => [
                'required'    => true,
                'allow_empty' => true,
            ],
            'routes' => [
                'required'    => true,
            ],
        ];
    }
}
