Pop PHP Framework
=================

Documentation : Record
----------------------

Home

ä¸­åˆ—å‡ºçš„æ–‡æ¡£æ¦‚è¿°ï¼Œè®°å½•ç»„ä»¶ï¼Œæ˜¯ä¸€ç§?â€œæ··å?ˆâ€?çš„ç±»åž‹ä¹‹é—´çš„æ´»åŠ¨è®°å½•è¡¨æ•°æ?®ç½‘å…³æ¨¡å¼?ã€‚é€šè¿‡æ
‡å‡†åŒ–çš„APIï¼Œå®ƒå?¯ä»¥æ??ä¾›ä¸€ä¸ªå?•ä¸€çš„è¡Œæˆ–è®°å½•åœ¨ä¸€ä¸ªæ•°æ?®åº“ä¸­çš„è¡¨æˆ–å¤šä¸ªè¡Œæˆ–è®°å½•ä¸€æ¬¡ã€‚æœ€å¸¸ç”¨çš„æ–¹æ³•æ˜¯å†™ä¸€ä¸ªå­?ç±»ï¼Œæ‰©å±•ç±»ï¼Œå®ƒä»£è¡¨ä¸€ä¸ªæ•°æ?®åº“ä¸­çš„è¡¨çš„è®°å½•ã€‚å­?ç±»çš„å??ç§°åº”è¯¥æ˜¯è¡¨çš„å??ç§°ã€‚é€šè¿‡ç®€å?•çš„åˆ›å»º

    use Pop\Record\Record;

    class Users extends Record { }

æ‚¨å?¯ä»¥åˆ›å»ºä¸€ä¸ªç±»ï¼Œå®ƒå…·æœ‰è®°å½•çš„åŠŸèƒ½ç»„ä»¶å’Œç±»çŸ¥é?“çš„ç±»å??æ?¥æŸ¥è¯¢æ•°æ?®åº“ä¸­çš„è¡¨çš„å??ç§°ã€‚ä¾‹å¦‚ï¼Œ'ç”¨æˆ·'è½¬åŒ–ä¸º'ç”¨æˆ·'æˆ–'DbUsers'è½¬åŒ–ä¸º'db\_usersï¼ˆé©¼å³°è¢«è‡ªåŠ¨è½¬æ?¢æˆ?lower\_case\_underscoreï¼‰ã€‚ä»Žé‚£é‡Œï¼Œä½
å?¯ä»¥ç²¾ç»†è°ƒæ•´çš„å­?ç±»ï¼Œå®ƒä»£è¡¨äº†ä¸?å?Œçš„ç±»å±žæ€§ï¼Œå¦‚è¡¨ï¼š

    // Table prefix, if applicable
    protected $prefix = null;

    // Primary ID, if applicable, defaults to 'id'
    protected $primaryId = 'id';

    // Whether the table is auto-incrementing or not
    protected $auto = true;

    // Whether to use prepared statements or not, defaults to true
    protected $usePrepared = true;

å¦‚æžœä½
åœ¨ä¸€ä¸ªç»“æž„åŒ–çš„é¡¹ç›®ï¼Œæœ‰ä¸€ä¸ªå®šä¹‰çš„æ•°æ?®åº“é€‚é…?å™¨ï¼Œç„¶å?Žå°†é€‰æ‹©çš„è®°å½•ç»„ä»¶ï¼Œå¹¶ä½¿ç”¨å®ƒã€‚ä½†æ˜¯ï¼Œå¦‚æžœä½
ä»…ä»…æ˜¯å†™ä¸€äº›ç®€å?•çš„è„šæœ¬ï¼Œä½¿ç”¨è®°å½•ç»„ä»¶ï¼Œé‚£ä¹ˆä½
éœ€è¦?å‘Šè¯‰å®ƒçš„æ•°æ?®åº“é€‚é…?å™¨ä½¿ç”¨ï¼š

    // Define DB credentials
    $creds = array(
        'database' => 'helloworld',
        'host'     => 'localhost',
        'username' => 'hello',
        'password' => '12world34'
    );

    // Create DB object
    $db = \Pop\Db\Db::factory('Mysqli', $creds);

    Record::setDb($db);

ä»Žé‚£é‡Œï¼ŒåŸºæœ¬ç”¨æ³•å¦‚ä¸‹ï¼š

    // Get a single user
    $user = Users::findById(1001);
    echo $user->name;
    echo $user->email;

    // Get multiple users
    $users = Users::findAll('last_name ASC');
    foreach ($users->rows as $user) {
        echo $user->name;
        echo $user->email;
    }

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
