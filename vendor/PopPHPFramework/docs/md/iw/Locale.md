Pop PHP Framework
=================

Documentation : Locale
----------------------

Home

ואם אתה צריך קובץ classmap נוצר, רכיב Loader יש הפונקציונלי קל כדי ליצור
קובץ classmap גם לך.

אתה יכול לטעון קבצי תרגום השפה שלך, כל עוד לדבוק בתקן XML הוקם בתיקיית
פופ / האזור / נתונים.

    use Pop\Locale\Locale;

    // Create a Locale object to translate to French, using your own language file.
    $lang = Locale::factory('fr')->loadFile('folder/mylangfile.xml);

    // Will output 'Ce champ est obligatoire.'
    $lang->_e('This field is required.');

    // Will return and output 'Ce champ est obligatoire.'
    echo $lang->__('This field is required.');

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
