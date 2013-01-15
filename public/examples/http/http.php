<?php

require_once '../../bootstrap.php';

use Pop\Http\Request;

try {
    $request = new Request();

    switch ($request->getMethod()) {
        case 'GET':
            print_r($request->getQuery());
            break;
        case 'POST':
            print_r($request->getPost());
            break;
        case 'PUT':
            print_r($request->getPut());
            break;
        case 'PATCH':
            print_r($request->getPatch());
            break;
        case 'DELETE':
            print_r($request->getDelete());
            break;
    }
} catch (\Exception $e) {
    echo $e->getMessage();
}

