<?php

require_once '../../bootstrap.php';

use Pop\Nav\Nav;

try {
    $tree = array(
        array(
            'name'     => 'First Nav Item',
            'href'     => '/first',
            'children' => array(
                array(
                    'name' => 'First Child',
                    'href' => '/first-child'
                ),
                array(
                    'name' => 'Second Child',
                    'href' => '/second-child'
                )
            )
        ),
        array(
            'name'     => 'Second Nav Item',
            'href'     => '/second'
        ),
        array(
            'name'     => 'Third Nav Item',
            'href'     => '/third',
            'children' => array(
                array(
                    'name' => 'Another First Child',
                    'href' => '/another-first-child'
                ),
                array(
                    'name'     => 'Another Second Child',
                    'href'     => '/another-second-child',
                    'children' => array(
                        array(
                            'name' => 'Nested Child',
                            'href' => '/nested-child'
                        )
                    )
                )
            )
        )
    );

    $config = array(
        'parent' => array(
            'node'  => 'ul',
            'id'    => 'nav',
            'class' => 'level'
        ),
        'child' => array(
            'node'  => 'li',
            'id'    => 'menu',
            'class' => 'item'
        )
    );

    $nav = new Nav($tree, $config);
    echo $nav;

} catch (\Exception $e) {

    print($e->getMessage());

}

