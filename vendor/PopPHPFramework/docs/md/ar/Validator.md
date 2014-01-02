Pop PHP Framework
=================

Documentation : Validator
-------------------------

Home

المكون مدقق يوفر وظائف التحقق من صحة ببساطة لكثير من حالات الاستخدام
المختلفة، مثل التحقق من صحة ما إذا كان الرقم من قيمة معينة أو سلسلة من
الأبجدية الرقمية. مدقق أكثر تقدما وتتوفر أيضا، مثل التحقق من صحة عنوان
البريد الإلكتروني، وعنوان IP أو رقم بطاقة الائتمان. وإذا ما عليك غير
متوفرة، يمكن للمكون أن تمتد بسهولة.

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
