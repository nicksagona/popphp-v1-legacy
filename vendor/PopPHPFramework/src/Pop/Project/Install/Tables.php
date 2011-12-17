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
 * @package    Pop_Project
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Project\Install;

use Pop\File\File,
    Pop\Filter\String,
    Pop\Locale\Locale;

/**
 * @category   Pop
 * @package    Pop_Project
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Tables
{

    /**
     * Install the table class files
     *
     * @param Pop\Config $install
     * @param array  $dbTables
     * @return void
     */
    public static function install($install, $dbTables)
    {
        echo Locale::factory()->__('Creating database table class files...') . PHP_EOL;

        $tableDir = $install->project->base . '/module/' . $install->project->name . '/src/' . $install->project->name . '/Table';
        if (!file_exists($tableDir)) {
            mkdir($tableDir);
        }

        foreach ($dbTables as $table) {
            if (null !== $table['tableName']) {
                $tableName = String::factory($table['tableName'])->underscoreToCamelcase()->upperFirst();
                $tableCls = new File($tableDir . '/' . $tableName . '.php');
                $tableCls->write('<?php' . PHP_EOL . PHP_EOL)
                         ->write('namespace ' . $install->project->name . '\\Table;' . PHP_EOL . PHP_EOL, true)
                         ->write('use Pop\\Record\\Record;' . PHP_EOL . PHP_EOL, true);

                $auto = ($table['auto']) ? 'true' : 'false';
                $primaryId = (null !== $table['primaryId']) ? "'" . $table['primaryId'] . "'" : 'null';

                $tableCls->write('class ' . $tableName . ' extends Record' . PHP_EOL, true)
                         ->write('{' . PHP_EOL . PHP_EOL, true)
                         ->write('    protected $_primaryId = ' . $primaryId . ';' . PHP_EOL . PHP_EOL, true)
                         ->write('    protected $_auto =  ' . $auto . ';' . PHP_EOL . PHP_EOL, true)
                         ->write('}' . PHP_EOL, true)
                         ->save();
            }
        }
    }

}
