Pop PHP Framework
=================

Documentation : Locale
----------------------

The Locale component provides language support and translation functionality for your application. You can simply create and load your own XML files of the required language translations in the format that's outlined in Pop's own XML language files.

You can load your own language translation files, as long as the adhere to the XML standard established in the Pop/Locale/Data folder.

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
