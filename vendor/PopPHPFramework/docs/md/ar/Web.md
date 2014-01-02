Pop PHP Framework
=================

Documentation : Web
-------------------

Home

مكون ويب عبارة عن مجموعة من شبكة الإنترنت والاحتياجات وظائف، مثل دورات
إدارة والخوادم، برامج التصفح وملفات تعريف الارتباط. أيضا، فإنه يشمل
وظائف للكشف عن الأجهزة النقالة بحيث أن التطبيق الخاص بك يمكن أن تستجيب
وفقا لذلك.

    use Pop\Web\Session;

    $sess = Session::getInstance();
    $sess->username = 'yourname';
    print_r($sess);
    print_r($_SESSION);

    echo $sess->getId();

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
