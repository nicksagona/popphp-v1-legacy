<?php

require_once '../../bootstrap.php';

use Pop\Form\Form,
    Pop\Validator\Validator,
    Pop\Validator\Validator\AlphaNumeric,
    Pop\Validator\Validator\Email,
    Pop\Validator\Validator\LengthGt,
    Pop\Validator\Validator\NotEqual;

try {
    $fields = array(
        array(
            'type'       => 'text',
            'name'       => 'username',
            'label'      => 'Username:',
            'required'   => true,
            'attributes' => array('size', 40),
            'validators' => new AlphaNumeric()
        ),
        array(
            'type'       => 'password',
            'name'       => 'password',
            'label'      => 'Password:',
            'required'   => true,
            'attributes' => array('size', 40)
        ),
        array(
            'type'       => 'csrf',
            'name'       => 'pop_csrf',
            'value'      => 'security'
        ),
        array(
            'type'       => 'submit',
            'name'       => 'submit',
            'value'      => 'SUBMIT'
        )
    );

    $form = new Form($_SERVER['PHP_SELF'], 'post', $fields, '    ');

    if ($_POST) {
        //$_POST['pop_csrf'] = 'bad token';
        $form->setFieldValues($_POST, array('strip_tags', 'htmlentities'), array(null, array(ENT_QUOTES, 'UTF-8')));
        if (!$form->isValid()) {
            $form->render();
        } else {
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

