Pop PHP Framework
=================

Documentation : Event
---------------------

Home

Eventã‚³ãƒ³ãƒ?ãƒ¼ãƒ?ãƒ³ãƒˆã?¯ã€?ã‚¢ãƒ—ãƒªã‚±ãƒ¼ã‚·ãƒ§ãƒ³ã?®ãƒ©ã‚¤ãƒ•ã‚µã‚¤ã‚¯ãƒ«å†…ã?®ã‚¤ãƒ™ãƒ³ãƒˆã‚’ã‚¢ã‚¿ãƒƒãƒ?ã?—ã?¦ã€?ãƒˆãƒªã‚¬ã?™ã‚‹æ–¹æ³•ã‚’æ??ä¾›ã?—ã?¾ã?™ã€‚ä¸»ã?ªåˆ©ç‚¹ã?¯ã€?ã‚¯ãƒ­ãƒ¼ã‚¸ãƒ£ã?¨ã‚¤ãƒ™ãƒ³ãƒˆã?¨ã?—ã?¦æ·»ä»˜ã?•ã‚Œã?¦ã?„ã‚‹ã‚¯ãƒ©ã‚¹ã‚’ä»‹ã?—ã?¦ã??ã‚Œã?«æ©Ÿèƒ½ã‚’ãƒ•ãƒƒã‚¯ã?™ã‚‹ã?“ã?¨ã?«ã‚ˆã?£ã?¦ã€?ã‚¢ãƒ—ãƒªã‚±ãƒ¼ã‚·ãƒ§ãƒ³ã‚’æ‹¡å¼µã?™ã‚‹æ©Ÿèƒ½ã?§ã?™ã€‚

ã?“ã?“ã?«æ·»ä»˜ã?—ã?¦ã‚¯ãƒ­ãƒ¼ã‚¸ãƒ£ã‚’ä½¿ç”¨ã?—ã?¦ã‚¤ãƒ™ãƒ³ãƒˆã‚’ãƒˆãƒªã‚¬ã?®ä¾‹ã?§ã?™ã€‚ã?™ã‚‹ã‚‚ã?®ã?§ã?‚ã‚Šã€?2ã?¤ç›®ã?‹ã‚‰çµ?æžœã‚’å?—ã?‘å?–ã‚‹ã€‚

    use Pop\Event\Manager;

    $manager = new Manager();

    $manager->attach('pre', function($name) { return 'Hello, ' . $name; }, 2);
    $manager->attach('pre', function($result) { echo $result . '<br />' . PHP_EOL; }, 1);

    $manager->trigger('pre', array('name' => 'World'));

ä»¥ä¸‹ã?¯ã?“ã?®ã‚¯ãƒ©ã‚¹ã?®ä½¿ç”¨ä¾‹ã‚’ç¤ºã?—ã?¾ã?™ã€‚

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
