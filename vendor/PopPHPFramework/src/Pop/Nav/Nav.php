<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Nav
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Nav;

use Pop\Dom\Child;

/**
 * Nav class
 *
 * @category   Pop
 * @package    Pop_Nav
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.3.0
 */
class Nav
{

    /**
     * Nav tree
     * @var array
     */
    protected $tree = array();

    /**
     * Nav config
     * @var array
     */
    protected $config = array();

    /**
     * Nav parent level
     * @var int
     */
    protected $parentLevel = 1;

    /**
     * Nav child level
     * @var int
     */
    protected $childLevel = 1;

    /**
     * Parent nav element
     * @var \Pop\Dom\Child
     */
    protected $nav = null;

    /**
     * Constructor
     *
     * Instantiate the nav object
     *
     * @param  array $tree
     * @param  array $config
     * @return \Pop\Nav\Nav
     */
    public function __construct(array $tree, array $config = null)
    {
        $this->setTree($tree);
        $this->setConfig($config);
    }

    /**
     * Static method to instantiate the nav object and return itself
     * to facilitate chaining methods together.
     *
     * @param  array $tree
     * @param  array $config
     * @return \Pop\Nav\Nav
     */
    public static function factory(array $tree, array $config = array())
    {
        return new self($tree, $config);
    }

    /**
     * Set the nav tree
     *
     * @param  array $tree
     * @return \Pop\Nav\Nav
     */
    public function setTree(array $tree)
    {
        $this->tree = $tree;
        return $this;
    }

    /**
     * Set the nav tree
     *
     * @param  array $config
     * @return \Pop\Nav\Nav
     */
    public function setConfig(array $config = null)
    {
        if (null === $config) {
            $this->config = array(
                'parent' => array(
                    'node'  => 'ul'
                ),
                'child' => array(
                    'node'  => 'li'
                )
            );
        } else {
            $this->config = $config;
        }

        return $this;
    }

    /**
     * Build the nav object
     *
     * @return \Pop\Nav\Nav
     */
    public function build()
    {
        if (null === $this->nav) {
            $this->nav = $this->traverse($this->tree);
        }
        return $this;
    }

    /**
     * Get the nav object
     *
     * @return \Pop\Dom\Child
     */
    public function nav()
    {
        if (null === $this->nav) {
            $this->nav = $this->traverse($this->tree);
        }
        return $this->nav;
    }

    /**
     * Render the nav object
     *
     * @param  boolean $ret
     * @return mixed
     */
    public function render($ret = false)
    {
        if (null === $this->nav) {
            $this->nav = $this->traverse($this->tree);
        }

        if ($ret) {
            return $this->nav->render($ret);
        } else {
            echo $this->nav->render($ret);
        }
    }

    /**
     * Render Nav object to string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render(true);
    }

    /**
     * Traverse the config object
     *
     * @param  array $tree
     * @param  int $depth
     * @return \Pop\Dom\Child
     */
    protected function traverse(array $tree, $depth = 1)
    {
        // Set up parent/child node names
        $parent = (isset($this->config['parent']) && isset($this->config['parent']['node'])) ? $this->config['parent']['node'] : 'ul';
        $child = (isset($this->config['child']) && isset($this->config['child']['node'])) ? $this->config['child']['node'] : 'li';

        // Create parent node
        $nav = new Child($parent);

        // Set parent attributes if they exist
        if (isset($this->config['parent']) && isset($this->config['parent']['id'])) {
            $nav->setAttributes('id', $this->config['parent']['id'] . '-' . $this->parentLevel);
        }
        if (isset($this->config['parent']) && isset($this->config['parent']['class'])) {
            $nav->setAttributes('class', $this->config['parent']['class'] . '-' . $depth);
        }

        $this->parentLevel++;
        $depth++;

        // Recursively loop through the nodes
        foreach ($tree as $node) {
            if (isset($node['name']) && isset($node['href'])) {
                // Create child node and child link node
                $a = new Child('a', $node['name']);
                $a->setAttributes('href', $node['href']);
                $navChild = new Child($child);

                // Set child attributes if they exist
                if (isset($this->config['child']) && isset($this->config['child']['id'])) {
                    $navChild->setAttributes('id', $this->config['child']['id'] . '-' . $this->childLevel);
                }
                if (isset($this->config['child']) && isset($this->config['child']['class'])) {
                    $navChild->setAttributes('class', $this->config['child']['class'] . '-' . ($depth - 1));
                }

                // Add link node
                $navChild->addChild($a);
                $this->childLevel++;

                // If there are children, loop through and add them
                if (isset($node['children'])) {
                    $navChild->addChild($this->traverse($node['children'], $depth));
                }
                // Add child node
                $nav->addChild($navChild);
            }
        }

        return $nav;
    }

}