Pop PHP Framework
=================

Documentation : Record
----------------------

Die Record-Komponente, wie in der Dokumentation Überblick skizziert, ist ein "Hybrid" von Art zwischen dem Active Record und Table Data Gateway-Muster. Über eine standardisierte API, kann er den Zugriff auf eine einzelne Zeile oder Datensatz in einer Datenbank-Tabelle oder mehrere Zeilen oder Datensätze auf einmal liefern. Die häufigste Methode ist, ein Kind zu Klasse, die die Record-Klasse, die eine Tabelle in der Datenbank repräsentiert erstreckt schreiben. Der Name des Kindes Klasse sollte der Name der Tabelle sein. Durch einfaches Anlegen


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

Von dort aus ist die grundlegende Anwendung wie folgt:


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
