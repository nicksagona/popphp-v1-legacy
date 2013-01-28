Pop PHP Framework
=================

Documentation : Locale
----------------------

Home

×•×?×? ×?×ª×” ×¦×¨×™×š ×§×•×‘×¥ classmap × ×•×¦×¨, ×¨×›×™×‘ Loader ×™×©
×”×¤×•× ×§×¦×™×•× ×œ×™ ×§×œ ×›×“×™ ×œ×™×¦×•×¨ ×§×•×‘×¥ classmap ×’×?
×œ×š.

×?×ª×” ×™×›×•×œ ×œ×˜×¢×•×Ÿ ×§×‘×¦×™ ×ª×¨×’×•×? ×”×©×¤×” ×©×œ×š, ×›×œ
×¢×•×“ ×œ×“×‘×•×§ ×‘×ª×§×Ÿ XML ×”×•×§×? ×‘×ª×™×§×™×™×ª ×¤×•×¤ /
×”×?×–×•×¨ / × ×ª×•× ×™×?.

    use Pop\Locale\Locale;

    // Create a Locale object to translate to French, using your own language file.
    $lang = Locale::factory('fr')->loadFile('folder/mylangfile.xml);

    // Will output 'Ce champ est obligatoire.'
    $lang->_e('This field is required.');

    // Will return and output 'Ce champ est obligatoire.'
    echo $lang->__('This field is required.');

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
