Pop PHP Framework
=================

Documentation : Locale
----------------------

区域设置组件提供语言支持，为您的应用和翻译功能。你可以简单地创建和加载自己的XML文件格式所需的语言，这是在流行的XML语言文件概述翻译。

你可以加载自己的语言翻译文件，只要坚持以流行/现场/ Data文件夹中建立的XML标准。

<pre>
use Pop\Locale\Locale;

// Create a Locale object to translate to French, using your own language file.
$lang = Locale::factory('fr')->loadFile('folder/mylangfile.xml);

// Will output 'Ce champ est obligatoire.'
$lang->_e('This field is required.');

// Will return and output 'Ce champ est obligatoire.'
echo $lang->__('This field is required.');
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
