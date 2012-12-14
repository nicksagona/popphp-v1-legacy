Pop PHP Framework
=================

Documentation : Event
---------------------

La composante de l'événement fournit un moyen d'attacher et de déclencher des événements dans le cycle de vie d'une application. Le principal avantage est la possibilité d'étendre une application en accrochant la fonctionnalité en elle par l'intermédiaire des fermetures et des classes qui sont attachés comme des événements.

Voici un exemple d'attacher et de déclenchement d'un événement à l'aide des fermetures. Le second reçoit le résultat de la première.

<pre>
use Pop\Event\Manager;

$manager = new Manager();

$manager-&gt;attach('pre', function($name) { return 'Hello, ' . $name; }, 2);
$manager-&gt;attach('pre', function($result) { echo $result . '&lt;br /&gt;' . PHP_EOL; }, 1);

$manager-&gt;trigger('pre', array('name' =&gt; 'World'));
</pre>

Voici un exemple en utilisant une classe.

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
