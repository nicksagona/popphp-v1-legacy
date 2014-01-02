Pop PHP Framework
=================

Documentation : Project
-----------------------

Home

מרכיב הפרויקט מכיל כיתת פרויקט שבו אתה יכול להרחיב ולתמצת מפרטים של
היישומים שלך, כגון נתב, בקרים, מסדי נתונים ומודולים. פעם, הוגדר כראוי,
הפרויקט יכול "לרוץ" ולנתב את בקשתו של המשתמש לאזור הנכון של היישום שלך
בהצלחה. צפה בקובץ doc רכיב MVC כדי לראות דוגמה של קובץ מחלקת פרויקט
מורחב.

כמו כן, מרכיב הפרויקט מכיל את השיעורים שהתקנת רכיב CLI משתמש כדי לבנות
ולהתקין פיגומי הפרויקט שלך. דוגמה לקובץ תצורת התקנת פרויקט בהמשך.

    <?php
    return new Pop\Config(array(
        'project' => array(
            'name'    => 'HelloWorld',
            'base'    => __DIR__ . '/../../',
            'docroot' => __DIR__ . '/../../public'
        ),
        'databases' => array(
            'helloworld' => array(
                'type'     => 'Mysqli',
                'database' => 'helloworld',
                'host'     => 'localhost',
                'username' => 'hello',
                'password' => '12world34',
                'prefix'   => 'pop_',
                'default'  => true
            )
        ),
        'forms' => array(
            'login' => array(
                'fields' => array(
                    array(
                        'type'       => 'text',
                        'name'       => 'username',
                        'label'      => 'Username:',
                        'required'   => true,
                        'attributes' => array('size', 40),
                        'validators' => 'AlphaNumeric()'
                    ),
                    array(
                        'type'       => 'password',
                        'name'       => 'password',
                        'label'      => 'Password:',
                        'required'   => true,
                        'attributes' => array('size', 40),
                        'validators' => array('NotEmpty()', 'LengthGt(6)')
                    ),
                    array(
                        'type'       => 'submit',
                        'name'       => 'submit',
                        'value'      => 'LOGIN'
                    )
                )
            )
        ),
        'controllers' => array(
            '/' => array(
                'index' => 'index.phtml',
                'error' => 'error.phtml'
            ),
            '/admin' => array(
                'index' => 'index.phtml',
                'error' => 'error.phtml'
            )
        )
    ));

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
