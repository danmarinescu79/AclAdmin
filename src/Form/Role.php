<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2017-11-06 13:35:14
 * @Email:  dan.marinescu79@icloud.com
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2017-11-06 13:35:41
 * @Last Modified email: dan.marinescu79@icloud.com
 */

namespace AclAdmin\Form;

use Doctrine\Common\Persistence\ObjectManager;
use Zend\Form\Element;
use Zend\Form\Form;

class Role extends Form
{
    protected $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;

        parent::__construct();

        $roleFieldset = new Fieldset\Role($this->objectManager);
        $roleFieldset->setUseAsBaseFieldset(true);
        $this->add($roleFieldset);

        $this->add(new Element\Csrf('security'));

        $this->add([
            'name'       => 'submit',
            'type'       => Element\Submit::class,
            'attributes' => [
                'value' => _('Save'),
                'class' => 'btn btn-md btn-primary',
            ],
        ]);

        $this->setValidationGroup([
            'security',
            'role' => [
                'id',
                'role',
                'parent',
                'isAdmin',
                'routes',
            ],
        ]);
    }
}
