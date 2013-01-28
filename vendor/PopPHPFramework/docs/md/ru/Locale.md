Pop PHP Framework
=================

Documentation : Locale
----------------------

Home

Locale ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚ Ð¾Ð±ÐµÑ?Ð¿ÐµÑ‡Ð¸Ð²Ð°ÐµÑ‚ Ð¿Ð¾Ð´Ð´ÐµÑ€Ð¶ÐºÑƒ
Ñ?Ð·Ñ‹ÐºÐ° Ð¸ Ð¿ÐµÑ€ÐµÐ²Ð¾Ð´Ð° Ñ„ÑƒÐ½ÐºÑ†Ð¸Ð¾Ð½Ð°Ð»ÑŒÐ½Ð¾Ñ?Ñ‚ÑŒ Ð´Ð»Ñ?
Ð²Ð°ÑˆÐµÐ³Ð¾ Ð¿Ñ€Ð¸Ð»Ð¾Ð¶ÐµÐ½Ð¸Ñ?. Ð’Ñ‹ Ð¼Ð¾Ð¶ÐµÑ‚Ðµ Ð¿Ñ€Ð¾Ñ?Ñ‚Ð¾
Ñ?Ð¾Ð·Ð´Ð°Ð²Ð°Ñ‚ÑŒ Ð¸ Ð·Ð°Ð³Ñ€ÑƒÐ¶Ð°Ñ‚ÑŒ Ñ?Ð²Ð¾Ð¸ Ñ?Ð¾Ð±Ñ?Ñ‚Ð²ÐµÐ½Ð½Ñ‹Ðµ
XML-Ñ„Ð°Ð¹Ð»Ñ‹ Ð½ÐµÐ¾Ð±Ñ…Ð¾Ð´Ð¸Ð¼Ñ‹Ðµ Ñ?Ð·Ñ‹ÐºÐ¾Ð²Ñ‹Ðµ Ð¿ÐµÑ€ÐµÐ²Ð¾Ð´Ñ‹
Ð² Ñ„Ð¾Ñ€Ð¼Ð°Ñ‚Ðµ, ÐºÐ¾Ñ‚Ð¾Ñ€Ñ‹Ð¹ Ð¸Ð·Ð»Ð¾Ð¶Ð¸Ð» Ð²
Ñ?Ð¾Ð±Ñ?Ñ‚Ð²ÐµÐ½Ð½Ñ‹Ñ… XML ÐŸÐ¾Ð¿Ð° Ñ?Ð·Ñ‹ÐºÐ¾Ð²Ñ‹Ðµ Ñ„Ð°Ð¹Ð»Ñ‹.

Ð’Ñ‹ Ð¼Ð¾Ð¶ÐµÑ‚Ðµ Ð·Ð°Ð³Ñ€ÑƒÐ¶Ð°Ñ‚ÑŒ Ñ?Ð¾Ð±Ñ?Ñ‚Ð²ÐµÐ½Ð½Ñ‹Ðµ Ñ„Ð°Ð¹Ð»Ñ‹
Ñ?Ð·Ñ‹ÐºÐ° Ð¿ÐµÑ€ÐµÐ²Ð¾Ð´Ð°, ÐµÑ?Ð»Ð¸ Ð¿Ñ€Ð¸Ð´ÐµÑ€Ð¶Ð¸Ð²Ð°Ñ‚ÑŒÑ?Ñ?
Ñ?Ñ‚Ð°Ð½Ð´Ð°Ñ€Ñ‚Ð½Ñ‹Ñ… XML Ñ?Ð¾Ð·Ð´Ð°Ð½ Ð² Pop / Locale / Data
Ð¿Ð°Ð¿ÐºÑƒ.

    use Pop\Locale\Locale;

    // Create a Locale object to translate to French, using your own language file.
    $lang = Locale::factory('fr')->loadFile('folder/mylangfile.xml);

    // Will output 'Ce champ est obligatoire.'
    $lang->_e('This field is required.');

    // Will return and output 'Ce champ est obligatoire.'
    echo $lang->__('This field is required.');

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
