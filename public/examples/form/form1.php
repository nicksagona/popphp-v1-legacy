<?php

require_once '../../bootstrap.php';

use Pop\Form\Form;
use Pop\Validator;

try {
    $fields = array(
        array(
            'type'       => 'text',
            'name'       => 'username',
            'value'      => 'Username here...',
            'label'      => 'Username:',
            'required'   => true,
            'attributes' => array('size', 40)
        ),
        array(
            'type'       => 'text',
            'name'       => 'email',
            'label'      => 'Email:',
            'required'   => true,
            'attributes' => array('size', 40),
            'validators' => new Validator\Email()
        ),
        array(
            'type'       => 'password',
            'name'       => 'password',
            'label'      => 'Password:',
            'required'   => true,
            'attributes' => array('size', 40),
            'validators' => new Validator\LengthGt(6)
        ),
        array(
            'type'       => 'checkbox',
            'name'       => 'checkbox_colors',
            'label'      => 'Colors:',
            'required'   => true,
            'value'      => array('Red' => 'Red', 'Green' => 'Green', 'Blue' => 'Blue'),
            'validators' => new Validator\Included(array('Red', 'Green'))
        ),
        array(
            'type'       => 'radio',
            'name'       => 'radio_colors',
            'label'      => 'Colors:',
            'required'   => true,
            'value'      => array('Red' => 'Red', 'Green' => 'Green', 'Blue' => 'Blue')
        ),
        array(
            'type'       => 'select',
            'name'       => 'select_colors',
            'label'      => 'Colors:',
            'value'      => array('--' => '--', 'Red' => 'Red', 'Green' => 'Green', 'Blue' => 'Blue'),
            'validators' => new Validator\Excluded('--'),
            'attributes' => array('multiple', 'multiple')
        ),
        array(
            'type'       => 'submit',
            'name'       => 'submit',
            'value'      => 'SUBMIT',
            'attributes' => array('style', 'padding: 5px; border: solid 2px #000; background-color: #00f; color: #fff; font-weight: bold;')
        )
    );

    $form = new Form($_SERVER['PHP_SELF'], 'post', $fields, '    ');
    $form->setTemplate('form.phtml');

    if ($_POST) {
        $form->setFieldValues($_POST, array('strip_tags', 'htmlentities'), array(null, array(ENT_QUOTES, 'UTF-8')));
        if (!$form->isValid()) {
            $form->render();
        } else {
            echo 'Form is valid.<br />' . PHP_EOL;
            $form->filter('html_entity_decode', array(ENT_QUOTES, 'UTF-8'));
            print_r($form->getFields());
        }
    } else {
        $form->render();
    }

    echo PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}

