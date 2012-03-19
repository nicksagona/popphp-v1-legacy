Pop PHP Framework
=================

Documentation : Validator
-------------------------

Validator组件只提供了许多不同的使用情况，如验证是否一个数是一定的价值，或者是字母数字字符串，验证功能。以及更先进的验证，如验证电子邮件地址，IP地址或信用卡号码。而且，如果你需要的是不可用，组件可以很容易地扩展。


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
