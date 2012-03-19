Pop PHP Framework
=================

Documentation : Record
----------------------

O componente Record, conforme descrito na visão geral da documentação, é um "híbrido" de tipos entre o Active Record e padrões da tabela de dados do Gateway. Através de uma API padronizada, que pode fornecer acesso a uma única linha ou registro em uma tabela de banco de dados, ou várias linhas ou registros de uma vez. A abordagem mais comum é escrever uma classe filha que estende a classe Record que representa uma tabela no banco de dados. O nome de classe criança deve ser o nome da tabela. Simplesmente criando


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

A partir daí, o uso de base é como se segue:


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
