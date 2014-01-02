Pop PHP Framework
=================

Documentation : Event
---------------------

Home

Eventコンポーネントは、アプリケーションのライフサイクル内のイベントをアタッチして、トリガする方法を提供します。主な利点は、クロージャとイベントとして添付されているクラスを介してそれに機能をフックすることによって、アプリケーションを拡張する機能です。

ここに添付してクロージャを使用してイベントをトリガの例です。するものであり、2つ目から結果を受け取る。

    use Pop\Event\Manager;

    $manager = new Manager();

    $manager->attach('pre', function($name) { return 'Hello, ' . $name; }, 2);
    $manager->attach('pre', function($result) { echo $result . '<br />' . PHP_EOL; }, 1);

    $manager->trigger('pre', array('name' => 'World'));

以下はこのクラスの使用例を示します。

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
