Pop PHP Framework
=================

Documentation : Record
----------------------

文档中概述的概述，记录组件，是一种“混合”的各种活动记录和表数据网关模式之间。通过标准化的API，它可以在一个数据库表，或多个行或记录一次访问一个单一的行或记录。最常用的方法是写一个子类，扩展类，它代表了数据库中的表的记录。子类的名称应该是表的名称。通过简单地创建


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

从那里，基本用法如下：


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
