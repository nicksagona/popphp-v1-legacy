Pop PHP Framework
=================

Documentation : Graph
---------------------

Home

å¼ºå¤§çš„ç»˜å›¾åŠŸèƒ½ï¼Œå?¯ä»¥åˆ©ç”¨å†…ç½®çš„å›¾å½¢ç»„ä»¶ï¼Œå¦‚å›¾ç‰‡ï¼ŒSVGå’ŒPDFçš„å›¾å½¢ç»„ä»¶å…?è®¸åœ¨ç»˜åˆ¶å›¾å½¢çš„å¤šç§?æ
¼å¼?ã€‚æ‚¨å?¯ä»¥å®šä¹‰ä¸€ä¸ªå¹¿æ³›çš„å›¾å½¢å±žæ€§çš„åˆ›å»ºå’Œæ¸²æŸ“çº¿å›¾ï¼Œæ?¡å½¢å›¾å’Œé¥¼å›¾ã€‚ç”±äºŽAPIåœ¨ä¸?å?Œçš„å›¾å½¢ç»„ä»¶æ˜¯æ
‡å‡†åŒ–çš„ï¼Œå®ƒå¾ˆå®¹æ˜“äº’æ?¢ä¹‹é—´ä¸?å?Œçš„æ–‡ä»¶å’Œå›¾åƒ?æ
¼å¼?åœ¨å›¾ã€‚

    use Pop\Color\Space\Rgb,
        Pop\Graph\Graph;

    $x = array('1995', '2000', '2005', '2010', '2015');
    $y = array('0M', '50M', '100M', '150M', '200M');

    $data = array(
        array(1995, 0),
        array(1997, 35),
        array(1998, 25),
        array(2002, 100),
        array(2004, 84),
        array(2006, 98),
        array(2007, 76),
        array(2010, 122),
        array(2012, 175),
        array(2015, 162)
    );


    $graph = new Graph(array(
        'filename' => 'graph.gif',
        'width'    => 640,
        'height'   => 480
    ));

    $graph->addFont('../assets/fonts/times.ttf')
          ->setFontColor(new Rgb(128, 128, 128))
          ->setFillColor(new Rgb(10, 125, 210))
          ->showY(true)
          ->showText(true)
          ->createLineGraph($data, $x, $y)
          ->output();

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
