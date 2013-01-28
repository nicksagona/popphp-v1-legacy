Pop PHP Framework
=================

Documentation : Validator
-------------------------

Home

ç®€å?•çš„éªŒè¯?ç»„ä»¶æ??ä¾›éªŒè¯?åŠŸèƒ½ï¼Œä¸ºè®¸å¤šä¸?å?Œçš„ä½¿ç”¨æƒ…å†µï¼Œå¦‚éªŒè¯?æ˜¯å?¦æˆ–ä¸?æ˜¯ä¸€ä¸ªæ•°å­—æ˜¯æœ‰ä¸€å®šçš„ä»·å€¼ï¼Œæˆ–è€…æ˜¯å­—æ¯?æ•°å­—å­—ç¬¦ä¸²ã€‚æ›´å…ˆè¿›çš„éªŒè¯?ç¨‹åº?å?¯ä¸ºå¥½ï¼Œå¦‚éªŒè¯?ç”µå­?é‚®ä»¶åœ°å?€ï¼ŒIPåœ°å?€æˆ–ä¿¡ç”¨å?¡å?·ç
?ã€‚è€Œä¸”ï¼Œå¦‚æžœä½
éœ€è¦?çš„æ˜¯ä¸?å?¯ç”¨çš„ç»„ä»¶ï¼Œå?¯ä»¥å¾ˆå®¹æ˜“åœ°æ‰©å±•ã€‚

    use Pop\Validator\AlphaNumeric;

    // Create an alphanumeric validator
    $val = new AlphaNumeric();

    // Evaluate if the input value meets the rule or not
    if (!$val->evaluate('abcd1234')) {
        echo $val->getMessage();
    } else {
        echo 'The validator test passed. The string is alphanumeric.';
    }

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
