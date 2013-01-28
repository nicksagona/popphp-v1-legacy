Pop PHP Framework
=================

Documentation : Locale
----------------------

Home

ãƒ­ã‚±ãƒ¼ãƒ«ã?®ã‚³ãƒ³ãƒ?ãƒ¼ãƒ?ãƒ³ãƒˆã?¯ã€?ã‚¢ãƒ—ãƒªã‚±ãƒ¼ã‚·ãƒ§ãƒ³ã?®è¨€èªžã‚µãƒ?ãƒ¼ãƒˆã?¨ç¿»è¨³æ©Ÿèƒ½ã‚’æ??ä¾›ã?—ã?¾ã?™ã€‚ã?‚ã?ªã?Ÿã?¯ã€?å?˜ã?«ãƒ?ãƒƒãƒ—ã?®ç‹¬è‡ªã?®XMLè¨€èªžãƒ•ã‚¡ã‚¤ãƒ«ã?§èª¬æ˜Žã?•ã‚Œã?¦ã?„ã‚‹å½¢å¼?ã?§å¿…è¦?ã?ªè¨€èªžã?®ç¿»è¨³ã?®ç‹¬è‡ªã?®XMLãƒ•ã‚¡ã‚¤ãƒ«ã‚’ä½œæˆ?ã?—ã€?ãƒ­ãƒ¼ãƒ‰ã?™ã‚‹ã?“ã?¨ã?Œã?§ã??ã?¾ã?™ã€‚

ã?‚ã?ªã?Ÿã?Œã?„ã‚‹é™?ã‚Šãƒ?ãƒƒãƒ—/ãƒ­ã‚±ãƒ¼ãƒ«/ãƒ‡ãƒ¼ã‚¿ãƒ•ã‚©ãƒ«ãƒ€ãƒ¼ã?«è¨­ç«‹ã?•ã‚Œã?ŸXMLæ¨™æº–ã?«æº–æ‹
ã?—ã?Ÿã‚‚ã?®ã?§ã€?è‡ªåˆ†è‡ªèº«ã?®è¨€èªžã?®ç¿»è¨³ãƒ•ã‚¡ã‚¤ãƒ«ã‚’èª­ã?¿è¾¼ã‚€ã?“ã?¨ã?Œã?§ã??ã?¾ã?™ã€‚

    use Pop\Locale\Locale;

    // Create a Locale object to translate to French, using your own language file.
    $lang = Locale::factory('fr')->loadFile('folder/mylangfile.xml);

    // Will output 'Ce champ est obligatoire.'
    $lang->_e('This field is required.');

    // Will return and output 'Ce champ est obligatoire.'
    echo $lang->__('This field is required.');

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
