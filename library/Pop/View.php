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
 * @package    Pop_View
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * Pop_View
 *
 * @category   Pop
 * @package    Pop_View
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9 beta
 */

class Pop_View
{

    /**
     * View template file
     * @var string
     */
    protected $_templateFile = null;

    /**
     * View template string
     * @var string
     */
    protected $_templateString = null;

    /**
     * Data model
     * @var Pop_Model
     */
    protected $_model = null;

    /**
     * View output string
     * @var string
     */
    protected $_output = null;

    /**
     * Language object
     * @var Pop_Locale
     */
    protected $_lang = null;

    /**
     * Constructor
     *
     * Instantiate the view object.
     *
     * @param string      $template
     * @param Pop_Model $model
     * @return void
     */
    public function __construct($template = null, Pop_Model $model = null)
    {
        $this->_lang = new Pop_Locale();

        if (!is_null($template)) {
            if (((substr($template, -6) == '.phtml') ||
                 (substr($template, -5) == '.php3') ||
                 (substr($template, -4) == '.php')) && (file_exists($template))) {

                $this->_templateFile = $template;

            } else {
                $this->_templateString = $template;
            }
        }

        $this->_model = $model;
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


    /**
     * Create a Pop_View object
     *
     * @param string    $template
     * @param Pop_Model $model
     * @return Pop_View
     */
    public static function factory($template = null, Pop_Model $model = null)
    {
        return new self($template, $model);
    }

    /**
     * Get data model
     *
     * @return Pop_Model
     */
    public function getModel()
    {
        return $this->_model;
    }

    /**
     * Get view template file
     *
     * @return string
     */
    public function getTemplateFile()
    {
        return $this->_templateFile;
    }

    /**
     * Get view template string
     *
     * @return string
     */
    public function getTemplateString()
    {
        return $this->_templateString;
    }

    /**
     * Set view template file
     *
     * @param  string $template
     * @throws Exception
     * @return Pop_View
     */
    public function setTemplateFile($template = null)
    {
        if (!is_null($template)) {
            if (((substr($template, -6) == '.phtml') ||
                 (substr($template, -5) == '.php3') ||
                 (substr($template, -4) == '.php')) && (file_exists($template))) {

                $this->_templateFile = $template;

            } else {
                throw new Exception($this->_lang->__('That template file either does not exist or is not the correct format.'));
            }
        } else {
            $this->_templateFile = $template;
        }

        return $this;
    }

    /**
     * Set view template string
     *
     * @param  string $template
     * @return Pop_View
     */
    public function setTemplateString($template = null)
    {
        $this->_templateString = $template;
        return $this;
    }

    /**
     * Set data model
     *
     * @param  Pop_Model $model
     * @return Pop_View
     */
    public function setModel(Pop_Model $model)
    {
        $this->_model = $model;
        return $this;
    }

    /**
     * Render the view.
     *
     * @param  boolean $ret
     * @throws Exception
     * @return string
     */
    public function render($ret = false)
    {
        if (is_null($this->_templateFile) && is_null($this->_templateString)) {
            throw new Exception($this->_lang->__('A template asset has not been assigned.'));
        } else {
            if (!is_null($this->_templateFile)) {
                $this->_renderTemplateFile();
            } else {
                $this->_renderTemplateString();
            }

            if ($ret) {
                return $this->_output;
            } else {
                echo $this->_output;
            }
        }
    }

    /**
     * Render view template file
     *
     * @return void
     */
    protected function _renderTemplateFile()
    {
        $data = $this->_model->getData();

        foreach ($data as $key => $value) {
            ${$key} = $value;
        }

        ob_start();
        include $this->_templateFile;
        $this->_output = ob_get_clean();
    }

    /**
     * Render view template string
     *
     * @return void
     */
    protected function _renderTemplateString()
    {
        $this->_output = $this->_templateString;

        $data = $this->_model->getData();

        foreach ($data as $key => $value) {
            if ($value instanceof ArrayObject) {
                $start = '[{' . $key . '}]';
                $end = '[{/' . $key . '}]';

                $loopCode = substr($this->_templateString, strpos($this->_templateString, $start));
                $loopCode = substr($loopCode, 0, (strpos($loopCode, $end) + strlen($end)));

                $loop = str_replace($start, '', $loopCode);
                $loop = str_replace($end, '', $loop);
                $outputLoop = '';

                foreach ($value as $val) {
                    if ($val instanceof ArrayObject) {
                        $l = $loop;
                        foreach ($val as $k => $v) {
                            $l = str_replace('[{' . $k . '}]', $v, $l);
                        }
                        $outputLoop .= $l . PHP_EOL;
                    } else {
                        $outputLoop .= str_replace('[{value}]', $val, $loop) . PHP_EOL;
                    }
                }

                $this->_output = str_replace($loopCode, substr($outputLoop, 0, -2), $this->_output);
            } else {
                $this->_output = str_replace('[{' . $key . '}]', $value, $this->_output);
            }
        }
    }

}
