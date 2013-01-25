<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Project
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Project\Install;

use Pop\Code\Generator,
    Pop\Code\Generator\MethodGenerator,
    Pop\Code\Generator\NamespaceGenerator;

/**
 * Model install class
 *
 * @category   Pop
 * @package    Pop_Project
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.2.0
 */
class Models
{

    /**
     * Install the model class files
     *
     * @param \Pop\Config $install
     * @return void
     */
    public static function install($install)
    {
        echo \Pop\Locale\Locale::factory()->__('Creating model class files...') . PHP_EOL;

        // Create model class folder
        $modelDir = $install->project->base . '/module/' . $install->project->name . '/src/' . $install->project->name . '/Model';
        if (!file_exists($modelDir)) {
            mkdir($modelDir);
        }

        $models = $install->models->asArray();
        foreach ($models as $model) {
            $modelName = ucfirst(\Pop\Filter\String::underscoreToCamelcase($model));

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
