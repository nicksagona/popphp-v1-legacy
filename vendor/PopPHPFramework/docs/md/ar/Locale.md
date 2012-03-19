Pop PHP Framework
=================

Documentation : Locale
----------------------

عنصر اللغة يقدم الدعم لغة وظائف ترجمة للتطبيق الخاص بك. يمكنك إنشاء ببساطة وتحميل ملفات XML الخاصة من الترجمة المطلوبة في شكل هذا ما ورد في البوب ​​الخاصة ملفات لغة XML.

يمكنك تحميل الترجمة غته الملفات، ما دام الالتزام معيار XML التي أنشئت في المجلد البوب ​​/ لغة / بيانات.

<pre>
use Pop\Locale\Locale;

// Create a Locale object to translate to French, using your own language file.
$lang = Locale::factory('fr')->loadFile('folder/mylangfile.xml);

// Will output 'Ce champ est obligatoire.'
$lang->_e('This field is required.');

// Will return and output 'Ce champ est obligatoire.'
echo $lang->__('This field is required.');
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
