<?php

require_once '../../bootstrap.php';

use Pop\Db\Db,
    Pop\Record\Record;

/*
 * Placing a class here is highly unorthodox.
 * This is just for example purposes only.
 */
class Users extends Record { }

try {
    // Define DB credentials
    $db = Db::factory('Pgsql', array(
        'database' => 'phirecms',
        'host'     => 'localhost',
        'username' => 'phire',
        'password' => '12cms34'
    ));

    $db = Db::factory('Sqlite', array(
        'database' => './phirecms.sqlite'
    ));

    Users::setDb($db);
    $users = new Users();
    $info = $users->getTableInfo();
    foreach ($info['columns'] as $key => $value) {
        echo '\'' . $key . '\':<br />' . PHP_EOL;
        echo '&nbsp;&nbsp;&nbsp;&nbsp;is of type ' . $value['type'] . '<br />' . PHP_EOL;
        echo '&nbsp;&nbsp;&nbsp;&nbsp;is ' . ($value['null'] ? null : 'NOT ') . 'NULL<br />' . PHP_EOL;

    }

    echo PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
