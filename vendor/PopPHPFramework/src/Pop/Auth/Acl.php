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
                } else {
                    $this->roles[$r] = Role::factory($r);
                }
            }
        } else if ($roles instanceof Role) {
            $this->roles[$roles->getName()] = $roles;
        } else {
            $this->roles[$roles] = Role::factory($roles);
        }

        return $this;
    }

    /**
     * Method to determine if the user is allowed
     *
     * @param  \Pop\Auth\Role     $user
     * @param  \Pop\Auth\Resource $resource
     * @param  string             $permission
     * @return boolean
     */
    public function isAllowed(\Pop\Auth\Role $user, \Pop\Auth\Resource $resource, $permission = null)
    {
        $result = false;
        return $result;
    }

}
