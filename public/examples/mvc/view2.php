<?php

require_once '../../bootstrap.php';

use Pop\Mvc\View;

try {
    $tmpl = <<<TMPL
<html>
<head>
    <title>[{title}]</title>
</head>
<body>
    <h1>[{body}]</h1>
    <p>
        This is a test template page.
    </p>
    <ul>
[{list}]        <li>[{value}]</li>[{/list}]
    </ul>
    <p>
        This is another list.
    </p>
    <ul>
[{pages}]        <li><a href="[{page_url}]">[{page_title}]</a></li>[{/pages}]
    </ul>
</body>
</html>
TMPL;

    $data = array(
        'title' => 'Hello World',
        'body'  => 'This is the body (from template string)',
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

    $view = View::factory($tmpl, $data);
    $view->render();
} catch (Exception $e) {
    echo $e->getMessage();
}

