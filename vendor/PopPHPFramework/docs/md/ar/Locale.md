Pop PHP Framework
=================

Documentation : Locale
----------------------

Home

ÙŠÙˆÙ?Ø± Ø¹Ù†ØµØ± Ø§Ù„Ù„ØºØ© Ø¯Ø¹Ù… Ø§Ù„Ù„ØºØ§Øª ÙˆØ¸Ø§Ø¦Ù? ØªØ±Ø¬Ù…Ø©
Ù„Ù„ØªØ·Ø¨ÙŠÙ‚ Ø§Ù„Ø®Ø§Øµ Ø¨Ùƒ. ÙŠÙ…ÙƒÙ†Ùƒ Ø¨Ø¨Ø³Ø§Ø·Ø© Ø¥Ù†Ø´Ø§Ø¡
ÙˆØªØ­Ù…ÙŠÙ„ Ø§Ù„Ù…Ù„Ù?Ø§Øª XML Ø§Ù„Ø®Ø§ØµØ© Ù…Ù† Ø§Ù„ØªØ±Ø¬Ù…Ø§Øª
Ø§Ù„Ù„ØºÙˆÙŠØ© Ø§Ù„Ù…Ø·Ù„ÙˆØ¨Ø© Ù?ÙŠ ØªÙ†Ø³ÙŠÙ‚ Ù‡Ø°Ø§ Ù…Ø§ ÙˆØ±Ø¯ Ù?ÙŠ
Ø§Ù„ØºÙ†Ø§Ø¡ Ø§Ù„Ø´Ø¹Ø¨ÙŠØŒ Ù…Ù„Ù?Ø§Øª Ø§Ù„Ù„ØºØ© Ø§Ù„Ø®Ø§ØµØ© XML.

ÙŠÙ…ÙƒÙ†Ùƒ ØªØ­Ù…ÙŠÙ„ Ø§Ù„ØªØ±Ø¬Ù…Ø© Ø¨Ø§Ù„Ù„ØºØ© Ø§Ù„Ø®Ø§ØµØ©
Ø§Ù„Ù…Ù„Ù?Ø§ØªØŒ Ù…Ø§ Ø¯Ø§Ù…Øª ØªÙ„ØªØ²Ù… Ù…Ø¹ÙŠØ§Ø± XML Ø£Ù†Ø´Ø¦Øª Ù?ÙŠ
Ø§Ù„Ù…Ø¬Ù„Ø¯ Ø§Ù„Ø¨ÙˆØ¨ â€‹â€‹/ Ø§Ù„Ù„ØºØ© / Ø§Ù„Ø¨ÙŠØ§Ù†Ø§Øª.

    use Pop\Locale\Locale;

    // Create a Locale object to translate to French, using your own language file.
    $lang = Locale::factory('fr')->loadFile('folder/mylangfile.xml);

    // Will output 'Ce champ est obligatoire.'
    $lang->_e('This field is required.');

    // Will return and output 'Ce champ est obligatoire.'
    echo $lang->__('This field is required.');

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
