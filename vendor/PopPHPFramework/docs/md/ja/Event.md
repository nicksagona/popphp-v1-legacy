Pop PHP Framework
=================

Documentation : Event
---------------------

Eventコンポーネントは、アプリケーションのライフサイクル内のイベントをアタッチして、トリガする方法を提供します。主な利点は、クロージャとイベントとして添付されているクラスを介してそれに機能をフックすることによって、アプリケーションを拡張する機能です。

ここに添付してクロージャを使用してイベントをトリガの例です。するものであり、2つ目から結果を受け取る。

<pre>
use Pop\Event\Manager;

$manager = new Manager();

$manager-&gt;attach('pre', function($name) { return 'Hello, ' . $name; }, 2);
$manager-&gt;attach('pre', function($result) { echo $result . '&lt;br /&gt;' . PHP_EOL; }, 1);

$manager-&gt;trigger('pre', array('name' =&gt; 'World'));
</pre>

以下はこのクラスの使用例を示します。

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
