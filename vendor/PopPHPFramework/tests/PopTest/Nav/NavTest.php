<?php
/**
 * Pop PHP Framework Unit Tests (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Test
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace PopTest\Nav;

use Pop\Auth;
use Pop\Loader\Autoloader;
use Pop\Nav\Nav;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class NavTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $this->assertInstanceOf('Pop\Nav\Nav', new Nav(array(), array()));
        $this->assertInstanceOf('Pop\Nav\Nav', Nav::factory(array(), array()));
    }

    public function testSetAndGetTree()
    {
        $tree = array(
            array(
                'name'     => 'First Nav Item',
                'href'     => '/first',
            ),
            array(
                'name'     => 'Second Nav Item',
                'href'     => '/second'
            )
        );
        $n = new Nav();
        $n->setTree($tree);
        $t = $n->getTree();
        $this->assertEquals('First Nav Item', $t[0]['name']);
    }

    public function testSetAndGetConfig()
    {
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
        $n = new Nav();
        $n->setConfig($config);
        $c = $n->getConfig();
        $this->assertEquals('level', $c['parent']['class']);
    }

    public function testAddBranch()
    {
        $tree = array(
            array(
                'name'     => 'First Nav Item',
                'href'     => '/first',
            )
        );
        $branch = array(
            'name'     => 'Second Nav Item',
            'href'     => '/second'
        );
        $n = new Nav();
        $n->setTree($tree);
        $n->addBranch($branch);
        $t = $n->getTree();
        $this->assertEquals('Second Nav Item', $t[1]['name']);
    }

    public function testAddLeaf()
    {
        $_SERVER['REQUEST_URI'] = '/first';

        $tree = array(
            array(
                'name'     => 'First Nav Item',
                'href'     => '/first',
            ),
            array(
                'name'     => 'Second Nav Item',
                'href'     => '/second'
            )
        );
        $n = new Nav($tree);
        $n->addLeaf('Second Nav Item', array(
            'name'     => 'A Brand New Child',
            'href'     => 'a-brand-new-child'
        ));

        $navString = <<<NAV
        <a href="/second">Second Nav Item</a>
        <ul>
            <li>
                <a href="/second/a-brand-new-child">A Brand New Child</a>
            </li>
        </ul>
NAV;
        $this->assertContains($navString, (string)$n);
    }

    public function testSetAndGetAcl()
    {
        $n = new Nav();
        $acl = new Auth\Acl();
        $n->setAcl($acl);
        $this->assertInstanceOf('Pop\Auth\Acl', $n->getAcl());
    }

    public function testSetAndGetRole()
    {
        $n = new Nav();
        $role = Auth\Role::factory('basic');
        $n->setRole($role);
        $this->assertInstanceOf('Pop\Auth\Role', $n->getRole());
    }

    public function testBuildAndGetNav()
    {
        $_SERVER['REQUEST_URI'] = '/first';

        $tree = array(
            array(
                'name'     => 'First Nav Item',
                'href'     => '/first',
            ),
            array(
                'name'     => 'Second Nav Item',
                'href'     => '/second'
            )
        );
        $n = new Nav($tree);
        $this->assertInstanceOf('Pop\Nav\Nav', $n->build());
    }

    public function testGetNav()
    {
        $_SERVER['REQUEST_URI'] = '/first';

        $tree = array(
            array(
                'name'     => 'First Nav Item',
                'href'     => '/first',
            ),
            array(
                'name'     => 'Second Nav Item',
                'href'     => '/second'
            )
        );
        $n = new Nav($tree);
        $this->assertInstanceOf('Pop\Dom\Child', $n->nav());
    }

    public function testReturnFalse()
    {
        $_SERVER['REQUEST_URI'] = '/first';

        $tree = array(
            array(
                'name'     => 'First Nav Item',
                'href'     => '#',
                'children' => array(
                    array(
                        'name' => 'First Child',
                        'href' => '/first/first-child'
                    ),
                    array(
                        'name' => 'Second Child',
                        'href' => '/first/second-child'
                    )
                )
            )
        );

        $n = new Nav($tree);
        $this->assertFalse($n->isReturnFalse());
        $n->returnFalse(true);
        $this->assertTrue($n->isReturnFalse());
        $this->assertContains('onclick="return false;"', $n->render(true));
    }

    public function testBuildNav()
    {
        $_SERVER['REQUEST_URI'] = '/first';

        $tree = array(
            array(
                'name'     => 'First Nav Item',
                'href'     => '/first',
                'children' => array(
                    array(
                        'name' => 'First Child',
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
                'href'     => '/second',
                'attributes' => array(
                    'style' => 'display: block;'
                )
            )
        );

        $config  = array(
            'top' => array(
                'node'  => 'ul',
                'id'    => 'main-nav',
                'class' => 'main-nav',
                'attributes' => array(
                    'style' => 'display: block;'
                )
            ),
            'parent' => array(
                'node'  => 'ul',
                'id'    => 'nav',
                'class' => 'level',
                'attributes' => array(
                    'style' => 'display: block;'
                )
            ),
            'child' => array(
                'node'  => 'li',
                'id'    => 'menu',
                'class' => 'item',
                'attributes' => array(
                    'style' => 'display: block;'
                )
            ),
            'on'  => 'link-on',
            'off' => 'link-off'
        );

        $n = new Nav($tree, $config);
        $r = $n->render(true);

        ob_start();
        $n->render();
        echo $n;
        $output = ob_get_clean();

        $this->assertContains('id="main-nav"', $r);
        $this->assertContains('<li id="menu-2" class="item-2"', $r);
        $this->assertContains('<li id="menu-2" class="item-2"', $r);
        $this->assertContains('class="link-off"', $r);
        $this->assertContains('class="link-on"', $r);

        $this->assertContains('id="main-nav"', $output);
        $this->assertContains('<li id="menu-2" class="item-2"', $output);
        $this->assertContains('<li id="menu-2" class="item-2"', $output);
        $this->assertContains('class="link-off"', $output);
        $this->assertContains('class="link-on"', $output);
    }

    public function testRebuildNav()
    {
        $_SERVER['REQUEST_URI'] = '/first';

        $tree = array(
            array(
                'name'     => 'First Nav Item',
                'href'     => '/first',
                'children' => array(
                    array(
                        'name' => 'First Child',
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
                'href'     => '/second',
                'attributes' => array(
                    'style' => 'display: block;'
                )
            )
        );

        $config  = array(
            'top' => array(
                'node'  => 'ul',
                'id'    => 'main-nav',
                'class' => 'main-nav',
                'attributes' => array(
                    'style' => 'display: block;'
                )
            ),
            'parent' => array(
                'node'  => 'ul',
                'id'    => 'nav',
                'class' => 'level',
                'attributes' => array(
                    'style' => 'display: block;'
                )
            ),
            'child' => array(
                'node'  => 'li',
                'id'    => 'menu',
                'class' => 'item',
                'attributes' => array(
                    'style' => 'display: block;'
                )
            )
        );

        $n = new Nav($tree, $config);
        $r = $n->render(true);

        ob_start();
        $n->render();
        echo $n;
        $output = ob_get_clean();

        $this->assertNotContains('New Nav Item', $r);
        $this->assertNotContains('New Nav Item', $output);

        $n->addBranch(array(
            'name' => 'New Nav Item',
            'href' => '/new-nav'
        ));
        $n->rebuild();
        $r = $n->render(true);

        ob_start();
        $n->render();
        echo $n;
        $output = ob_get_clean();

        $this->assertContains('New Nav Item', $r);
        $this->assertContains('New Nav Item', $output);
    }

    public function testBuildNavWithAcl()
    {
        $_SERVER['REQUEST_URI'] = '/first';

        $page = new Auth\Resource('page');
        $user = new Auth\Resource('user');

        $basic = Auth\Role::factory('basic')->addPermission('add');
        $editor = Auth\Role::factory('editor')->addPermission('add')
            ->addPermission('edit');

        $acl = new Auth\Acl();
        $acl->addRoles(array($basic, $editor));
        $acl->addResources(array($page, $user));

        $acl->allow('basic', 'page', array('add'))
            ->allow('editor', 'page')
            ->allow('editor', 'user');

        $tree = array(
            array(
                'name'     => 'Pages',
                'href'     => '/pages',
                'children' => array(
                    array(
                        'name' => 'Add Page',
                        'href' => 'add',
                        'acl'  => array(
                            'resource'   => 'page',
                            'permission' => 'add'
                        )
                    ),
                    array(
                        'name' => 'Edit Page',
                        'href' => 'edit',
                        'acl'  => array(
                            'resource'   => 'page',
                            'permission' => 'edit'
                        )
                    )
                )
            ),
            array(
                'name'     => 'Users',
                'href'     => '/users',
                'acl'  => array(
                    'resource'   => 'user'
                ),
                'children' => array(
                    array(
                        'name' => 'Add User',
                        'href' => 'add'
                    ),
                    array(
                        'name' => 'Edit User',
                        'href' => 'edit'
                    )
                )
            )
        );

        $n = new Nav($tree);
        $n->setAcl($acl)
          ->setRole($editor);

        $r = $n->render(true);
        $this->assertContains('<a href="/users/add">Add User</a>', $r);
    }

    public function testBuildAclException()
    {
        $_SERVER['REQUEST_URI'] = '/first';

        $this->setExpectedException('Pop\Nav\Exception');
        $page = new Auth\Resource('page');
        $user = new Auth\Resource('user');

        $basic = Auth\Role::factory('basic')->addPermission('add');
        $editor = Auth\Role::factory('editor')->addPermission('add')
            ->addPermission('edit');

        $acl = new Auth\Acl();
        $acl->addRoles(array($basic, $editor));
        $acl->addResources(array($page, $user));

        $acl->allow('basic', 'page', array('add'))
            ->allow('editor', 'page')
            ->allow('editor', 'user');

        $tree = array(
            array(
                'name'     => 'Pages',
                'href'     => '/pages',
                'children' => array(
                    array(
                        'name' => 'Add Page',
                        'href' => 'add',
                        'acl'  => array(
                            'resource'   => 'page',
                            'permission' => 'add'
                        )
                    ),
                    array(
                        'name' => 'Edit Page',
                        'href' => 'edit',
                        'acl'  => array(
                            'resource'   => 'page',
                            'permission' => 'edit'
                        )
                    )
                )
            ),
            array(
                'name'     => 'Users',
                'href'     => '/users',
                'acl'  => array(
                    'resource'   => 'user'
                ),
                'children' => array(
                    array(
                        'name' => 'Add User',
                        'href' => 'add'
                    ),
                    array(
                        'name' => 'Edit User',
                        'href' => 'edit'
                    )
                )
            )
        );

        $n = new Nav($tree);
        $n->setRole($editor);
        $r = $n->render(true);
    }

    public function testBuildRoleException()
    {
        $_SERVER['REQUEST_URI'] = '/first';

        $this->setExpectedException('Pop\Nav\Exception');
        $page = new Auth\Resource('page');
        $user = new Auth\Resource('user');

        $basic = Auth\Role::factory('basic')->addPermission('add');
        $editor = Auth\Role::factory('editor')->addPermission('add')
            ->addPermission('edit');

        $acl = new Auth\Acl();
        $acl->addRoles(array($basic, $editor));
        $acl->addResources(array($page, $user));

        $acl->allow('basic', 'page', array('add'))
            ->allow('editor', 'page')
            ->allow('editor', 'user');

        $tree = array(
            array(
                'name'     => 'Pages',
                'href'     => '/pages',
                'children' => array(
                    array(
                        'name' => 'Add Page',
                        'href' => 'add',
                        'acl'  => array(
                            'resource'   => 'page',
                            'permission' => 'add'
                        )
                    ),
                    array(
                        'name' => 'Edit Page',
                        'href' => 'edit',
                        'acl'  => array(
                            'resource'   => 'page',
                            'permission' => 'edit'
                        )
                    )
                )
            ),
            array(
                'name'     => 'Users',
                'href'     => '/users',
                'acl'  => array(
                    'resource'   => 'user'
                ),
                'children' => array(
                    array(
                        'name' => 'Add User',
                        'href' => 'add'
                    ),
                    array(
                        'name' => 'Edit User',
                        'href' => 'edit'
                    )
                )
            )
        );

        $n = new Nav($tree);
        $n->setAcl($acl);
        $r = $n->render(true);
    }

}

