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
     * @return \Pop\Auth\Acl
     */
    public function __construct($roles = null)
    {
        if (null !== $roles) {
            $this->addRoles($roles);
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
     * @param  mixed $role
     * @param  int   $value
     * @return \Pop\Auth\Acl
     */
    public function setRequiredRole($role = null, $value = 0)
    {
        if (null === $role) {
            $this->required = null;
        } else {
            if ($role instanceof Role) {
                if (!array_key_exists($role->getName(), $this->roles)) {
                    $this->roles[$role->getName()] = $role;
                }
                $this->required = $role;
            } else {
                if (!array_key_exists($role, $this->roles)) {
                    $this->roles[$role] = Role::factory($role, $value);
                }
                $this->required = $this->roles[$role];
            }
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
                } else if (isset($r[0]) && isset($r[1])) {
                    $this->roles[$r[0]] = Role::factory($r[0], $r[1]);
                }
            }
        } else if ($roles instanceof Role) {
            $this->roles[$roles->getName()] = $roles;
        }

        return $this;
    }

    /**
     * Method to get a role
     *
     * @param  string $role
     * @return \Pop\Auth\Role
     */
    public function getRole($role)
    {
        return (array_key_exists($role, $this->roles)) ? $this->roles[$role] : null;
    }

    /**
     * Method to remove a role
     *
     * @param  mixed $role
     * @return \Pop\Auth\Acl
     */
    public function removeRole($role)
    {
        $roleName = ($role instanceof Role) ? $role->getName() : $role;

        if (array_key_exists($roleName, $this->roles)) {
            unset($this->roles[$roleName]);
        }

        return $this;
    }

    /**
     * Method to determine if the user is authorized
     *
     * @param  mixed $user
     * @param  mixed $role
     * @param  int   $value
     * @return boolean
     */
    public function isAuthorized($user, $role = null, $value = 0)
    {
        if (null !== $role) {
            $this->setRequiredRole($role, $value);
        }

        if (null === $this->required) {
            $result = true;
        } else {
            if ($user instanceof Role) {
                $result = ($user->compare($this->required) >= 0);
            } else if (array_key_exists($user, $this->roles)) {
                $result = ($this->roles[$user]->compare($this->required) >= 0);
            } else {
                $result = false;
            }
        }

        return $result;
    }

}
