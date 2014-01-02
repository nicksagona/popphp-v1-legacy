Pop PHP Framework
=================

Documentation : Event
---------------------

Home

المكون الحدث يوفر وسيلة لتحريك الأحداث ونعلق في إطار دورة حياة التطبيق.
والفائدة الرئيسية هي القدرة على توجيه الطلب من قبل تركيب وظيفة في ذلك عن
طريق الإغلاق والفئات التي ترد عن الأحداث.

وهنا مثال على ربط واثار الحدث باستخدام الإغلاق. ثانية واحدة يتلقى
النتيجة من أول واحد.

    use Pop\Event\Manager;

    $manager = new Manager();

    $manager->attach('pre', function($name) { return 'Hello, ' . $name; }, 2);
    $manager->attach('pre', function($result) { echo $result . '<br />' . PHP_EOL; }, 1);

    $manager->trigger('pre', array('name' => 'World'));

وهنا مثال باستخدام فئة.

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
