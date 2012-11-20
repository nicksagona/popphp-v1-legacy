<?php
/**
 * Pop PHP Framework
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
 * @category   Pop
 * @package    Pop_Data
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Data;

/**
 * This is the Yaml class for the Data component.
 *
 * @category   Pop
 * @package    Pop_Data
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.0.2
 */
class Yaml implements DataInterface
{

    /**
     * Decode the data into PHP.
     *
     * @param  string $data
     * @return mixed
     */
    public static function decode($data)
    {
        $eol = (strpos($data, "-\r\n") !== false) ? "-\r\n" : "-\n";
        $yaml = substr($data, (strpos($data, $eol) + strlen($eol)));
        $yamlAry = explode($eol, $yaml);

        $nodes = array();
        $i = 1;

        foreach ($yamlAry as $value) {
            $objs = explode("\n", trim($value));
            $ob = array();
            foreach ($objs as $v) {
                $vAry = explode(':', $v);
                $val = trim($vAry[1]);
                $val = substr($val, 1, -1);
                $ob[trim($vAry[0])] = stripslashes($val);
            }
            $nodes['row_' . $i] = $ob;
            $i++;
        }

        return $nodes;
    }

    /**
     * Encode the data into its native format.
     *
     * @param  mixed  $data
     * @return string
     */
    public static function encode($data)
    {
        $yaml = "%YAML 1.1\n---\n";

        foreach($data as $key => $ary) {
            foreach ($ary as $k => $v) {
                $yaml .= " " . $k . ": \"" . addslashes($v) . "\"\n";
            }
            $yaml .= "-\n";
        }

        return $yaml;
    }

}
