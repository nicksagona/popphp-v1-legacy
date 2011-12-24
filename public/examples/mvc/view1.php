<?php

require_once '../../bootstrap.php';

use Pop\Mvc\Model,
    Pop\Mvc\View;

try {
    $data = array(
        'title' => 'Hello World',
        'body'  => 'This is the body (from template file)',
        'list'  => array(
            'Thing #1',
            'Something Else',
            'Another Thing',
            'Thing #2'
        ),
        'pages' => array(
            array(
                'page_url'   => 'http://www.google.com/',
                'page_title' => 'Google'
            ),
            array(
                'page_url'   => 'http://www.msn.com/',
                'page_title' => 'MSN'
            ),
            array(
                'page_url'   => 'http://www.yahoo.com/',
                'page_title' => 'Yahoo!'
            )
        )
    );

    $view = View::factory('test/view/template.phtml', new Model($data));
    $view->render();

} catch (Exception $e) {

    print($e->getMessage());

}

?>