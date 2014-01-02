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
namespace Pop;

use Pop\Loader\Autoloader;
use Pop\Filter\Search;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class SearchTest extends \PHPUnit_Framework_TestCase
{

    public function testSearch()
    {
        $s = Search::factory('1|2|3|4|5', '|');
        $a = Search::factory(array(1, 2, 3, 4, 5));
        $this->assertInstanceOf('Pop\Filter\Search', $s);
        $r1 = $s->search('1');
        $r2 = $a->search('1', true);
        $this->assertTrue(in_array('1', $r1));
        $this->assertTrue(in_array('1', $r2));
    }

    public function testSearchPattern()
    {
        $ary = array(
            'Bubba',
            'Bub',
            'Bob',
            'Bobby',
            'Bobbie'
        );
        $s = Search::factory($ary);
        $r1 = $s->search('Bub*');
        $r2 = $s->search('*b');
        $r1 = $s->search('Bub*', true);
        $r2 = $s->search('*b', true);
        $this->assertTrue(in_array('Bubba', $r1));
        $this->assertTrue(in_array('Bub', $r1));
        $this->assertTrue(in_array('Bub', $r2));
        $this->assertTrue(in_array('Bob', $r2));
    }

    public function testSearchPatternCase()
    {
        $ary = array(
            'Bubba',
            'Bub',
            'Bob',
            'Bobby',
            'Bobbie'
        );
        $s = Search::factory($ary);
        $r1 = $s->search('bub*', true);
        $r2 = $s->search('*B', true);
        $this->assertFalse(in_array('Bubba', $r1));
        $this->assertFalse(in_array('Bub', $r1));
        $this->assertFalse(in_array('Bub', $r2));
        $this->assertFalse(in_array('Bob', $r2));
    }

}

