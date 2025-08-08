<?php
namespace Album\Form;

use Zend\Form\Form;

class AlbumForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('album');
        $this->add([
            'name' => 'title',
            'type' => 'text',
            'options' => [
                'label' => 'Title',
                'label_attributes' => [
                    'class' => 'label d-flex',
                ],
            ],
            'attributes' => [
                'class' => 'form-control mx-2',
            ],
        ]);
        $this->add([
            'name' => 'artist',
            'type' => 'text',
            'options' => [
                'label' => 'Artist',
                'label_attributes' => [
                    'class' => 'label d-flex',
                ],
            ],
            'attributes' => [
                'class' => 'form-control mx-2',
            ],
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Add',
                'id'    => 'submitbutton',
                'class' => 'btn btn-sm btn-primary px-3',
            ],
        ]);

        $this->add([
            'name' => 'save',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Update',
                'id'    => 'savebutton',
                'class' => 'btn btn-sm btn-warning px-3 text-white',
            ],
        ]);
    }
}