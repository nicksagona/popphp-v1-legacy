Pop PHP Framework
=================

Documentation : Locale
----------------------

Home

Die Locale-Komponente bietet SprachunterstÃ¼tzung und Ãœbersetzung
FunktionalitÃ¤t fÃ¼r Ihre Anwendung. Sie kÃ¶nnen einfach erstellen und
laden Sie Ihre eigenen XML-Dateien der gewÃ¼nschten Sprache
Ãœbersetzungen in dem Format, das in den eigenen XML Pop die
Sprachdateien umrissen ist.

Sie kÃ¶nnen laden Sie Ihre eigenen Ãœbersetzungs-Dateien, solange die
dem XML-Standard in der Pop / Locale / Data-Ordner eingerichtet haften.

    use Pop\Locale\Locale;

    // Create a Locale object to translate to French, using your own language file.
    $lang = Locale::factory('fr')->loadFile('folder/mylangfile.xml);

    // Will output 'Ce champ est obligatoire.'
    $lang->_e('This field is required.');

    // Will return and output 'Ce champ est obligatoire.'
    echo $lang->__('This field is required.');

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
