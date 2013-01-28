Pop PHP Framework
=================

Documentation : Event
---------------------

Home

Ø§Ù„Ù…ÙƒÙˆÙ† Ø§Ù„Ø­Ø¯Ø« ÙŠÙˆÙ?Ø± ÙˆØ³ÙŠÙ„Ø© Ù„ØªØ­Ø±ÙŠÙƒ Ø§Ù„Ø£Ø­Ø¯Ø§Ø«
ÙˆÙ†Ø¹Ù„Ù‚ Ù?ÙŠ Ø¥Ø·Ø§Ø± Ø¯ÙˆØ±Ø© Ø­ÙŠØ§Ø© Ø§Ù„ØªØ·Ø¨ÙŠÙ‚.
ÙˆØ§Ù„Ù?Ø§Ø¦Ø¯Ø© Ø§Ù„Ø±Ø¦ÙŠØ³ÙŠØ© Ù‡ÙŠ Ø§Ù„Ù‚Ø¯Ø±Ø© Ø¹Ù„Ù‰ ØªÙˆØ¬ÙŠÙ‡
Ø§Ù„Ø·Ù„Ø¨ Ù…Ù† Ù‚Ø¨Ù„ ØªØ±ÙƒÙŠØ¨ ÙˆØ¸ÙŠÙ?Ø© Ù?ÙŠ Ø°Ù„Ùƒ Ø¹Ù† Ø·Ø±ÙŠÙ‚
Ø§Ù„Ø¥ØºÙ„Ø§Ù‚ ÙˆØ§Ù„Ù?Ø¦Ø§Øª Ø§Ù„ØªÙŠ ØªØ±Ø¯ Ø¹Ù† Ø§Ù„Ø£Ø­Ø¯Ø§Ø«.

ÙˆÙ‡Ù†Ø§ Ù…Ø«Ø§Ù„ Ø¹Ù„Ù‰ Ø±Ø¨Ø· ÙˆØ§Ø«Ø§Ø± Ø§Ù„Ø­Ø¯Ø« Ø¨Ø§Ø³ØªØ®Ø¯Ø§Ù…
Ø§Ù„Ø¥ØºÙ„Ø§Ù‚. Ø«Ø§Ù†ÙŠØ© ÙˆØ§Ø­Ø¯Ø© ÙŠØªÙ„Ù‚Ù‰ Ø§Ù„Ù†ØªÙŠØ¬Ø© Ù…Ù†
Ø£ÙˆÙ„ ÙˆØ§Ø­Ø¯.

    use Pop\Event\Manager;

    $manager = new Manager();

    $manager->attach('pre', function($name) { return 'Hello, ' . $name; }, 2);
    $manager->attach('pre', function($result) { echo $result . '<br />' . PHP_EOL; }, 1);

    $manager->trigger('pre', array('name' => 'World'));

ÙˆÙ‡Ù†Ø§ Ù…Ø«Ø§Ù„ Ø¨Ø§Ø³ØªØ®Ø¯Ø§Ù… Ù?Ø¦Ø©.

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
