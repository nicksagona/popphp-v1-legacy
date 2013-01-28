Pop PHP Framework
=================

Documentation : Image
---------------------

Home

å›¾åƒ?ç»„ä»¶æ??ä¾›äº†ä¸€ä¸ªæ
‡å‡†çš„APIï¼Œç”¨äºŽåˆ›å»ºå’Œå¤„ç?†å›¾åƒ?ï¼Œå……åˆ†åˆ©ç”¨äº†PHPçš„GDå’Œimagickçš„æ‰©å±•ï¼Œä»¥å?ŠSVGå›¾åƒ?æ
¼å¼?çš„åŒ…è£…ã€‚åœ¨è¿™ä¸ªç»„ä»¶æ˜¯ä¸€ä¸ªåŠŸèƒ½ä¸°å¯Œçš„APIï¼Œç”¨äºŽæ‰§è¡Œè®¸å¤šä¸?å?Œçš„åŸºäºŽå›¾åƒ?çš„åŠŸèƒ½ã€‚è€Œä¸”ï¼Œç”±äºŽæ˜¯æ
‡å‡†åŒ–çš„APIï¼Œå¦‚æžœä¸€ä¸ªé¡¹ç›®ç§»åŠ¨åˆ°ä¸?å?Œçš„çŽ¯å¢ƒä¸­ï¼Œå®ƒä¼šé€?æ¸?é™?ä½Žå®¹æ˜“ã€‚

    use Pop\Color\Space\Rgb,
        Pop\Image\Gd;

    $image = new Gd('new-image.jpg', 640, 480, new Rgb(255, 0, 0));
    $image->setFillColor(new Rgb(0, 0, 255))
          ->setStrokeColor(new Rgb(255, 255, 255))
          ->setStrokeWidth(3)
          ->drawEllipse(320, 240, 150, 75)
          ->output();

    $image->destroy();

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
