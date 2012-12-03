<?php
/**
 * Pop PHP Framework Unit Tests
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.TXT.
 * It is also available through the world-wide-web at this URL:
 * http://www.popphp.org/LICENSE.TXT
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@popphp.org so we can send you a copy immediately.
 *
 */

namespace PopTest\Form;

use Pop\Loader\Autoloader,
    Pop\Form\Fields;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class FieldsTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $this->assertInstanceOf('Pop\Form\Fields', new Fields());
    }

    public function testAddAndGetFields()
    {
        $fields = array(array(
            'type'       => 'text',
            'name'       => 'username',
            'value'      => 'Username here...',
            'label'      => 'Username:',
            'required'   => true,
            'attributes' => array('size', 40)
        ));
        $f = new Fields($fields);
        $f->addFields(array(
            'type' => 'submit',
            'name' => 'submit',
            'value' => 'SUBMIT'
        ));
        $this->assertEquals(2, count($f->getFields()));
    }

}

