Pop PHP Framework
=================

Documentation : Record
----------------------

Die Record-Komponente, wie in der Dokumentation Überblick skizziert, ist ein "Hybrid" von Art zwischen dem Active Record und Table Data Gateway-Muster. Über eine standardisierte API, kann er den Zugriff auf eine einzelne Zeile oder Datensatz in einer Datenbank-Tabelle oder mehrere Zeilen oder Datensätze auf einmal liefern. Die häufigste Methode ist, ein Kind zu Klasse, die die Record-Klasse, die eine Tabelle in der Datenbank repräsentiert erstreckt schreiben. Der Name des Kindes Klasse sollte der Name der Tabelle sein. Durch einfaches Anlegen

<pre>
use Pop\Record\Record;

class Users extends Record { }
</pre>

Sie erstellen eine Klasse, die die gesamte Funktionalität des Record-Komponente eingebaut und die Klasse kennt den Namen der Datenbank-Tabelle, um aus den Namen der Klasse abfragen muss. Zum Beispiel, 'Benutzer' übersetzt in `users` oder 'DbUsers' übersetzt in `` db_users (CamelCase wird automatisch in lower_case_underscore umgewandelt.) Von dort aus können Sie eine Feinabstimmung der Kind-Klasse, die die Tabelle mit verschiedenen Eigenschaften, wie zB Klasse repräsentiert :

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

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
