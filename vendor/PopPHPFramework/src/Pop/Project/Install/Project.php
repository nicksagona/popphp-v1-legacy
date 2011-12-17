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
    Pop\Locale\Locale;

/**
 * @category   Pop
 * @package    Pop_Project
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Project
{

    /**
     * Install the project class files
     *
     * @param Pop\Config $install
     * @param string     $installDir
     * @return void
     */
    public static function install($install, $installDir)
    {
        // Create the project class file
        $projectCls = new File($install->project->base . '/module/' . $install->project->name . '/src/' . $install->project->name . '/Project.php');
        $projectCls->write('<?php' . PHP_EOL . PHP_EOL)
                   ->write('namespace ' . $install->project->name . ';' . PHP_EOL . PHP_EOL, true)
                   ->write('use Pop\\Project\\Project as P;' . PHP_EOL . PHP_EOL, true)
                   ->write('class Project extends P' . PHP_EOL, true)
                   ->write('{' . PHP_EOL . PHP_EOL, true)
                   ->write('    public function run()' . PHP_EOL, true)
                   ->write('    {' . PHP_EOL, true)
                   ->write('        // Add any project specific code for run-time here.' . PHP_EOL, true)
                   ->write('        parent::run();' . PHP_EOL, true)
                   ->write('    }' . PHP_EOL . PHP_EOL, true)
                   ->write('}' . PHP_EOL, true)
                   ->save();

        // Create the controller class file
        if (isset($install->controller)) {
            if (!file_exists($install->project->base . '/view')) {
                mkdir($install->project->base . '/view');
            }
            $controllerCls = new File($install->project->base . '/module/' . $install->project->name . '/src/' . $install->project->name . '/Controller.php');
            $controllerCls->write('<?php' . PHP_EOL . PHP_EOL)
                          ->write('namespace ' . $install->project->name. ';' . PHP_EOL . PHP_EOL, true)
                          ->write('use Pop\\Http\\Response,' . PHP_EOL, true)
                          ->write('    Pop\\Http\\Request,' . PHP_EOL, true)
                          ->write('    Pop\\Mvc\\Controller as C,' . PHP_EOL, true)
                          ->write('    Pop\\Mvc\\Model,' . PHP_EOL, true)
                          ->write('    Pop\\Mvc\\View;' . PHP_EOL . PHP_EOL, true)
                          ->write('class Controller extends C' . PHP_EOL, true)
                          ->write('{' . PHP_EOL . PHP_EOL, true)
                          ->write("    public function __construct(Request \$request = null, Response \$response = null, \$viewPath = null)" . PHP_EOL, true)
                          ->write("    {" . PHP_EOL, true)
                          ->write("        if (null === \$viewPath) {" . PHP_EOL, true)
                          ->write("            \$viewPath = __DIR__ . '/../../../../view';" . PHP_EOL, true)
                          ->write("        }" . PHP_EOL . PHP_EOL, true)
                          ->write("        parent::__construct(\$request, \$response, \$viewPath);" . PHP_EOL . PHP_EOL, true)
                          ->write("        if (\$this->_request->getRequestUri() == '/') {" . PHP_EOL, true)
                          ->write("            \$this->index();" . PHP_EOL, true)
                          ->write("        } else if (!is_null(\$this->_request->getPath(0)) && method_exists(\$this, \$this->_request->getPath(0))) {" . PHP_EOL, true)
                          ->write("            \$path = \$this->_request->getPath(0);" . PHP_EOL, true)
                          ->write("            \$this->\$path();" . PHP_EOL, true)
                          ->write("        } else {" . PHP_EOL, true)
                          ->write("            \$this->_isError = true;" . PHP_EOL, true)
                          ->write("            \$this->error();" . PHP_EOL, true)
                          ->write("        }" . PHP_EOL, true)
                          ->write("    }" . PHP_EOL. PHP_EOL, true);
            $views = $install->controller->asArray();
            foreach ($views as $key => $value) {
                if (file_exists($installDir . '/view/' . $value)) {
                    copy($installDir . '/view/' . $value, $install->project->base . '/view/' . $value);
                }
                $controllerCls->write("    public function {$key}()" . PHP_EOL, true)
                              ->write("    {" . PHP_EOL, true)
                              ->write("        // Add your model data here to inject into the view." . PHP_EOL, true)
                              ->write("        \$this->_view = View::factory(\$this->_viewPath . '/{$value}');" . PHP_EOL, true)
                              ->write("    }" . PHP_EOL . PHP_EOL, true);
            }
            $controllerCls->write('}' . PHP_EOL, true)
                          ->save();
        }

        $input = self::installWeb();

        if ($input != 'n') {
            if (file_exists(__DIR__ . '/Web/index.php')) {
                copy(__DIR__ . '/Web/index.php', $install->project->docroot . '/index.php');
            }
            if ($input == 'a') {
                if (file_exists(__DIR__ . '/Web/ht.access')) {
                    copy(__DIR__ . '/Web/ht.access', $install->project->docroot . '/.htaccess');
                }
            } else {
                if (file_exists(__DIR__ . '/Web/web.config')) {
                    copy(__DIR__ . '/Web/web.config', $install->project->docroot . '/web.config');
                }
            }
        }
    }

    /**
     * Install index controller and web config files prompt
     *
     * @return string
     */
    public static function installWeb()
    {
        $msg = Locale::factory()->__('Install index controller and web configuration files?') . ' ([A]pache/[I]IS/[N]o) ';
        echo $msg;
        $input = null;

        while (($input != 'a') && ($input != 'i') && ($input != 'n')) {
            if (null !== $input) {
                echo $msg;
            }
            $prompt = fopen("php://stdin", "r");
            $input = fgets($prompt, 32);
            $input = substr(strtolower(rtrim($input)), 0, 1);
            fclose ($prompt);
        }

        return $input;
    }

}
