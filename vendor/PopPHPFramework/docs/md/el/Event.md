Pop PHP Framework
=================

Documentation : Event
---------------------

Home

Î¤Î¿ ÏƒÏ„Î¿Î¹Ï‡ÎµÎ¯Î¿ Event Ï€Î±Ï?Î­Ï‡ÎµÎ¹ Î­Î½Î±Î½ Ï„Ï?ÏŒÏ€Î¿ Î³Î¹Î±
Î½Î± ÏƒÏ…Î½Î´Î­ÏƒÎµÏ„Îµ ÎºÎ±Î¹ Î½Î± Ï€Ï?Î¿ÎºÎ±Î»Î­ÏƒÎµÎ¹ Ï„Î±
Î³ÎµÎ³Î¿Î½ÏŒÏ„Î± ÏƒÏ„Î¿ Ï€Î»Î±Î¯ÏƒÎ¹Î¿ Ï„Î¿Ï… ÎºÏ?ÎºÎ»Î¿Ï… Î¶Ï‰Î®Ï‚
Ï„Î·Ï‚ Î±Î¯Ï„Î·ÏƒÎ·Ï‚. Î¤Î¿ ÎºÏ?Ï?Î¹Î¿ Ï€Î»ÎµÎ¿Î½Î­ÎºÏ„Î·Î¼Î± ÎµÎ¯Î½Î±Î¹
Î· Î´Ï…Î½Î±Ï„ÏŒÏ„Î·Ï„Î± Î½Î± ÎµÏ€ÎµÎºÏ„ÎµÎ¯Î½Î¿Ï…Î½ Ï„Î·Î½
ÎµÏ†Î±Ï?Î¼Î¿Î³Î®, ÏƒÏ…Î½Î´Î­Î¿Î½Ï„Î±Ï‚ Ï„Î·
Î»ÎµÎ¹Ï„Î¿Ï…Ï?Î³Î¹ÎºÏŒÏ„Î·Ï„Î± ÏƒÎµ Î±Ï…Ï„ÏŒ Î¼Î­ÏƒÏ‰ Ï„Î¿Ï…
ÎºÎ»ÎµÎ¹ÏƒÎ¯Î¼Î±Ï„Î¿Ï‚ ÎºÎ±Î¹ Ï„Î¬Î¾ÎµÎ¹Ï‚ Ï€Î¿Ï…
ÎµÏ€Î¹ÏƒÏ…Î½Î¬Ï€Ï„Î¿Î½Ï„Î±Î¹ Ï‰Ï‚ Î³ÎµÎ³Î¿Î½ÏŒÏ„Î±.

Î•Î´ÏŽ ÎµÎ¯Î½Î±Î¹ Î­Î½Î± Ï€Î±Ï?Î¬Î´ÎµÎ¹Î³Î¼Î± Î±Ï€ÏŒ Ï„Î· ÏƒÏ?Î½Î´ÎµÏƒÎ·
ÎºÎ±Î¹ Ï„Î·Î½ ÎµÎ½ÎµÏ?Î³Î¿Ï€Î¿Î¯Î·ÏƒÎ· ÎµÎ½ÏŒÏ‚ Î³ÎµÎ³Î¿Î½ÏŒÏ„Î¿Ï‚ Î¼Îµ
Ï„Î¿ ÎºÎ»ÎµÎ¯ÏƒÎ¹Î¼Î¿. Î¤Î¿ Î´ÎµÏ?Ï„ÎµÏ?Î¿ Î»Î±Î¼Î²Î¬Î½ÎµÎ¹ Ï„Î¿
Î±Ï€Î¿Ï„Î­Î»ÎµÏƒÎ¼Î± Î±Ï€ÏŒ Ï„Î¿ Ï€Ï?ÏŽÏ„Î¿.

    use Pop\Event\Manager;

    $manager = new Manager();

    $manager->attach('pre', function($name) { return 'Hello, ' . $name; }, 2);
    $manager->attach('pre', function($result) { echo $result . '<br />' . PHP_EOL; }, 1);

    $manager->trigger('pre', array('name' => 'World'));

Î•Î´ÏŽ ÎµÎ¯Î½Î±Î¹ Î­Î½Î± Ï€Î±Ï?Î¬Î´ÎµÎ¹Î³Î¼Î±
Ï‡Ï?Î·ÏƒÎ¹Î¼Î¿Ï€Î¿Î¹ÏŽÎ½Ï„Î±Ï‚ Î¼Î¹Î± Ï„Î¬Î¾Î·.

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

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
