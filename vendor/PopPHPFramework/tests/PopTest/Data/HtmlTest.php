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
namespace PopTest\Data;

use Pop\Loader\Autoloader;
use Pop\Data\Type\Html;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class HtmlTest extends \PHPUnit_Framework_TestCase
{

    public function testEncode()
    {
        $data = array(
            array(
                'id' => 1001,
                'first_name' => 'Bob',
                'last_name'  => 'Smith',
                'birth_date' => '1977-08-19'
            ),
            array(
                'id' => 1002,
                'first_name' => 'Bubba',
                'last_name'  => 'Smith',
                'birth_date' => '1975-01-12'
            ),
            array(
                'id' => 1003,
                'first_name' => 'Ted',
                'last_name'  => 'Smith',
                'birth_date' => '1971-11-21'
            )
        );

        $options = array(
            'form' => array(
                'id'      => 'data-form',
                'action'  => '/some-action',
                'method'  => 'post',
                'process' => '<input type="checkbox" name="rm_users[]" id="rm_users[{i}]" value="[{id}]" />',
                'submit'  => array(
                    'class' => 'submit-btn',
                    'value' => 'Remove?'
                )
            ),
            'table' => array(
                'cellpadding' => 0,
                'cellspacing' => 0,
                'border'      => 0,
                'class'       => 'data-table'
            ),
            'last_name' => '<a href="/edit/[{id}]">[{last_name}]</a>'
        );

        $html = Html::encode($data, $options);
        $this->assertContains('<form id="data-form"', $html);
        $this->assertContains('<tr><th class="first-th">Id</th><th>First Name</th><th>Last Name</th><th>Birth Date</th><th class="last-th">Remove?</th></tr>', $html);
        $this->assertContains('<tr><td class="first-td">1001</td><td>Bob</td><td><a href="/edit/1001">Smith</a></td><td>Aug 19, 1977</td><td class="last-td"><input type="checkbox" name="rm_users[]" id="rm_users1" value="1001" /></td></tr>', $html);
        $this->assertContains('<tr class="table-bottom-row"><td colspan="5" class="table-bottom-row"><input type="submit" name="submit" id="submit" class="submit-btn" value="Remove?" /></td></tr>', $html);
    }

}

