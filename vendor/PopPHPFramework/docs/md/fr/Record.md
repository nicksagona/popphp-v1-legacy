Pop PHP Framework
=================

Documentation : Record
----------------------

Home

Le volet enregistrement, comme indiquÃ© dans la liste des documents, est
un Â«hybrideÂ» de toutes sortes entre l'Active Record et les habitudes
Table Data Gateway. Via une interface standardisÃ©e, il peut donner
accÃ¨s Ã une seule ligne ou enregistrement dans une table de base de
donnÃ©es, ou plusieurs lignes ou des dossiers Ã la fois. L'approche la
plus courante consiste Ã Ã©crire une classe enfant qui Ã©tend la classe
enregistrement qui reprÃ©sente une table dans la base de donnÃ©es. Le
nom de la classe de l'enfant doit Ãªtre le nom de la table. En crÃ©ant
simplement

    use Pop\Record\Record;

    class Users extends Record { }

vous crÃ©ez une classe qui dispose de toutes les fonctionnalitÃ©s du
composant enregistrement intÃ©grÃ© et la classe connaÃ®t le nom de la
table de base de donnÃ©es Ã interroger Ã partir du nom de la classe. Par
exemple, se traduit par Â«UtilisateursÂ» dans \`utilisateurs\` ou
traduit 'DbUsers' sur \`\` db\_users (CamelCase est automatiquement
converti en lower\_case\_underscore.) A partir de lÃ , vous pouvez
affiner la classe enfant qui reprÃ©sente la table de propriÃ©tÃ©s de la
classe divers tels que:

    // Table prefix, if applicable
    protected $prefix = null;

    // Primary ID, if applicable, defaults to 'id'
    protected $primaryId = 'id';

    // Whether the table is auto-incrementing or not
    protected $auto = true;

    // Whether to use prepared statements or not, defaults to true
    protected $usePrepared = true;

Si vous Ãªtes dans un projet structurÃ© qui possÃ¨de une carte de base
de donnÃ©es dÃ©fini, alors le composant sera enregistrement ramasser Ã§a
et l'utiliser. Toutefois, si vous Ãªtes tout simplement Ã Ã©crire des
scripts rapides en utilisant le composant enregistrement, alors vous
aurez besoin de le dire adaptateur de base de donnÃ©es qui Ã utiliser:

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

A partir de lÃ , l'utilisation de base est la suivante:

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
