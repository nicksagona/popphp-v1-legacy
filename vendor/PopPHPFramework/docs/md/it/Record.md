Pop PHP Framework
=================

Documentation : Record
----------------------

Home

Il componente di registrazione, come indicato nella documentazione
panoramica, Ã¨ un "ibrido" di sorta tra l'Active Record e dati della
tabella modelli Gateway. Grazie ad una API standard, Ã¨ in grado di
fornire l'accesso a una singola riga o record all'interno di una tabella
di database, o piÃ¹ righe o record contemporaneamente. L'approccio piÃ¹
comune Ã¨ quello di scrivere una classe figlia che estende la classe
record che rappresenta una tabella nel database. Il nome della classe
figlio dovrebbe essere il nome della tabella. Con la semplice creazione
di

    use Pop\Record\Record;

    class Users extends Record { }

si crea una classe che dispone di tutte le funzionalitÃ del componente
di registrazione costruito e la classe conosce il nome della tabella di
database per eseguire query dal nome della classe. Ad esempio, si
traduce 'utenti INTO \`utenti\` o si traduce "DbUsers' in\` \`(db\_users
CamelCase viene automaticamente convertito in lower\_case\_underscore.)
Da lÃ¬, Ã¨ possibile ottimizzare la classe figlia che rappresenta la
tabella con le proprietÃ di classe diverse, quali:

    // Table prefix, if applicable
    protected $prefix = null;

    // Primary ID, if applicable, defaults to 'id'
    protected $primaryId = 'id';

    // Whether the table is auto-incrementing or not
    protected $auto = true;

    // Whether to use prepared statements or not, defaults to true
    protected $usePrepared = true;

Se sei all'interno di un progetto strutturato che ha una scheda di
database definito, quindi il componente di registrazione riprenderÃ che
fino e utilizzarlo. Tuttavia, se si sta semplicemente scrivendo alcuni
script veloci utilizzando il componente di registrazione, allora si avrÃ
bisogno di dire quale scheda database da utilizzare:

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

Da lÃ¬, uso di base Ã¨ la seguente:

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
