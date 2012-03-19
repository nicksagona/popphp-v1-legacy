Pop PHP Framework
=================

Documentation : Locale
----------------------

המרכיב אזור מספקת תמיכה שפה פונקציונליות תרגום עבור היישום. אתה יכול פשוט ליצור לטעון קבצי XML משלך של תרגומים בשפות הנדרשות בפורמט מה המתוארים הקבצים האישיים של פופ שפת XML.


אתה יכול לטעון תרגום משלך קבצי שפה, כל עוד לדבוק בתקן XML הוקמה בתיקייה פופ / אזור / נתונים.


<pre>
use Pop\Locale\Locale;

// Create a Locale object to translate to French, using your own language file.
$lang = Locale::factory('fr')->loadFile('folder/mylangfile.xml);

// Will output 'Ce champ est obligatoire.'
$lang->_e('This field is required.');

// Will return and output 'Ce champ est obligatoire.'
echo $lang->__('This field is required.');
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
