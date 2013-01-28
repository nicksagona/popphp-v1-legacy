Pop PHP Framework
=================

Documentation : Loader
----------------------

Home

Loaderç»„ä»¶å?¯èƒ½æ˜¯æœ€åŸºæœ¬çš„ï¼Œä¹Ÿæ˜¯æœ€é‡?è¦?çš„ç»„æˆ?éƒ¨åˆ†æµ?è¡Œçš„PHPæ¡†æž¶ã€‚å®ƒçš„ç»„ä»¶ï¼Œé©±åŠ¨æ¡†æž¶çš„è‡ªåŠ¨åŠ
è½½åŠŸèƒ½ï¼Œå¹¶å?¯ä»¥å¾ˆå®¹æ˜“åœ°æ³¨å†Œè‡ªå·±çš„åº”ç”¨ç¨‹åº?çš„è‡ªåŠ¨åŠ
è½½ä½ è‡ªå·±çš„ç±»åŠ
è½½ã€‚è¿™å?•æžªåŒ¹é©¬å?–ä»£æ‰€æœ‰é‚£äº›è€?includeè¯­å?¥ï¼Œä½
æœ‰æ‰€æœ‰çš„åœ°æ–¹ã€‚çŽ°åœ¨ï¼Œæ‰€æœ‰ä½
éœ€è¦?çš„æ˜¯ä¸€ä¸ªåœ¨é¡¶éƒ¨çš„â€œbootstrap.phpâ€?requireè¯­å?¥ï¼Œä½
æ˜¯å¥½åŽ»ã€‚é»˜è®¤æƒ…å†µä¸‹ï¼Œç¨‹åº?çš„å¼•å¯¼æ–‡ä»¶ä¸­åŒ…å?«æ‰€éœ€çš„å?‚è€ƒæ¡†æž¶çš„è‡ªåŠ¨åŠ
è½½ç£?å¸¦æœºç±»ï¼Œç„¶å?Žå°†å…¶åŠ
è½½äº†ã€‚åœ¨ç¨‹åº?çš„å¼•å¯¼æ–‡ä»¶ä¸­ï¼Œä½
å?¯ä»¥å¾ˆå®¹æ˜“åœ°æ‰§è¡Œå…¶ä»–åŠ
è½½åŠŸèƒ½ï¼Œå¦‚æ³¨å†Œæ‚¨çš„åº”ç”¨ç¨‹åº?çš„å‘½å??ç©ºé—´çš„è‡ªåŠ¨åŠ
è½½ç£?å¸¦æœºï¼Œæˆ–åŠ è½½ä¸€ä¸ªClassMapæ–‡ä»¶ï¼Œä»¥å‡?å°‘åŠ è½½æ—¶é—´ã€‚

    // Instantiate the autoloader object
    $autoloader = new Pop\Loader\Autoloader();
    $autoloader->splAutoloadRegister();

    $autoloader->register('YourLib', '../vendor/YourLib/src');
    $autoloader->loadClassMap('../vendor/YourLib/classmap.php');

å¦‚æžœä½
éœ€è¦?ä¸€ä¸ªClassMapç”Ÿæˆ?çš„æ–‡ä»¶ï¼ŒLoaderç»„ä»¶çš„åŠŸèƒ½ï¼Œå?¯ä»¥è½»æ?¾åœ°ç”Ÿæˆ?ä¸€ä¸ªClassMapæ–‡ä»¶ä»¥å?Šã€‚

    // Generate a classmap file
    Pop\Loader\Classmap::generate('your/src/folder', 'your/src/folder/classmap.php');

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
