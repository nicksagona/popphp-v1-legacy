Pop PHP Framework
=================

Documentation : Validator
-------------------------

Home

简单的验证组件提供验证功能，为许多不同的使用情况，如验证是否或不是一个数字是有一定的价值，或者是字母数字字符串。更先进的验证程序可为好，如验证电子邮件地址，IP地址或信用卡号码。而且，如果你需要的是不可用的组件，可以很容易地扩展。

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
