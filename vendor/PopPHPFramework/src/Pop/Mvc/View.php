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
 * @package    Pop_Mvc
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Mvc;

/**
 * This is the View class for the Mvc component.
 *
 * @category   Pop
 * @package    Pop_Mvc
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.1.2
 */
class View
{

    /**
     * View template file
     * @var string
     */
    protected $templateFile = null;

    /**
     * View template string
     * @var string
     */
    protected $templateString = null;

    /**
     * Data model
     * @var \Pop\Mvc\Model
     */
    protected $model = null;

    /**
     * View output string
     * @var string
     */
    protected $output = null;

    /**
     * Constructor
     *
     * Instantiate the view object.
     *
     * @param  string $template
     * @param  mixed  $model
     * @return \Pop\Mvc\View
     */
    public function __construct($template = null, $model = null)
    {
        if (null !== $template) {
            if (((substr($template, -6) == '.phtml') ||
                 (substr($template, -5) == '.php3') ||
                 (substr($template, -4) == '.php')) && (file_exists($template))) {

                $this->templateFile = $template;

            } else {
                $this->templateString = $template;
            }
        }

        if (null !== $model) {
            if (is_array($model)) {
                $this->model = new Model($model);
            } else if ($model instanceof Model) {
                $this->model = $model;
            }
        }
    }

    /**
     * Create a Pop\Mvc\View object
     *
     * @param  string $template
     * @param  mixed  $model
     * @return \Pop\Mvc\View
     */
    public static function factory($template = null, $model = null)
    {
        return new self($template, $model);
    }

    /**
     * Get data model
     *
     * @return \Pop\Mvc\Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Get view template file
     *
     * @return string
     */
    public function getTemplateFile()
    {
        return $this->templateFile;
    }

    /**
     * Get view template string
     *
     * @return string
     */
    public function getTemplateString()
    {
        return $this->templateString;
    }

    /**
     * Set view template file
     *
     * @param  string $template
     * @throws Exception
     * @return \Pop\Mvc\View
     */
    public function setTemplateFile($template = null)
    {
        if (null !== $template) {
            if (((substr($template, -6) == '.phtml') ||
                 (substr($template, -5) == '.php3') ||
                 (substr($template, -4) == '.php')) && (file_exists($template))) {

                $this->templateFile = $template;

            } else {
                throw new Exception('That template file either does not exist or is not the correct format.');
            }
        } else {
            $this->templateFile = $template;
        }

        return $this;
    }

    /**
     * Set view template string
     *
     * @param  string $template
     * @return \Pop\Mvc\View
     */
    public function setTemplateString($template = null)
    {
        $this->templateString = $template;
        return $this;
    }

    /**
     * Set data model
     *
     * @param  Model $model
     * @return \Pop\Mvc\View
     */
    public function setModel(Model $model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * Render the view.
     *
     * @param  boolean $ret
     * @throws Exception
     * @return mixed
     */
    public function render($ret = false)
    {
        if ((null === $this->templateFile) && (null === $this->templateString)) {
            throw new Exception('A template asset has not been assigned.');
        }

        if (null !== $this->templateFile) {
            $this->renderTemplateFile();
        } else {
            $this->renderTemplateString();
        }

        if ($ret) {
            return $this->output;
        } else {
            echo $this->output;
        }
    }

    /**
     * Render view template file
     *
     * @return void
     */
    protected function renderTemplateFile()
    {
        if (null !== $this->model) {
            $data = $this->model->asArrayObject();
            foreach ($data as $key => $value) {
                ${$key} = $value;
            }
        }

        ob_start();
        include $this->templateFile;
        $this->output = ob_get_clean();
    }

    /**
     * Render view template string
     *
     * @return void
     */
    protected function renderTemplateString()
    {
        $this->output = $this->templateString;

        if (null !== $this->model) {
            $data = $this->model->asArrayObject();

            foreach ($data as $key => $value) {
                if ($value instanceof \ArrayObject) {
                    $start = '[{' . $key . '}]';
                    $end = '[{/' . $key . '}]';

                    $loopCode = substr($this->templateString, strpos($this->templateString, $start));
                    $loopCode = substr($loopCode, 0, (strpos($loopCode, $end) + strlen($end)));

                    $loop = str_replace($start, '', $loopCode);
                    $loop = str_replace($end, '', $loop);
                    $outputLoop = '';
                    $i = 0;
                    foreach ($value as $val) {
                        if ($val instanceof \ArrayObject) {
                            $l = $loop;
                            foreach ($val as $k => $v) {
                                $l = str_replace('[{' . $k . '}]', $v, $l);
                            }
                            $outputLoop .= $l;
                        } else {
                            $outputLoop .= str_replace('[{value}]', $val, $loop);
                        }
                        $i++;
                        if ($i < count($value)) {
                            $outputLoop .= PHP_EOL;
                        }
                    }
                    $this->output = str_replace($loopCode, $outputLoop, $this->output);
                } else {
                    $this->output = str_replace('[{' . $key . '}]', $value, $this->output);
                }
            }
        }
    }

    /**
     * Return rendered view as string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render(true);
    }

}
