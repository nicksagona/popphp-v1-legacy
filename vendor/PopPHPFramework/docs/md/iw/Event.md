Pop PHP Framework
=================

Documentation : Event
---------------------

מרכיב האירוע מספק דרך לצרף ולהפעיל אירועים במחזור החיים של יישום.היתרון העיקרי הוא היכולת להרחיב יישום על ידי משדלים פונקציונלי לתוכו באמצעות סגרים וכיתות המחוברים כאירועים.

הנה דוגמה של הצמדה ומפעיל אירוע באמצעות סגרים.השני מקבל תוצאה מהראשונה.

<pre>
use Pop\Event\Manager;

$manager = new Manager();

$manager-&gt;attach('pre', function($name) { return 'Hello, ' . $name; }, 2);
$manager-&gt;attach('pre', function($result) { echo $result . '&lt;br /&gt;' . PHP_EOL; }, 1);

$manager-&gt;trigger('pre', array('name' =&gt; 'World'));
</pre>

הנה דוגמה משתמשת במחלקה.

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
