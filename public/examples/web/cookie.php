<?php

require_once '../../bootstrap.php';

use Pop\Web\Cookie;

try {
    $ary = array(
        'foo' => 'bar',
        'baz' => array(
            'some' => 'thing else'
        )
    );

    $cookie = Cookie::getInstance();
    $cookie->set('username', 'yourname')
           ->set('email', 'my@email.com')
           ->set('myary', $ary);

    print_r($cookie);
    print_r($_COOKIE);

    echo $cookie->username . PHP_EOL . PHP_EOL;
    print_r($cookie->myary);

    // Quickly unset a cookie
    // unset($cookie->email);
    // Specifically delete a cookie, with options
    //$cookie->delete('username', array('path' => '/'));
    // Clear all cookies, with options
    //$cookie->clear(array('path' => '/'));
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}

