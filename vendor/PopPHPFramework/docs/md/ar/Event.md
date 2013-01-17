Pop PHP Framework
=================

Documentation : Event
---------------------

المكون الحدث يوفر وسيلة لتحريك الأحداث ونعلق في إطار دورة حياة التطبيق. والفائدة الرئيسية هي القدرة على توجيه الطلب من قبل تركيب وظيفة في ذلك عن طريق الإغلاق والفئات التي ترد عن الأحداث.

وهنا مثال على ربط واثار الحدث باستخدام الإغلاق. ثانية واحدة يتلقى النتيجة من أول واحد.

<pre>
use Pop\Event\Manager;

$manager = new Manager();

$manager-&gt;attach('pre', function($name) { return 'Hello, ' . $name; }, 2);
$manager-&gt;attach('pre', function($result) { echo $result . '&lt;br /&gt;' . PHP_EOL; }, 1);

$manager-&gt;trigger('pre', array('name' =&gt; 'World'));
</pre>

وهنا مثال باستخدام فئة.

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

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
