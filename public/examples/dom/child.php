<?php

require_once '../../bootstrap.php';

use Pop\Dom\Child;

try {

    $children = array(
        array(
            'nodeName'      => 'h1',
            'nodeValue'     => 'This is a header',
            'attributes'    => array('class' => 'headerClass', 'style' => 'font-size: 3.0em;'),
            'childrenFirst' => false,
            'childNodes'    => null
        ),
        array(
            'nodeName'      => 'div',
            'nodeValue'     => 'This is a div element',
            'attributes'    => array('id' => 'contentDiv'),
            'childrenFirst' => false,
            'childNodes'    => array(
                array(
                     'nodeName'      => 'p',
                     'nodeValue'     => 'This is a paragraph1',
                     'attributes'    => array('style' => 'font-size: 0.9em;'),
                     'childrenFirst' => false,
                     'childNodes'    => array(
                         array(
                             'nodeName'   => 'strong',
                             'nodeValue'  => 'This is bold!',
                             'attributes' => array('style' => 'font-size: 1.2em;')
                         )
                     )
                ),
                array(
                    'nodeName'   => 'p',
                    'nodeValue'  => 'This is another paragraph!',
                    'attributes' => array('style' => 'font-size: 0.9em;')
                )
            ),
        )
    );

    $parent = new Child('div');
    $parent->setIndent('    ')
           ->addChildren($children);
    $parent->render();
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}

