Pop PHP Framework
=================

Documentation : Locale
----------------------

Home

Locale компонент обеспечивает поддержку языка и перевода
функциональность для вашего приложения. Вы можете просто создавать и
загружать свои собственные XML-файлы необходимые языковые переводы в
формате, который изложил в собственных XML Попа языковые файлы.

Вы можете загружать собственные файлы языка перевода, если
придерживаться стандартных XML создан в Pop / Locale / Data папку.

    use Pop\Locale\Locale;

    // Create a Locale object to translate to French, using your own language file.
    $lang = Locale::factory('fr')->loadFile('folder/mylangfile.xml);

    // Will output 'Ce champ est obligatoire.'
    $lang->_e('This field is required.');

    // Will return and output 'Ce champ est obligatoire.'
    echo $lang->__('This field is required.');

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
