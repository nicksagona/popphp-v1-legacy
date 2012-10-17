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
 * @package    Pop_Loader
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Loader;

use Pop\Dir\Dir,
    Pop\File\File;

/**
 * This is the Classmap class for the Loader component.
 *
 * @category   Pop
 * @package    Pop_Loader
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.0
 */
class Classmap
{

    /**
     * Static method to generate a class map file
     *
     * @param  string $inputFolder
     * @param  string $outputFile
     * @return void
     */
    public static function generate($inputFolder, $outputFile)
    {
        $dir = new Dir(realpath($inputFolder), true, true);
        $matches = array();

        foreach ($dir->files as $file) {
            if (substr($file, -4) == '.php') {
                $classMatch = array();
                $namespaceMatch = array();

                $classFile = new File($file);
                $classFileContents = $classFile->read();

                preg_match('/^class(.*)$/m', $classFileContents, $classMatch);
                preg_match('/^namespace(.*)$/m', $classFileContents, $namespaceMatch);

                $ary = array();
                if (isset($classMatch[0])) {
                    $ary['file'] = str_replace('\\', '/', $file);
                    $ary['class'] = self::parseClass($classMatch[0]);
                    $ary['namespace'] = (isset($namespaceMatch[0])) ? self::parseNamespace($namespaceMatch[0]) : null;
                    $matches[] = $ary;
                }
            }
        }

        if (count($matches) > 0) {
            $classMap = '<?php' . PHP_EOL . PHP_EOL . 'return array(';

            $i = 1;
            foreach ($matches as $class) {
                $comma = ($i < count($matches)) ? ',' : null;
                $className = (null !== $class['namespace']) ? $class['namespace'] . '\\' . $class['class'] : $class['class'];
                $classMap .= PHP_EOL . '    \'' . $className . '\' => \'' . $class['file'] . '\'' . $comma;
                $i++;
            }

            $classMap .= PHP_EOL . ');' . PHP_EOL;

            $output = new File($outputFile);
            $output->write($classMap)
                   ->save();
        }
    }

    /**
     * Static method to parse class name out
     *
     * @param  string $classString
     * @return string
     */
    protected static function parseClass($classString)
    {
        $cls = str_replace('class ', '', $classString);
        if (strpos($cls, ' ') !== false) {
            $cls = substr($cls, 0, strpos($cls, ' '));
        }
        return trim($cls);
    }

    /**
     * Static method to parse namespace name out
     *
     * @param  string $namespaceString
     * @return string
     */
    protected static function parseNamespace($namespaceString)
    {
        $ns = trim(str_replace(';', '', str_replace('namespace ', '', $namespaceString)));
        return $ns;
    }

}
