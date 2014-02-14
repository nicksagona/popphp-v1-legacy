<?php

require_once '../../bootstrap.php';

use Pop\Form\Form;
use Pop\Validator;

try {
    $fields = array(
        'username' => array(
            'type'       => 'text',
            'label'      => 'Username:',
            'required'   => true,
            'attributes' => array('size' => 40),
            'validators' => new Validator\AlphaNumeric()
        ),
        'password' => array(
            'type'       => 'password',
            'label'      => 'Password:',
            'required'   => true,
            'attributes' => array('size' => 40)
        ),
        'my_captcha' => array(
            'type'       => 'captcha',
            'label'      => 'Please Solve: ',
            'attributes' => array('size' => 10),
            'expire'     => 120
        ),
        'submit' => array(
            'type'       => 'submit',
            'value'      => 'SUBMIT'
        )
    );

    $form = new Form($_SERVER['PHP_SELF'], 'post', $fields, '    ');

    if ($_POST) {
        $form->setFieldValues($_POST, array('strip_tags' => null, 'htmlentities' => array(ENT_QUOTES, 'UTF-8')));
        if (!$form->isValid()) {
            $form->render();
        } else {
            // Option to clear out and reset security token
            $form->clear();
            echo 'Form is valid.<br />' . PHP_EOL;
            print_r($form->getFields());
        }
    } else {
        $form->render();
    }

    echo PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}

