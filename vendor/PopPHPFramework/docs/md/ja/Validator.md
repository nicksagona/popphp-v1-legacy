Pop PHP Framework
=================

Documentation : Validator
-------------------------

検証コンポーネントは、単にそのような数が一定の値のものであるか、文字列が英数字であるかどうかの検証など、さまざまなユースケースの検証機能を提供します。より高度なバリデータは、電子メールアドレス、IPアドレスやクレジットカード番号を検証すると、同様にご利用いただけます。必要なものが利用できない場合や、コンポーネントを容易に拡張することができます。


<pre>
use Pop\Validator\Validator,
    Pop\Validator\Validator\AlphaNumeric;

// Create an alphanumeric validator
$val = Validator::factory(new AlphaNumeric());

// Evaluate if the input value meets the rule or not
if (!$val->evaluate('abcd1234')) {
    echo $val->getMessage();
} else {
    echo 'The validator test passed. The string is alphanumeric.';
}
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
