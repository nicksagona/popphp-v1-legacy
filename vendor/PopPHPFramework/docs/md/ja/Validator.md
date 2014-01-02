Pop PHP Framework
=================

Documentation : Validator
-------------------------

Home

検証コンポーネントは、単にそのような数が一定の値であるか、文字列が英数字であるか否かの検証など、さまざまなユースケースの検証機能を提供します。より高度なバリデータは、電子メールアドレス、IPアドレスやクレジットカード番号の検証など、もご利用いただけます。そして、あなたが必要なものが使用できない場合は、コンポーネントの容易に拡張することができます。

    use Pop\Validator\AlphaNumeric;

    // Create an alphanumeric validator
    $val = new AlphaNumeric();

    // Evaluate if the input value meets the rule or not
    if (!$val->evaluate('abcd1234')) {
        echo $val->getMessage();
    } else {
        echo 'The validator test passed. The string is alphanumeric.';
    }

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
