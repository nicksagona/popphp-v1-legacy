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
 * This is the Csrf Element class for the Form component.
 *
 * @category   Pop
 * @package    Pop_Form
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.1.0
 */
class Csrf extends Element
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
     * Instantiate the CSRF form element object.
     *
     * @param  string $name
     * @param  string $value
     * @param  int    $expire
     * @param  string $indent
     * @return \Pop\Form\Element\Csrf
     */
    public function __construct($name, $value = null, $expire = 300, $indent = null)
    {
        $this->sess = Session::getInstance();

        if (!isset($this->sess->pop_csrf)) {
            $this->token = array(
                'value'  => sha1(rand(10000, getrandmax()) . $value),
                'expire' => (int)$expire,
                'start'  => time()
            );
            $this->sess->pop_csrf = serialize($this->token);
        } else {
            $this->token = unserialize($this->sess->pop_csrf);
            if ($this->token['expire'] > 0) {
                if (($this->token['expire'] + $this->token['start']) < time()) {
                    $this->token = array(
                        'value'  => sha1(rand(10000, getrandmax()) . $value),
                        'expire' => (int)$expire,
                        'start'  => time()
                    );
                    $this->sess->pop_csrf = serialize($this->token);
                }
            }
        }
        parent::__construct('hidden', $name, $this->token['value'], null, $indent);
        $this->addValidator(new Equal($this->token['value']), 'The security token does not match. Possible cross-site attack.');
    }

}
