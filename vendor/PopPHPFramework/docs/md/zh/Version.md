Pop PHP Framework
=================

Documentation : Version
-----------------------

Home

ç‰ˆæœ¬ç»„ä»¶ä»…ä»…æ??ä¾›äº†èƒ½åŠ›ï¼Œä»¥ç¡®å®šå“ªä¸ªç‰ˆæœ¬çš„æµ?è¡Œä½
ç›®å‰?æœ‰ä»€ä¹ˆæœ€æ–°çš„æ˜¯ã€‚æ­¤å¤–ï¼Œæ­¤ç»„ä»¶è¢«ç”¨äºŽç”±CLIç»„ä»¶æ?¥æ‰§è¡Œçš„ä¾?èµ–æ£€æŸ¥ã€‚

    use Pop\Version;

    echo Version::getVersion();

    if (Version::compareVersion(1.0) == 1) {
        echo 'The current version is less than 1.0';
    } else {
        echo 'The current version is greater than or equal to 1.0';
    }

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
