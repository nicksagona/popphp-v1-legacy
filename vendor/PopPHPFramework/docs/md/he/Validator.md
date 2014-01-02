Pop PHP Framework
=================

Documentation : Validator
-------------------------

Home

מרכיב Validator פשוט מספק פונקציונלי אימות למקרים רבים שונים, כגון שימוש
באימות או לא הוא מספר של ערך מסוים או מחרוזת היא אלפאנומרי. validators
המתקדם יותר זמין, כמו גם, כגון אימות כתובת דוא"ל, וכתובת ה-IP או מספר
כרטיס אשראי. ואם מה שאתה צריך זה לא זמין, של הרכיב ניתן להרחיב בקלות.

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
