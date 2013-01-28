Pop PHP Framework
=================

Documentation : Paginator
-------------------------

Home

Paginator ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚ Ð¿Ñ€Ð¾Ñ?Ñ‚Ð¾ Ð¿Ñ€ÐµÐ´Ð¾Ñ?Ñ‚Ð°Ð²Ð»Ñ?ÐµÑ‚
Ñ„ÑƒÐ½ÐºÑ†Ð¸Ð¾Ð½Ð°Ð»ÑŒÐ½Ñ‹Ðµ Ð²Ð¾Ð·Ð¼Ð¾Ð¶Ð½Ð¾Ñ?Ñ‚Ð¸ Ð´Ð»Ñ?
Ñ?Ñ‚Ñ€Ð°Ð½Ð¸Ñ†Ñ‹ Ð¸Ð· Ð±Ð¾Ð»ÑŒÑˆÐ¾Ð³Ð¾ Ð½Ð°Ð±Ð¾Ñ€Ð°
Ñ€ÐµÐ·ÑƒÐ»ÑŒÑ‚Ð°Ñ‚Ð¾Ð². ÐœÐ½Ð¾Ð³Ð¾ Ñ€Ð°Ð·Ð»Ð¸Ñ‡Ð½Ñ‹Ñ…
Ð¿Ð°Ñ€Ð°Ð¼ÐµÑ‚Ñ€Ð¾Ð² Ð¸ Ð°Ñ‚Ñ€Ð¸Ð±ÑƒÑ‚Ð¾Ð² Ð¼Ð¾Ð¶ÐµÑ‚ Ð±Ñ‹Ñ‚ÑŒ
Ð¿Ñ€Ð¸Ð¼ÐµÐ½ÐµÐ½, Ð½Ð¾ Ð½Ð°Ð¸Ð±Ð¾Ð»ÐµÐµ Ð¿Ð¾Ð»ÐµÐ·Ð½Ñ‹Ð¼
Ñ?Ð²Ð»Ñ?ÐµÑ‚Ñ?Ñ? Ð¿Ð¾Ð´Ð´ÐµÑ€Ð¶ÐºÐ° ÑˆÐ°Ð±Ð»Ð¾Ð½Ð¾Ð², Ñ‡Ñ‚Ð¾ Ð¾Ð½
Ð²Ñ?Ñ‚Ñ€Ð¾ÐµÐ½Ð½Ð¾Ð³Ð¾

    use Pop\Paginator\Paginator;

    $rows = array(
        array('id' => 1, 'name' => 'Test1', 'email' => 'test1@email.com'),
        array('id' => 2, 'name' => 'Test2', 'email' => 'test2@email.com'),
        array('id' => 3, 'name' => 'Test3', 'email' => 'test3@email.com'),
        array('id' => 4, 'name' => 'Test4', 'email' => 'test4@email.com'),
        array('id' => 5, 'name' => 'Test5', 'email' => 'test5@email.com'),
        array('id' => 6, 'name' => 'Test6', 'email' => 'test6@email.com'),
        array('id' => 7, 'name' => 'Test7', 'email' => 'test7@email.com'),
        array('id' => 8, 'name' => 'Test8', 'email' => 'test8@email.com'),
        array('id' => 9, 'name' => 'Test9', 'email' => 'test9@email.com'),
        array('id' => 10, 'name' => 'Test10', 'email' => 'test10@email.com'),
        array('id' => 11, 'name' => 'Test11', 'email' => 'test11@email.com'),
        array('id' => 12, 'name' => 'Test12', 'email' => 'test12@email.com'),
        array('id' => 13, 'name' => 'Test13', 'email' => 'test13@email.com'),
        array('id' => 14, 'name' => 'Test14', 'email' => 'test14@email.com'),
        array('id' => 15, 'name' => 'Test15', 'email' => 'test15@email.com'),
        array('id' => 16, 'name' => 'Test16', 'email' => 'test16@email.com')
    );

    $header = <<<HEADER
    <table class="paged-table" cellpadding="0" cellspacing="0">
        <tr><td colspan="2">[{page_links}]</td></tr>
        <tr><td><strong>Name</strong></td><td><strong>Email</strong></td></tr>

    HEADER;

    $rowTemplate = <<<TMPL
        <tr><td><a href="./edit-user.php?id=[{id}]">[{name}]</a></td><td>[{email}]</td></tr>

    TMPL;

    $footer = <<<FOOTER
        <tr><td colspan="2">[{page_links}]</td></tr>
    </table>

    FOOTER;

    $pages = new Paginator($rows, 3, 3);
    $pages->setHeader($header)
          ->setRowTemplate($rowTemplate)
          ->setFooter($footer);

    echo $pages;

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
