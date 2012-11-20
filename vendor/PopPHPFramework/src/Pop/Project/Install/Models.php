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

use Pop\Code\Generator,
    Pop\Code\PropertyGenerator,
    Pop\Code\MethodGenerator,
    Pop\Code\NamespaceGenerator,
    Pop\Filter\String,
    Pop\Locale\Locale;

/**
 * This is the Models class for the Project Install component.
 *
 * @category   Pop
 * @package    Pop_Project
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.0.2
 */
class Models
{

    /**
     * Install the model class files
     *
     * @param Pop\Config $install
     * @return void
     */
    public static function install($install)
    {
        echo Locale::factory()->__('Creating model class files...') . PHP_EOL;

        // Create model class folder
        $modelDir = $install->project->base . '/module/' . $install->project->name . '/src/' . $install->project->name . '/Model';
        if (!file_exists($modelDir)) {
            mkdir($modelDir);
        }

        $models = $install->models->asArray();
        foreach ($models as $model) {
            $modelName = ucfirst(String::underscoreToCamelcase($model));

            // Define namespace
            $ns = new NamespaceGenerator($install->project->name . '\Model');
            $ns->setUse('Pop\Mvc\Model');

            // Create the constructor
            $construct = new MethodGenerator('__construct');
            $construct->setDesc('Instantiate the model object.');
            $construct->getDocblock()->setReturn('void');
            $construct->addArguments(
                array(
                    array('name' => 'data', 'value' => 'null', 'type' => 'mixed'),
                    array('name' => 'name', 'value' => 'null', 'type' => 'string')
                )
            );
            $construct->appendToBody("parent::__construct(\$data, \$name);", false);

            // Create and save model class file
            $modelCls = new Generator($modelDir . '/' . $modelName . '.php', Generator::CREATE_CLASS);
            $modelCls->setNamespace($ns);
            $modelCls->code()->setParent('Model')
                             ->addMethod($construct);
            $modelCls->save();
        }
    }

}
