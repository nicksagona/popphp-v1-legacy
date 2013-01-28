Pop PHP Framework
=================

Documentation : Validator
-------------------------

Home

æ¤œè¨¼ã‚³ãƒ³ãƒ?ãƒ¼ãƒ?ãƒ³ãƒˆã?¯ã€?å?˜ã?«ã??ã?®ã‚ˆã?†ã?ªæ•°ã?Œä¸€å®šã?®å€¤ã?§ã?‚ã‚‹ã?‹ã€?æ–‡å­—åˆ—ã?Œè‹±æ•°å­—ã?§ã?‚ã‚‹ã?‹å?¦ã?‹ã?®æ¤œè¨¼ã?ªã?©ã€?ã?•ã?¾ã?–ã?¾ã?ªãƒ¦ãƒ¼ã‚¹ã‚±ãƒ¼ã‚¹ã?®æ¤œè¨¼æ©Ÿèƒ½ã‚’æ??ä¾›ã?—ã?¾ã?™ã€‚ã‚ˆã‚Šé«˜åº¦ã?ªãƒ?ãƒªãƒ‡ãƒ¼ã‚¿ã?¯ã€?é›»å­?ãƒ¡ãƒ¼ãƒ«ã‚¢ãƒ‰ãƒ¬ã‚¹ã€?IPã‚¢ãƒ‰ãƒ¬ã‚¹ã‚„ã‚¯ãƒ¬ã‚¸ãƒƒãƒˆã‚«ãƒ¼ãƒ‰ç•ªå?·ã?®æ¤œè¨¼ã?ªã?©ã€?ã‚‚ã?”åˆ©ç”¨ã?„ã?Ÿã?
ã?‘ã?¾ã?™ã€‚ã??ã?—ã?¦ã€?ã?‚ã?ªã?Ÿã?Œå¿…è¦?ã?ªã‚‚ã?®ã?Œä½¿ç”¨ã?§ã??ã?ªã?„å
´å?ˆã?¯ã€?ã‚³ãƒ³ãƒ?ãƒ¼ãƒ?ãƒ³ãƒˆã?®å®¹æ˜“ã?«æ‹¡å¼µã?™ã‚‹ã?“ã?¨ã?Œã?§ã??ã?¾ã?™ã€‚

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
