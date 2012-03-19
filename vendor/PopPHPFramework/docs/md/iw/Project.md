Pop PHP Framework
=================

Documentation : Project
-----------------------

מרכיב הפרויקט מכיל את המעמד פרויקט בו ניתן להרחיב לתמצת מפרטים היישום שלך, כגון נתב, בקרים, מסדי נתונים ומודולים. פעם, להגדיר כראוי, הפרויקט יכול "לרוץ" בהצלחה לנתב את בקשת המשתמש לאזור הנכון של הבקשה. לראות את הקובץ doc MVC רכיב לראות דוגמה של קובץ פרויקט המורחבת בכיתה.

כמו כן, מרכיב הפרויקט מכיל את כיתות ההתקנה מרכיב CLI משתמש כדי לבנות ולהתקין פיגומים הפרוייקט. דוגמה של קובץ ההתקנה הפרויקט בתצורה נמוכה.

<pre>
&lt;?php
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
        'default' => array(
            'index' => 'index.phtml',
            'error' => 'error.phtml'
        ),
        'admin' => array(
            'index' => 'index.phtml',
            'error' => 'error.phtml'
        )
    )
));
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
