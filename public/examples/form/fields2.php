<?php
require_once '../../bootstrap.php';

use Pop\Db\Db;
use Pop\Form\Form;
use Pop\Form\Fields;
use Pop\Form\Element;
use Pop\Db\Record;

class Users extends Record { }

class User extends Form { }

try {
    // Define DB credentials
    $db = Db::factory('Mysqli', array(
        'database' => 'helloworld',
        'host'     => 'localhost',
        'username' => 'hello',
        'password' => '12world34'
    ));

    Users::setDb($db);

    $attribs = array(
        'text'     => array('size' => 40),
        'password' => array('size' => 20),
        'textarea' => array('rows' => 5, 'cols' => 80)
    );

    $values = array(
        'id' => array(
            'type' => 'hidden'
        ),
        'username' => array(
            'value'      => 'Enter Username...',
            'validators' => new Pop\Validator\AlphaNumeric()
        )
    );

    $fields = Fields::factory(Users::getTableInfo(), $attribs, $values, array('access'));

    $fields->addFields(array(
        'submit' => array(
            'type'  => 'submit',
            'label' => '&nbsp;',
            'value' => 'SUBMIT'
        )
    ));

    $form = new User($_SERVER['REQUEST_URI'], 'post', $fields->getFields());

    if ($_POST) {
        $form->setFieldValues($_POST);
        if ($form->isValid()) {
            echo 'Form is valid!';
        } else {
            $form->render();
        }
    } else {
        $form->render();
    }

    echo PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
