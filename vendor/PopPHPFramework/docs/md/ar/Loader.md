Pop PHP Framework
=================

Documentation : Loader
----------------------

Home

المكون محمل وربما كان العنصر الأكثر أساسية، لكن أهم من الإطار PHP البوب.
انها المكون الذي يحرك القدرات في إطار autoloading، ويمكن بسهولة التطبيق
الخاص تكون مسجلة في الملقم الآلي لتحميل الطبقات الخاصة بك. يستبدل هذا
بمفردها كل هذه البيانات تشمل عمرك كانت لدينا في كل مكان. الآن، كل ما
عليك هو واحد تتطلب بيان "bootstrap.php 'في أعلى وكنت جيدة للذهاب. بشكل
افتراضي، ملف التمهيد يحتوي على المرجع المطلوب لفئة الملقم الآلي إطار وثم
يقوم بتحميل عنه. ضمن ملف التمهيد، يمكنك بسهولة تنفيذ مهام التحميل
الأخرى، مثل تسجيل مساحة التطبيق الخاص بك مع الملقم الآلي، أو تحميل ملف
classmap لتقليل وقت التحميل.

    // Instantiate the autoloader object
    $autoloader = new Pop\Loader\Autoloader();
    $autoloader->splAutoloadRegister();

    $autoloader->register('YourLib', '../vendor/YourLib/src');
    $autoloader->loadClassMap('../vendor/YourLib/classmap.php');

وإذا كنت في حاجة الى ملف classmap ولدت، المكون محمل ديه وظيفة لتوليد
بسهولة ملف classmap لكنت كذلك.

    // Generate a classmap file
    Pop\Loader\Classmap::generate('your/src/folder', 'your/src/folder/classmap.php');

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
