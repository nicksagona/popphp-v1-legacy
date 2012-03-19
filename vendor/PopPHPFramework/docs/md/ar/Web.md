Pop PHP Framework
=================

Documentation : Web
-------------------

مكون ويب عبارة عن مجموعة من على شبكة الإنترنت احتياجات وظائف، مثل دورات إدارة والخوادم والمتصفحات والكوكيز. أيضا، فإنه يشمل وظائف للكشف عن الأجهزة المحمولة بحيث أن التطبيق الخاص بك يمكن أن تستجيب وفقا لذلك.

<pre>
use Pop\Web\Session;

$sess = Session::getInstance();
$sess->username = 'yourname';
print_r($sess);
print_r($_SESSION);

echo $sess->getId();
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
