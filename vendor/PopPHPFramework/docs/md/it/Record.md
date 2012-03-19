Pop PHP Framework
=================

Documentation : Record
----------------------

La componente Record, come indicato nella panoramica documentazione, è un "ibrido" di sorta tra il record attivo e dati della tabella Gateway modelli. Attraverso una API standard, può fornire l'accesso a una singola riga o record all'interno di una tabella di database, o più righe o record in una volta. L'approccio più comune è quello di scrivere una classe bambino che estende la classe Record che rappresenta una tabella nel database. Il nome della classe figlio dovrebbe essere il nome della tabella. Con la semplice creazione di


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

Da lì, uso di base è il seguente:


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
