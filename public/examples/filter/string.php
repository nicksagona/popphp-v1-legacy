<?php

require_once '../../bootstrap.php';

use Pop\Filter\String;

try {
    $html = 'Some text, http://www.google.com/ and also https://www.google.com/ and someone@email.com and ftp://ftp.someserver.com';
    echo 'Links: ' . String::links($html, true) . '<br /><br />' . PHP_EOL;
    echo 'Slug: ' . String::slug('Testing, 1, 2, 3 | About Us | Hello World!', ' | ') . '<br /><br />' . PHP_EOL;
    echo 'Random String: ' . String::random(6, String::ALPHANUM, String::UPPER) . '<br /><br />' . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage();
}

