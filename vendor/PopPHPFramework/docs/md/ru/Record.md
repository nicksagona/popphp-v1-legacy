Pop PHP Framework
=================

Documentation : Record
----------------------

Запись компонент, как указано в документации, обзор, является "гибридная" сортов между Active Record и в таблице данных моделей Gateway. Через стандартизированные API, она может обеспечить доступ к одной строки или записи в таблице базы данных или нескольких строк или записей сразу. Наиболее распространенный подход заключается в написании дочерний класс, который расширяет класс, запись представляет собой таблицу в базе данных. Имя ребенку класса должны быть имя таблицы. Просто создание


<pre>
use Pop\Record\Record;

class Users extends Record { }
</pre>

you create a class that has all of the functionality of the Record component built in and the class knows the name of the database table to query from the class name. For example,  'Users' translates into `users` or 'DbUsers' translates into `db_users` (CamelCase is automatically converted into lower_case_underscore.) From there, you can fine-tune the child class that represents the table with various class properties such as:

<pre>
// Table prefix, if applicable
protected $prefix = null;

// Primary ID, if applicable, defaults to 'id'
protected $primaryId = 'id';

// Whether the table is auto-incrementing or not
protected $auto = true;

// Whether to use prepared statements or not, defaults to true
protected $usePrepared = true;
</pre>

Оттуда, в основном использовать следующим образом:


<pre>
use Users;

// Get a single user
$user = Users::findById(1001);
echo $user->name;
echo $user->email;

// Get multiple users
$users = Users::findAll('last_name ASC');
foreach ($users->rows as $user) {
    echo $user->name;
    echo $user->email;
}
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
