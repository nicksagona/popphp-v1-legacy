<?php
require_once '../../bootstrap.php';

use Pop\Db\Db,
    Pop\Form\Form,
    Pop\Form\Fields,
    Pop\Form\Element,
    Pop\Record\Record;


class Users extends Record { }

class User extends Form { }

try {
    // Define DB credentials
    $db = Db::factory('Mysqli', array(
        'database' => 'phirecms',
        'host'     => 'localhost',
        'username' => 'phire',
        'password' => '12cms34'
    ));

    //$db = Db::factory('Sqlite', array(
    //    'database' => './phirecms.sqlite'
    //));

    Users::setDb($db);

    $attribs = array(
        'text'     => array('size', 40),
        'password' => array('size', 20),
        'textarea' => array(array('rows', 5), array('cols', 80))
    );

    $values = array(
        'id' => array(
            'type' => 'hidden'
        ),
        'username' => array(
            'value' => 'Enter Username...'
        ),
        'allowed_sites' => array(
        	'type'   => 'checkbox',
            'value'  => array('2001' => 'phire2.localhost', '2002' => 'test.localhost'),
            'marked' => array('2001', '2002')
        ),
        'access_id' => array(
        	'type'   => 'select',
            'value'  => array('3001' => 'Admin', '3002' => 'Basic'),
            'marked' => '3002'
        )
    );

    Fields::addFieldsFromTable(
        new Users(),
        $attribs,
        $values,
        array('last_login', 'last_ua', 'last_ip', 'failed_attempts')
    );

    Fields::addFields(array(
        'type'  => 'submit',
        'name'  => 'submit',
        'label' => '&nbsp;',
        'value' => 'SUBMIT',
    ));

    $form = new User($_SERVER['REQUEST_URI'], 'post', Fields::getFields());
    $form->render();

    echo PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
