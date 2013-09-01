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
                    'name' => 'Add Nav Here',
                    'href' => 'first-child'
                ),
                array(
                    'name' => 'Second Child',
                    'href' => 'second-child'
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
                    'href' => 'another-first-child',
                    'attributes' => array(
                        'target' => '_blank',
                        'class'  => 'special-link'
                    )
                ),
                array(
                    'name'     => 'Another Second Child',
                    'href'     => 'another-second-child',
                    'children' => array(
                        array(
                            'name' => 'Nested Child',
                            'href' => 'nested-child',
                            'attributes' => array(
                                'target' => '_blank',
                                'class'  => 'nested-link'
                            ),
                            'children' => array(
                                array(
                                    'name' => 'Add Nav Here',
                                    'href' => 'sub-nested-child'
                                )
                            )
                        )
                    )
                )
            )
        )
    );

    $config = array(
        'top' => array(
            'node'  => 'ul',
            'id'    => 'main-nav'
        ),
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
    $nav->addLeaf('Nested Child', array(
        'name'     => 'A Brand New Child',
        'href'     => 'a-brand-new-child'
    ), null, true);

    echo $nav;

} catch (\Exception $e) {
    echo $e->getMessage();
}

