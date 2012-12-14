Pop PHP Framework
=================

Documentation : Event
---------------------

The Event component provides a way to attach and trigger events within the life cycle of an application. The main benefit is the ability to extend an application by hooking functionality into it via closures and classes that are attached as events.

Here's an example of attaching and triggering an event using closures. The second one receives the result from the first one.

<pre>
use Pop\Event\Manager;

$manager = new Manager();

$manager-&gt;attach('pre', function($name) { return 'Hello, ' . $name; }, 2);
$manager-&gt;attach('pre', function($result) { echo $result . '&lt;br /&gt;' . PHP_EOL; }, 1);

$manager-&gt;trigger('pre', array('name' =&gt; 'World'));
</pre>

Here's an example using a class.

<pre>
use Pop\Event\Manager;

class Foo
{
    public $value;

    public function __construct($arg = null)
    {
        $this-&gt;value = $arg;
    }

    public static function factory($arg)
    {
        return new self($arg);
    }

    public function bar($arg)
    {
        $this-&gt;value = $arg;
        return $this;
    }
}

$manager = new Manager();

$manager-&gt;attach('pre', 'Foo::factory', 2);

// OR
//$manager-&gt;attach('pre', array(new Foo, 'bar'), 2);

$manager-&gt;attach('pre', function($result) { echo 'Hello, ' . $result-&gt;value . '&lt;br /&gt;' . PHP_EOL; }, 1);
$manager-&gt;trigger('pre', array('arg' =&gt; 'World'));
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
