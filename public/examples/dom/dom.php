<?php

require_once '../../bootstrap.php';

use Pop\Dom\Child;
use Pop\Dom\Dom;

try {
    $title = new Child('title', 'This is the title');

    $meta = new Child('meta');
    $meta->setAttributes(array('http-equiv' => 'Content-Type', 'content' => 'text/html; charset=utf-8'));

    $head = new Child('head');
    $head->addChildren(array($title, $meta));

    $h1 = new Child('h1', 'This is a header');
    $p = new Child('p', 'This is a paragraph.');

    $div = new Child('div');
    $div->setAttributes('id', 'contentDiv');
    $div->addChildren(array($h1, $p));

    $body = new Child('body');
    $body->addChild($div);

    $html = new Child('html');
    $html->setAttributes(array('xmlns' => 'http://www.w3.org/1999/xhtml', 'xml:lang' => 'en'));
    $html->addChildren(array($head, $body));

    $doc = new Dom(Dom::XHTML11, 'utf-8', $html);
    $doc->render();
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}

