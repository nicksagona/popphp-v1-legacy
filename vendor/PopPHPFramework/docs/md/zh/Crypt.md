Pop PHP Framework
=================

Documentation : Crypt
-----------------------

Home

地穴组件提供的能力来创建散列和验证对那些哈希值的。这个Mcrypt类支持双向加密。支持的地穴类型：

    use Pop\Crypt\Bcrypt;

    $bc = new Bcrypt();
    $hash = $bc->create('12password34');

    echo $hash;

    if ($bc->verify('12password34', $hash)) {
        echo 'Verified!';
    } else {
        echo 'NOT Verified!';
    }

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
