Pop PHP Framework
=================

Documentation : Record
----------------------

Запись компонент, как указано в документации, обзор, является "гибридная" сортов между Active Record и в таблице данных моделей Gateway. Через стандартизированные API, она может обеспечить доступ к одной строки или записи в таблице базы данных или нескольких строк или записей сразу. Наиболее распространенный подход заключается в написании дочерний класс, который расширяет класс, запись представляет собой таблицу в базе данных. Имя ребенку класса должны быть имя таблицы. Просто создание

<pre>
use Pop\Record\Record;

class Users extends Record { }
</pre>

Вы создаете класс, который имеет все функциональные возможности записи компонент построен в классе и знает имя таблицы базы данных, запросы от имени класса. Например, переводит "Пользователи" в `` пользователям или переводит "DbUsers 'в` db_users `(CamelCase автоматически преобразуется в lower_case_underscore). Оттуда вы можете подстроить ребенка класс, который представляет собой таблицу с различными свойствами класса, такие как :

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

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
