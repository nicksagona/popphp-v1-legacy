<?php

require_once '../../bootstrap.php';

use Pop\Form\Form,
    Pop\Form\Element,
    Pop\Form\Element\Checkbox,
    Pop\Form\Element\Radio,
    Pop\Form\Element\Select,
    Pop\Form\Element\Textarea,
    Pop\Validator;

try {

    $form = new Form($_SERVER['PHP_SELF'], 'post', null, '    ');

    $username = new Element('text', 'username', 'Username here...');
    $username->setLabel('Username:')
             ->setRequired(true)
             ->setAttributes('size', 40)
             ->addValidator(new Validator\AlphaNumeric());

    $email = new Element('text', 'email');
    $email->setLabel('Email:')
          ->setRequired(true)
          ->setAttributes('size', 40)
          ->addValidator(new Validator\Email());

    $password = new Element('password', 'password');
    $password->setLabel('Password:')
             ->setRequired(true)
             ->setAttributes('size', 40)
             ->addValidator(new Validator\LengthGt(6));

    $checkbox = new Checkbox('colors', array('Red' => 'Red', 'Green' => 'Green', 'Blue' => 'Blue'));
    $checkbox->setLabel('Colors:')
          ->setRequired(true);

    $radio = new Radio('answer', array('Yes' => 'Yes', 'No' => 'No', 'Maybe' => 'Maybe'));
    $radio->setLabel('Answer:')
          ->setRequired(true);

    $select = new Select('days', Select::DAYS_OF_WEEK);
    $select->setLabel('Day:');

    $textarea = new Textarea('comments', 'Please type a comment...');
    $textarea->setAttributes('rows', '5')
             ->setAttributes('cols', '40')
             ->setLabel('Comments:');

    $submit = new Element('submit', 'submit', 'SUBMIT');
    $submit->setAttributes('style', 'padding: 5px; border: solid 2px #000; background-color: #00f; color: #fff; font-weight: bold;');

    $form->addElements(array(
        $username,
        $email,
        $password,
        $checkbox,
        $radio,
        $select,
        $textarea,
        $submit
    ));

    if ($_POST) {
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

