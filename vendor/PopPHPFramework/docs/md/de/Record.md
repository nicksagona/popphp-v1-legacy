Pop PHP Framework
=================

Documentation : Record
----------------------

Home

Die Record-Komponente, wie in der Dokumentation Überblick skizziert, ist
ein "Hybrid" der Arten zwischen dem Active Record und Table Data Gateway
Muster. Über eine standardisierte API, können sie den Zugang zu einer
einzelnen Zeile oder Datensatz in einer Datenbank-Tabelle oder mehrere
Zeilen oder Datensätze auf einmal liefern. Die häufigste Methode ist,
ein Kind zu Klasse, die die Record-Klasse, die eine Tabelle in der
Datenbank stellt sich schreiben. Der Name des Kindes Klasse sollte der
Name der Tabelle. Durch einfaches Erstellen

    use Pop\Record\Record;

    class Users extends Record { }

Sie erstellen eine Klasse, die die gesamte Funktionalität des
Record-Komponente eingebaut und die Klasse kennt den Namen der
Datenbank-Tabelle aus den Namen der Klasse abgefragt hat. Zum Beispiel,
'Users' übersetzt in \`users\` oder 'DbUsers' übersetzt in \`db\_users\`
(CamelCase wird automatisch in lower\_case\_underscore umgewandelt.) Von
dort aus können Sie die Feinabstimmung der Kind-Klasse, die die Tabelle
mit verschiedenen Klassen Eigenschaften wie stellt:

    // Table prefix, if applicable
    protected $prefix = null;

    // Primary ID, if applicable, defaults to 'id'
    protected $primaryId = 'id';

    // Whether the table is auto-incrementing or not
    protected $auto = true;

    // Whether to use prepared statements or not, defaults to true
    protected $usePrepared = true;

Wenn Sie innerhalb eines strukturierten Projekt, das eine definierte
Datenbank-Adapter hat, dann sind die Record-Komponente holen, dass bis
und zu nutzen. Allerdings, wenn Sie einfach schriftlich sind einige
schnelle Skripte mit den Record-Komponente, dann werden Sie brauchen, um
es welche Datenbank-Adapter sagen, zu verwenden:

    // Define DB credentials
    $creds = array(
        'database' => 'helloworld',
        'host'     => 'localhost',
        'username' => 'hello',
        'password' => '12world34'
    );

    // Create DB object
    $db = \Pop\Db\Db::factory('Mysqli', $creds);

    Record::setDb($db);

Von dort sind grundlegende Verwendung wie folgt:

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

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
