Pop PHP Framework
=================

Documentation : Locale
----------------------

Die Locale-Komponente bietet Sprachunterstützung und Übersetzung Funktionalität für Ihre Anwendung. Sie können einfach erstellen und laden Sie Ihre eigenen XML-Dateien der gewünschten Sprache Übersetzungen in dem Format, das in eigenen XML-Pop der Sprachdateien skizziert hat.


Sie laden können Ihrer eigenen Sprache Übersetzung Dateien, solange die dem XML-Standard in der Pop / locale / Data-Ordner eingerichtet haften.


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
