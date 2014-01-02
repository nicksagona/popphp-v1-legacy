Pop PHP Framework
=================

Documentation : Event
---------------------

Home

מרכיב האירוע מספק דרך לצרף ולהפעיל אירועים במחזור החיים של יישום. היתרון
העיקרי הוא היכולת להרחיב יישום על ידי משדלים פונקציונלי לתוכו באמצעות
סגרים וכיתות המחוברים כאירועים.

הנה דוגמה של הצמדה ומפעיל אירוע באמצעות סגרים. השני מקבל תוצאה מהראשונה.

    use Pop\Event\Manager;

    $manager = new Manager();

    $manager->attach('pre', function($name) { return 'Hello, ' . $name; }, 2);
    $manager->attach('pre', function($result) { echo $result . '<br />' . PHP_EOL; }, 1);

    $manager->trigger('pre', array('name' => 'World'));

הנה דוגמה משתמשת במחלקה.

    use Pop\Event\Manager;

    class Foo
    {
        public $value;

        public function __construct($arg = null)
        {
            $this->value = $arg;
        }

        public static function factory($arg)
        {
            return new self($arg);
        }

        public function bar($arg)
        {
            $this->value = $arg;
            return $this;
        }
    }

    $manager = new Manager();

    $manager->attach('pre', 'Foo::factory', 2);

    // OR
    //$manager->attach('pre', 'Foo->bar', 2);

    $manager->attach('pre', function($result) { echo 'Hello, ' . $result->value . '<br />' . PHP_EOL; }, 1);
    $manager->trigger('pre', array('arg' => 'World'));

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
