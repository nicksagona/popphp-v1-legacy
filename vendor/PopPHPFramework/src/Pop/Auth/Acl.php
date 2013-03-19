<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Auth
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Auth;


/**
 * ACL class
 *
 * @category   Pop
 * @package    Pop_Auth
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.2.2
 */
class Acl
{

    /**
     * Array of roles
     * @var array
     */
    protected $roles = array();

    /**
     * Required role
     * @var mixed
     */
    protected $required = null;

    /**
     * Constructor
     *
     * Instantiate the auth object
     *
     * @param  mixed $roles
     * @param  mixed $requiredRole
     * @param  int   $value
     * @return \Pop\Auth\Acl
     */
    public function __construct($roles = null, $requiredRole = null, $value = 0)
    {
        if (null !== $roles) {
            $this->addRoles($roles);
        }
        if (null !== $requiredRole) {
            $this->setRequiredRole($requiredRole, $value);
        }
    }

    /**
     * Static method to instantiate the ACL object and return itself
     * to facilitate chaining methods together.
     *
     * @param  mixed $roles
     * @return \Pop\Auth\Acl
     */
    public static function factory($roles = null)
    {
        return new self($roles);
    }

    /**
     * Method to get the required role
     *
     * @return \Pop\Auth\Role
     */
    public function getRequiredRole()
    {
        return $this->required;
    }

    /**
     * Method to set the required role
     *
     * @param  mixed $requiredRole
     * @param  int   $value
     * @return \Pop\Auth\Acl
     */
    public function setRequiredRole($requiredRole = null, $value = 0)
    {
        if (null === $requiredRole) {
            $this->required = null;
        } else {
            $this->required = ($requiredRole instanceof Role) ? $requiredRole :
                Role::factory($requiredRole, $value);
        }

        return $this;
    }

    /**
     * Method to add a role
     *
     * @param  mixed $roles
     * @return \Pop\Auth\Acl
     */
    public function addRoles($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $r) {
                if ($r instanceof Role) {
                    $this->roles[$r->getName()] = $r;
                } else if (isset($r[0])) {
                    $this->roles[$r[0]] = Role::factory($r[0], (isset($r[1]) ? $r[1] : 0));
                }
            }
        } else if ($roles instanceof Role) {
            $this->roles[$roles->getName()] = $roles;
        }

        return $this;
    }

    /**
     * Method to determine if the user is allowed
     *
     * @return boolean
     */
    public function isAllowed()
    {
        /*
        if (null !== $requiredRole) {
            $this->setRequiredRole($requiredRole, $value);
        }

        if (null === $this->required) {
            $result = true;
        } else {
            if (count($this->roles) == 1) {
                reset($this->roles);
                $user = current($this->roles);
                $result = ($user->compare($this->required) >= 0);
            } else if (count($this->roles) > 0) {
                $result = (array_key_exists($this->required->getName(), $this->roles));
            }
        }
        */
        $result = false;
        return $result;
    }

}
