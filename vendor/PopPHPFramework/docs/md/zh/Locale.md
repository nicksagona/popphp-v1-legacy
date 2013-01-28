Pop PHP Framework
=================

Documentation : Locale
----------------------

Home

åŒºåŸŸè®¾ç½®ç»„ä»¶æ??ä¾›è¯­è¨€æ”¯æŒ?å’Œç¿»è¯‘åŠŸèƒ½ï¼Œä¸ºæ‚¨çš„åº”ç”¨ç¨‹åº?ã€‚ä½
å?¯ä»¥ç®€å?•åœ°åˆ›å»ºå’ŒåŠ è½½è‡ªå·±çš„XMLæ–‡ä»¶çš„æ
¼å¼?ï¼Œæµ?è¡Œçš„XMLè¯­è¨€æ–‡ä»¶ä¸­åˆ—å‡ºæ‰€éœ€çš„è¯­è¨€ç¿»è¯‘ã€‚

æ‚¨å?¯ä»¥åŠ
è½½æ‚¨è‡ªå·±çš„è¯­è¨€ç¿»è¯‘æ–‡ä»¶ï¼Œå?ªè¦?å?šæŒ?æµ?è¡Œ/çŽ°åœº/
Dataæ–‡ä»¶å¤¹ä¸­å»ºç«‹çš„XMLæ ‡å‡†ã€‚

    use Pop\Locale\Locale;

    // Create a Locale object to translate to French, using your own language file.
    $lang = Locale::factory('fr')->loadFile('folder/mylangfile.xml);

    // Will output 'Ce champ est obligatoire.'
    $lang->_e('This field is required.');

    // Will return and output 'Ce champ est obligatoire.'
    echo $lang->__('This field is required.');

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
