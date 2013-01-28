Pop PHP Framework
=================

Documentation : Event
---------------------

Home

Ð¡Ð¾Ð±Ñ‹Ñ‚Ð¸Ñ? ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚Ð° Ð¿Ñ€ÐµÐ´Ð¾Ñ?Ñ‚Ð°Ð²Ð»Ñ?ÐµÑ‚
Ð²Ð¾Ð·Ð¼Ð¾Ð¶Ð½Ð¾Ñ?Ñ‚ÑŒ Ð¿Ð¾Ð´ÐºÐ»ÑŽÑ‡ÐµÐ½Ð¸Ñ? Ð¸ Ð·Ð°Ð¿ÑƒÑ?ÐºÐ°
Ñ?Ð¾Ð±Ñ‹Ñ‚Ð¸Ð¹ Ð² Ð¶Ð¸Ð·Ð½ÐµÐ½Ð½Ð¾Ð¼ Ñ†Ð¸ÐºÐ»Ðµ Ð¿Ñ€Ð¸Ð»Ð¾Ð¶ÐµÐ½Ð¸Ñ?.
ÐžÑ?Ð½Ð¾Ð²Ð½Ñ‹Ð¼ Ð¿Ñ€ÐµÐ¸Ð¼ÑƒÑ‰ÐµÑ?Ñ‚Ð²Ð¾Ð¼ Ñ?Ð²Ð»Ñ?ÐµÑ‚Ñ?Ñ?
Ð²Ð¾Ð·Ð¼Ð¾Ð¶Ð½Ð¾Ñ?Ñ‚ÑŒ Ñ€Ð°Ñ?ÑˆÐ¸Ñ€Ð¸Ñ‚ÑŒ Ð¿Ñ€Ð¸Ð¼ÐµÐ½ÐµÐ½Ð¸Ðµ
Ð¿Ð¾Ð´ÐºÐ»ÑŽÑ‡ÐµÐ½Ð¸Ðµ Ñ„ÑƒÐ½ÐºÑ†Ð¸Ð¾Ð½Ð°Ð»ÑŒÐ½Ð¾Ñ?Ñ‚ÑŒ Ð² Ð½ÐµÐ³Ð¾
Ñ‡ÐµÑ€ÐµÐ· Ð·Ð°Ð¼Ñ‹ÐºÐ°Ð½Ð¸Ñ? Ð¸ ÐºÐ»Ð°Ñ?Ñ?Ñ‹, ÐºÐ¾Ñ‚Ð¾Ñ€Ñ‹Ðµ
Ð¿Ñ€Ð¸Ð»Ð°Ð³Ð°ÑŽÑ‚Ñ?Ñ? Ð² ÐºÐ°Ñ‡ÐµÑ?Ñ‚Ð²Ðµ Ñ?Ð¾Ð±Ñ‹Ñ‚Ð¸Ñ?.

Ð’Ð¾Ñ‚ Ð¿Ñ€Ð¸Ð¼ÐµÑ€ Ð¿Ð¾Ð´ÐºÐ»ÑŽÑ‡ÐµÐ½Ð¸Ñ? Ð¸ Ð·Ð°Ð¿ÑƒÑ?ÐºÐ°
Ñ?Ð¾Ð±Ñ‹Ñ‚Ð¸Ð¹ Ñ? Ð¿Ð¾Ð¼Ð¾Ñ‰ÑŒÑŽ Ð·Ð°Ð¼Ñ‹ÐºÐ°Ð½Ð¸Ñ?. Ð’Ñ‚Ð¾Ñ€Ð¾Ð¹
Ð¿Ð¾Ð»ÑƒÑ‡Ð°ÐµÑ‚ Ñ€ÐµÐ·ÑƒÐ»ÑŒÑ‚Ð°Ñ‚ Ð¾Ñ‚ Ð¿ÐµÑ€Ð²Ð¾Ð¹.

    use Pop\Event\Manager;

    $manager = new Manager();

    $manager->attach('pre', function($name) { return 'Hello, ' . $name; }, 2);
    $manager->attach('pre', function($result) { echo $result . '<br />' . PHP_EOL; }, 1);

    $manager->trigger('pre', array('name' => 'World'));

Ð’Ð¾Ñ‚ Ð¿Ñ€Ð¸Ð¼ÐµÑ€ Ð¸Ñ?Ð¿Ð¾Ð»ÑŒÐ·Ð¾Ð²Ð°Ð½Ð¸Ñ? ÐºÐ»Ð°Ñ?Ñ?Ð°.

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
