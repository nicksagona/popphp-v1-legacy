<?php

require_once '../../bootstrap.php';

use Pop\Form\Form;
use Pop\Validator;

try {
    $fields = array(
        'username' => array(
            'type'       => 'text',
            'value'      => 'Username here...',
            'label'      => 'Username:',
            'required'   => true,
            'attributes' => array('size' => 40),
            'validators' => array(
                new Validator\AlphaNumeric(),
                function ($value) {
                    if (strlen($value) < 6) {
                        return 'The username value must be greater than or equal to 6.';
                    }
                }
            )
        ),
        'email' => array(
            'type'       => 'text',
            'label'      => 'Email:',
            'required'   => true,
            'attributes' => array('size' => 40),
            'validators' => new Validator\Email()
        ),
        'password' => array(
            'type'       => 'password',
            'label'      => 'Password:',
            'required'   => true,
            'attributes' => array('size' => 40),
            'validators' => function ($value) {
                if (strlen($value) < 6) {
                    return 'The password value must be greater than or equal to 6!';
                }
            }
        ),
        'checkbox_colors' => array(
            'type'       => 'checkbox',
            'label'      => 'Colors:',
            'required'   => true,
            'value'      => array('Red' => 'Red', 'Green' => 'Green', 'Blue' => 'Blue'),
            'validators' => new Validator\Included(array('Red', 'Green'))
        ),
        'radio_colors' => array(
            'type'       => 'radio',
            'label'      => 'Colors:',
            'required'   => true,
            'value'      => array('Red' => 'Red', 'Green' => 'Green', 'Blue' => 'Blue')
        ),
        'select_colors' => array(
            'type'       => 'select',
            'label'      => 'Colors:',
            'value'      => array('--' => '--', 'Red' => 'Red', 'Green' => 'Green', 'Blue' => 'Blue'),
            'validators' => new Validator\Excluded('--'),
            'attributes' => array('multiple' => 'multiple')
        ),
        'submit' => array(
            'type'       => 'submit',
            'value'      => 'SUBMIT',
            'attributes' => array('style' => 'padding: 5px; border: solid 2px #000; background-color: #00f; color: #fff; font-weight: bold;')
        )
    );

    $form = new Form($_SERVER['PHP_SELF'], 'post', $fields, '    ');
    $form->setTemplate('form.html');

    if ($_POST) {
        $form->setFieldValues($_POST, array('strip_tags' => null, 'htmlentities' => array(ENT_QUOTES, 'UTF-8')));
        if (!$form->isValid()) {
            $form->render();
        } else {
            echo 'Form is valid.<br />' . PHP_EOL;
            $form->filter(array('html_entity_decode' => array(ENT_QUOTES, 'UTF-8')));
            print_r($form->getFields());
        }
    } else {
        $form->render();
    }

    echo PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}

