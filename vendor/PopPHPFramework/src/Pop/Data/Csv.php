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

use Pop\Filter\StringFilter;

/**
 * @category   Pop
 * @package    Pop_Data
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Csv implements DataInterface
{

    /**
     * Decode the data into PHP.
     *
     * @param  string $data
     * @return mixed
     */
    public static function decode($data, $delim = ',', $esc = '"')
    {
        // Read the file data, seperating by new lines.
        $lines = explode("\n", $data);

        $linesOfData = array();
        $newLinesOfData = array();

        // Loop through the line data, parsing any quoted or escaped data.
        foreach ($lines as $data) {
            if ($data != '') {
                if (strpos($data, $esc) !== false) {
                    $matches = array();
                    preg_match_all('/"([^"]*)"/', $data, $matches);
                    if (isset($matches[0])) {
                        foreach ($matches[0] as $value) {
                            $escapedData = str_replace('"', '', $value);
                            $escapedData = str_replace($delim, '[{c}]', $escapedData);
                            $data = str_replace($value, $escapedData, $data);
                        }
                    }
                }

                // Finalize the data and store in the array.
                $data = str_replace($delim, '[{d}]', $data);
                $data = str_replace('[{c}]', $delim, $data);
                $linesOfData[] = explode('[{d}]', $data);
            }
        }

        // Create a corresponding associative array by converting the array keys to the header names.
        for ($i = 1; $i < count($linesOfData); $i++) {
            $newLinesOfData['row_' . $i] = array();

            foreach ($linesOfData[$i] as $key => $value) {
                $newKey = trim($linesOfData[0][$key]);
                $newLinesOfData['row_' . $i][$newKey] = trim($value);
            }
        }

        // Return the newly formed array data.
        return $newLinesOfData;
    }

    /**
     * Encode the data into its native format.
     *
     * @param  mixed  $data
     * @return string
     */
    public static function encode($data, $omit = null, $delim = ',', $esc = '"', $dt = null)
    {
        $output = '';
        $tempAry = array();
        $headerAry = array();

        if (null === $omit) {
            $omit = array();
        } else if (!is_array($omit)) {
            $omit = array($omit);
        }

        // Initialize and clean the header fields.
        foreach ($data as $ary) {
            $tempAry = array_keys($ary);
        }

        foreach ($tempAry as $key => $value) {
            if (!in_array($key, $omit)) {
                $v = new StringFilter((string)$value);
                if ($v->pos($esc) !== false) {
                    $v->replace($esc, $esc . $esc);
                }
                if ($v->pos($delim) !== false) {
                    $v = new StringFilter($esc . $v . $esc);
                }
                $headerAry[] = (string)$v;
            }
        }

        // Set header output.
        $output .= implode($delim, $headerAry) . "\n";

        // Initialize and clean the field values.
        foreach ($data as $value) {
            $rowAry = array();
            foreach ($value as $key => $val) {
                if (!in_array($key, $omit)) {
                    if (null !== $dt) {
                        if ((strtotime($val) !== false) || (stripos($key, 'date') !== false)) {
                            $v = (date($dt, strtotime($val)) != '12/31/1969') ? new StringFilter(date($dt, strtotime((string)$val))) : new StringFilter('');
                        } else {
                            $v = new StringFilter((string)$val);
                        }
                    } else {
                        $v = new StringFilter((string)$val);
                    }
                    if ($v->pos($esc) !== false) {
                        $v->replace($esc, $esc . $esc);
                    }
                    if ($v->pos($delim) !== false) {
                        $v = new StringFilter($esc . (string)$v . $esc);
                    }
                    $rowAry[] = $v;
                }
            }

            // Set field output.
            $output .= implode($delim, $rowAry) . "\n";
        }

        return $output;
    }

}
