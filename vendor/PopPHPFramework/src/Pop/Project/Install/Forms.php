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

use Pop\Code\MethodGenerator;

use Pop\Code\Generator,
    Pop\Code\PropertyGenerator,
    Pop\Code\NamespaceGenerator,
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
class Forms
{

    /**
     * Install the form class files
     *
     * @param Pop\Config $install
     * @return void
     */
    public static function install($install)
    {
        echo Locale::factory()->__('Creating form class files...') . PHP_EOL;

        // Create form class folder
        $formDir = $install->project->base . '/module/' . $install->project->name . '/src/' . $install->project->name . '/Form';
        if (!file_exists($formDir)) {
            mkdir($formDir);
        }

        $forms = $install->forms->asArray();
        foreach ($forms as $name => $form) {
            $formName = String::factory($name)->underscoreToCamelcase()->upperFirst();

            // Define namespace
            $ns = new NamespaceGenerator($install->project->name . '\\Form');
            $ns->setUse('Pop\\Form\\Form')
               ->setUse('Pop\\Form\\Element')
               ->setUse('Pop\\Validator\\Validator');

            // Create the constructor
            $construct = new MethodGenerator('__construct');
            $construct->setDesc('Constructer method to instantiate the form object');
            $construct->getDocblock()->setReturn('void');
            $construct->addArguments(
                array(
                    array('name' => 'action', 'value' => null, 'type' => 'string'),
                    array('name' => 'method', 'value' => null, 'type' => 'string'),
                    array('name' => 'fields', 'value' => 'null', 'type' => 'array'),
                    array('name' => 'indent', 'value' => 'null', 'type' => 'string')
                )
            );

            // Create the init values array within the constructor
            if (isset($form['fields'])) {
                $construct->appendToBody("\$this->_initFieldsValues = array (");
                $i = 0;
                foreach ($form['fields'] as $field) {
                    $i++;
                    $construct->appendToBody("    array (");
                    $j = 0;
                    foreach ($field as $key => $value) {
                        $j++;
                        $comma = ($j < count($field)) ? ',' : null;
                        if ($key == 'validators') {
                            $val = null;
                            if (is_array($value)) {
                                $val = 'array(' . PHP_EOL;
                                foreach ($value as $v) {
                                    $val .= '            new Validator\\' . $v . ',' . PHP_EOL;
                                }
                                $val .= '        )';
                            } else {
                                $val = 'new Validator\\' . $value;
                            }
                            $construct->appendToBody("        '{$key}' => {$val}{$comma}");
                        } else if (($key == 'value') || ($key == 'marked') || ($key == 'attributes')) {
                            $val = var_export($value, true);
                            $val = str_replace(PHP_EOL, PHP_EOL . '        ', $val);
                            if (strpos($val, 'Select::') !== false) {
                                $val = 'Element\\' . str_replace("'", '', $val);
                            }
                            $construct->appendToBody("        '{$key}' => {$val}{$comma}");
                        } else {
                            if (is_bool($value)) {
                                $val = ($value) ? 'true' : 'false';
                            } else {
                                $val = "'" . $value . "'";
                            }
                            $construct->appendToBody("        '{$key}' => {$val}{$comma}");
                        }
                    }
                    $end = ($i < count($form['fields'])) ? '    ),' : '    )';
                    $construct->appendToBody($end);
                }
                $construct->appendToBody(");");
            }

            $construct->appendToBody("parent::__construct(\$action, \$method, \$fields, \$indent);");

            // Create and save form class file
            $formCls = new Generator($formDir . '/' . $formName . '.php', Generator::CREATE_CLASS);
            $formCls->setNamespace($ns);
            $formCls->code()->setParent('Form')
                            ->addMethod($construct);

            $formCls->save();
        }
    }

}
