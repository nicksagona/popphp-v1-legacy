Pop PHP Framework
=================

Documentation : Record
----------------------

Home

The Record component, as outlined in the documentation overview, is a
"hybrid" of sorts between the Active Record and Table Data Gateway
patterns. Via a standardized API, it can provide access to a single row
or record within a database table, or multiple rows or records at once.
The most common approach is to write a child class that extends the
Record class that represents a table in the database. The name of the
child class should be the name of the table. By simply creating

    use Pop\Record\Record;

    class Users extends Record { }

you create a class that has all of the functionality of the Record
component built in and the class knows the name of the database table to
query from the class name. For example, 'Users' translates into
\`users\` or 'DbUsers' translates into \`db\_users\` (CamelCase is
automatically converted into lower\_case\_underscore.) From there, you
can fine-tune the child class that represents the table with various
class properties such as:

    // Table prefix, if applicable
    protected $prefix = null;

    // Primary ID, if applicable, defaults to 'id'
    protected $primaryId = 'id';

    // Whether the table is auto-incrementing or not
    protected $auto = true;

    // Whether to use prepared statements or not, defaults to true
    protected $usePrepared = true;

If you're within a structured project that has a defined database
adapter, then the Record component will pick that up and use it.
However, if you are simply writing some quick scripts using the Record
component, then you will need to tell it which database adapter to use:

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

From there, basic usage is as follows:

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
