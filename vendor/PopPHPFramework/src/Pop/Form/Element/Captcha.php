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
 * @package    Pop_Form
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Form\Element;

use Pop\Form\Element,
    Pop\Validator\Validator\Equal,
    Pop\Web\Session;

/**
 * This is the Captcha Element class for the Form component.
 *
 * @category   Pop
 * @package    Pop_Form
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.1.0
 */
class Captcha extends Element
{
    /**
     * Session object
     * @var \Pop\Web\Session
     */
    protected $sess = null;

    /**
     * Current token data
     * @var array
     */
    protected $token = array();

    /**
     * Constructor
     *
     * Instantiate the captcha form element object.
     *
     * @param  string $name
     * @param  string $value
     * @param  int    $expire
     * @param  string $indent
     * @return \Pop\Form\Element\Captcha
     */
    public function __construct($name, $value = null, $expire = 300, $indent = null)
    {
        $this->sess = Session::getInstance();

        // If token does not exist, create one
        if (!isset($this->sess->pop_captcha)) {
            $rand1 = rand(1, 20);
            $rand2 = rand(1, 20);
            $op = (rand(1,2) == 1) ? ' + ' : ' - ';
            $equation = ($rand2 > $rand1) ? $rand2 . $op . $rand1 : $rand1 . $op . $rand2;

            $this->token = array(
                'equation' => $equation,
                'expire'   => (int)$expire,
                'start'    => time()
            );
            $this->sess->pop_captcha = serialize($this->token);
        // Else, retrieve existing token
        } else {
            $this->token = unserialize($this->sess->pop_captcha);

            // Check to see if the token has expired
            if ($this->token['expire'] > 0) {
                if (($this->token['expire'] + $this->token['start']) < time()) {
                    $rand1 = rand(1, 20);
                    $rand2 = rand(1, 20);
                    $op = (rand(1,2) == 1) ? ' + ' : ' - ';
                    $equation = ($rand2 > $rand1) ? $rand2 . $op . $rand1 : $rand1 . $op . $rand2;

                    $this->token = array(
                        'equation' => $equation,
                        'expire'   => (int)$expire,
                        'start'    => time()
                    );
                    $this->sess->pop_captcha = serialize($this->token);
                }
            }
        }

        parent::__construct('text', $name, $value, null, $indent);
        $this->setRequired(true);
        $this->setValidator();
    }

    /**
     * Set the label of the form element object.
     *
     * @param  string $label
     * @return \Pop\Form\Element
     */
    public function setLabel($label)
    {
        parent::setLabel($label);
        if (isset($this->token['equation'])) {
            $this->label = $this->label . '(' . $this->token['equation'] .')';
        }
        return $this;
    }

    /**
     * Method to set the validator
     *
     * @throws \Pop\Form\Exception
     * @return void
     */
    public function setValidator()
    {
        // Get query data
        if ($_SERVER['REQUEST_METHOD']) {
            $queryData = array();
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':
                    $queryData = $_GET;
                    break;

                case 'POST':
                    $queryData = $_POST;
                    break;

                default:
                    $input = fopen('php://input', 'r');
                    $qData = null;
                    while ($data = fread($input, 1024)) {
                        $qData .= $data;
                    }

                    parse_str($qData, $queryData);
            }

            // If there is query data, set validator to check against the token value
            if (count($queryData) > 0) {
                if (isset($queryData[$this->name])) {
                    $equation = $this->token['equation'];
                    $answer = eval("return ($equation);");
                    $this->addValidator(new Equal($answer), 'The answer is incorrect.');
                } else {
                    throw new \Pop\Form\Exception('Error: The query data could not be properly parsed.');
                }
            }
        } else {
            throw new \Pop\Form\Exception('Error: The server request method is not set.');
        }
    }
}
