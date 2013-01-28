Pop PHP Framework
=================

Documentation : Event
---------------------

Home

äº‹ä»¶ç»„ä»¶æ??ä¾›é™„åŠ
å’Œè§¦å?‘äº‹ä»¶çš„ç”Ÿå‘½å‘¨æœŸå†…çš„ä¸€ä¸ªåº”ç”¨ç¨‹åº?çš„ä¸€ç§?æ–¹æ³•ã€‚å…¶ä¸»è¦?ä¼˜ç‚¹æ˜¯é€šè¿‡æŒ‚é’©åˆ°å®ƒé€šè¿‡è¿žæŽ¥äº‹ä»¶çš„é—­åŒ…å’Œç±»çš„åŠŸèƒ½æ‰©å±•åº”ç”¨ç¨‹åº?çš„èƒ½åŠ›ã€‚

ä¸‹é?¢æ˜¯ä¸€ä¸ªä¾‹å­?ä½¿ç”¨é—­åŒ…çš„å®‰è£…å’Œè§¦å?‘äº‹ä»¶ã€‚ç¬¬äºŒä¸ªä»Žç¬¬ä¸€ä¸ªæŽ¥æ”¶çš„ç»“â€‹â€‹æžœã€‚

    use Pop\Event\Manager;

    $manager = new Manager();

    $manager->attach('pre', function($name) { return 'Hello, ' . $name; }, 2);
    $manager->attach('pre', function($result) { echo $result . '<br />' . PHP_EOL; }, 1);

    $manager->trigger('pre', array('name' => 'World'));

ä¸‹é?¢æ˜¯ä¸€ä¸ªä¾‹å­?ï¼Œä½¿ç”¨ä¸€ä¸ªç±»ã€‚

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
