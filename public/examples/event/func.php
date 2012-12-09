<?php

require_once '../../bootstrap.php';

$anon = function ($name, $result) { return 'How are you doing, ' . $name . '? (' . $result . ')'; };

$func = new Pop\Code\FunctionGenerator('anon', $anon);
print_r($func->getParameters());

//$func = new Pop\Code\FunctionGenerator('somefunc');
//$func->setBody('echo \'Hello World!\';', false)
//     ->addArguments(array(
//         array('name' => 'somearg', 'value' => 'null', 'type' => 'array'),
//         array('name' => 'another', 'value' => '\'r\'', 'type' => 'string'),
//      ))
//     ->setClosure(true)
//     ->render();


//$functions = array(
//    'pre'    => function ($name) { return 'Hello, ' . $name; },
//    'during' => function ($name, $result) { return 'How are you doing, ' . $name . '? (' . $result . ')'; },
//    'post'   => function ($name) { return 'Goodbye, ' . $name; }
//);
//
//$refFunc = new ReflectionFunction($functions['during']);
//$params = array();
//foreach ($refFunc->getParameters() as $key => $refParameter) {
//    $params[$key] .': ' . $refParameter->getName();
//}

//echo call_user_func_array($func, array('World!'));

//$result = null;
//foreach ($functions as $name => $func) {
//    $param = (null !== $result) ? array($result) : array('World!');
//    $result = call_user_func_array($func, $param);
//    echo $result . '<br />';
//}