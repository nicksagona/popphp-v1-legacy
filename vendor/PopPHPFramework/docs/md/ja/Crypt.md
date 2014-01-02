Pop PHP Framework
=================

Documentation : Crypt
-----------------------

Home

クリプトコンポーネントはハッシュを作成し、これらのハッシュに対して値を検証する機能を提供します。でMcryptクラスは、双方向の暗号化をサポートします。サポートされる暗号化の種類は次のとおりです。

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
