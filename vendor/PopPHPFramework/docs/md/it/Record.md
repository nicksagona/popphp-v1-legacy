Pop PHP Framework
=================

Documentation : Record
----------------------

La componente Record, come indicato nella panoramica documentazione, è un "ibrido" di sorta tra il record attivo e dati della tabella Gateway modelli. Attraverso una API standard, può fornire l'accesso a una singola riga o record all'interno di una tabella di database, o più righe o record in una volta. L'approccio più comune è quello di scrivere una classe bambino che estende la classe Record che rappresenta una tabella nel database. Il nome della classe figlio dovrebbe essere il nome della tabella. Con la semplice creazione di


<pre>
use Pop\Record\Record;

class Users extends Record { }
</pre>

si crea una classe che ha tutte le funzionalità del componente Record costruito e la classe conosce il nome della tabella di database da interrogare dal nome della classe. Ad esempio, si traduce 'utenti' in `utenti` o traduce dei DbUsers 'in `db_users` (CamelCase viene automaticamente convertito in lower_case_underscore.) Da lì, si può ottimizzare la classe bambino che rappresenta la tabella con le proprietà di classe diverse, quali :

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
