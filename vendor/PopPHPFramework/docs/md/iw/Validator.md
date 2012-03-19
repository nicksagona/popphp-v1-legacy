Pop PHP Framework
=================

Documentation : Validator
-------------------------

מרכיב Validator פשוט מספק פונקציונליות אימות עבור רבים המקרים שימוש שונים, כגון אימות אם מספר הוא בעל ערך מסוים או מחרוזת הוא אלפאנומרי. Validators מתקדמים יותר זמינים גם כן, כגון אימות כתובת דואר אלקטרוני, וכתובת ה-IP או מספר כרטיס אשראי. ואם מה שאתה צריך זה אינו זמין, של הרכיב ניתן להרחיב בקלות.

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
