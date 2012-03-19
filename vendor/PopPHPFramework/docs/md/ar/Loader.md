Pop PHP Framework
=================

Documentation : Loader
----------------------

المكون محمل ربما كان العنصر الأكثر أساسية، ولكن الأهم من إطار PHP البوب. انها العنصر الذي يدفع قدرات إطار لautoloading، ويمكن بسهولة التطبيق الخاص تكون مسجلة في الملقم الآلي لتحميل الطبقات الخاصة بك. هذا يحل محل كل بمفردها من تلك التصريحات وتشمل القديمة التي كانت لدينا في كل مكان. الآن، كل ما عليك هو واحد تتطلب بيان "bootstrap.php" في أعلى، وكنت على ما يرام. افتراضيا، ملف التمهيد يحتوي على المرجعية المطلوبة لفئة الملقم الآلي في إطار وبعد ذلك يقوم بتحميل عنه. في ملف التمهيد، يمكنك تنفيذ المهام بسهولة التحميل الأخرى، مثل تسجيل مساحة التطبيق الخاص بك مع الملقم الآلي، أو تحميل ملف classmap لتقليل وقت التحميل.

<pre>
// Instantiate the autoloader object
$autoloader = new Pop\Loader\Autoloader();
$autoloader->splAutoloadRegister();

$autoloader->register('YourLib', '../vendor/YourLib/src');
$autoloader->loadClassMap('../vendor/YourLib/classmap.php');
</pre>

وإذا كنت في حاجة الى ملف classmap ولدت، المكون محمل لديه وظيفة بسهولة لتوليد ملف classmap لكنت كذلك.

<pre>
// Generate a classmap file
Pop\Loader\Classmap::generate('your/src/folder', 'your/src/folder/classmap.php');
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
