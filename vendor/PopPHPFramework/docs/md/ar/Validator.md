Pop PHP Framework
=================

Documentation : Validator
-------------------------

المكون مدقق يوفر وظائف لمجرد التحقق من صحة بالنسبة للعديد من حالات الاستخدام المختلفة، مثل التحقق من صحة ما إذا كان الرقم هو من قيمة معينة أو سلسلة من أبجدية. المصادقون أكثر تقدما وتتوفر أيضا، مثل التحقق من صحة عنوان بريد إلكتروني، وعنوان IP أو رقم بطاقة الائتمان. وإذا ما كنت في حاجة ليست متاحة، ويمكن لمكون أن تمتد بسهولة.


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
