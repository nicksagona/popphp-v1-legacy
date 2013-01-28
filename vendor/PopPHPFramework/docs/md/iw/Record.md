Pop PHP Framework
=================

Documentation : Record
----------------------

Home

×”×ž×¨×›×™×‘ ×”×§×•×‘×¢, ×›×¤×™ ×©×ž×ª×•×?×¨ ×‘×¡×§×™×¨×ª ×”×ª×™×¢×•×“,
×”×•×? "×”×™×‘×¨×™×“×™" ×©×œ ×ž×™× ×™ ×‘×™×Ÿ ×”×¨×©×•×ž×” ×”×¤×¢×™×œ×”
×•×“×¤×•×¡×™ Gateway × ×ª×•× ×™ ×˜×‘×œ×”. ×‘×?×ž×¦×¢×•×ª API ×¡×˜×
×“×¨×˜×™, ×”×™×? ×™×›×•×œ×” ×œ×¡×¤×§ ×’×™×©×” ×œ×©×•×¨×” ×?×• ×¨×©×•×ž×”
×‘×•×“×“×” ×‘×˜×‘×œ×ª ×ž×¡×“ × ×ª×•× ×™×?, ×?×• ×©×•×¨×•×ª ×?×• ×¨×©×•×?
×”×ž×¨×•×‘×•×ª ×‘×‘×ª ×?×—×ª. ×”×’×™×©×” ×”× ×¤×•×¦×” ×‘×™×•×ª×¨ ×”×™×?
×œ×›×ª×•×‘ ×‘×›×™×ª×ª ×™×œ×“ ×©×ž×¨×—×™×‘×” ×?×ª ×”×ž×—×œ×§×”
×”×¨×©×•×ž×” ×©×ž×™×™×¦×’×ª ×˜×‘×œ×” ×‘×ž×¡×“ ×”× ×ª×•× ×™×?. ×©×ž×•
×©×œ ×”×™×œ×“ ×‘×›×™×ª×” ×¦×¨×™×š ×œ×”×™×•×ª ×”×©×? ×©×œ ×”×˜×‘×œ×”.
×¤×©×•×˜ ×¢×œ ×™×“×™ ×™×¦×™×¨×”

    use Pop\Record\Record;

    class Users extends Record { }

×?×ª×” ×™×•×¦×¨ ×‘×›×™×ª×” ×©×™×© ×?×ª ×›×œ ×”×¤×•× ×§×¦×™×•× ×œ×™×•×ª
×©×œ ×”×¨×›×™×‘ ×”×¨×©×•×? ×•× ×‘× ×” ×‘×›×™×ª×” ×™×•×“×¢×ª ×?×ª ×”×©×?
×©×œ ×”×˜×‘×œ×” ×‘×ž×¡×“ ×”× ×ª×•× ×™×? ×œ×©×?×™×œ×ª×? ×ž×©×?
×”×ž×—×œ×§×”. ×œ×“×•×’×ž×”, ×ž×ª×¨×’×? '×”×ž×©×ª×ž×©×™×?' ×œ×ž×©×ª×ž×©×™
\`\` ×?×• ×ž×ª×¨×’×? 'DbUsers' ×œ\` db\_users \`(CamelCase ×”×•×¤×š
×?×•×˜×•×ž×˜×™ lower\_case\_underscore.) ×ž×©×?, ×?×ª×” ×™×›×•×œ
×œ×›×•×•× ×Ÿ ×?×ª ×›×™×ª×ª ×”×™×œ×“ ×©×ž×™×™×¦×’×ª ×?×ª ×”×˜×‘×œ×” ×¢×?
×ž×?×¤×™×™× ×™×? ×‘×¨×ž×” ×©×•× ×™×?, ×›×’×•×Ÿ :

    // Table prefix, if applicable
    protected $prefix = null;

    // Primary ID, if applicable, defaults to 'id'
    protected $primaryId = 'id';

    // Whether the table is auto-incrementing or not
    protected $auto = true;

    // Whether to use prepared statements or not, defaults to true
    protected $usePrepared = true;

×?×? ×?×ª×” ×‘×ª×•×š ×¤×¨×•×™×§×˜ ×ž×•×‘× ×” ×©×™×© ×ž×ª×?×? ×ž×¡×“ ×
×ª×•× ×™×? ×ž×•×’×“×¨×™×?, ×?×– ×ž×¨×›×™×‘ ×”×©×™×? ×™×”×™×” ×œ×”×¨×™×?
×?×ª ×–×” ×•×œ×”×©×ª×ž×© ×‘×•. ×¢×? ×–×?×ª, ×?×? ×?×ª×” ×¤×©×•×˜
×›×•×ª×‘ ×›×ž×” ×ª×¡×¨×™×˜×™×? ×ž×”×™×¨×™×? ×‘×?×ž×¦×¢×•×ª ×¨×›×™×‘
×”×”×§×œ×˜×”, ×?×– ×?×ª×” ×¦×¨×™×š ×œ×”×’×™×“ ×?×ª ×–×” ×ž×ª×?×? ×ž×¡×“
× ×ª×•× ×™×? ×›×“×™ ×œ×”×©×ª×ž×© ×‘×•:

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

×ž×©×?, ×©×™×ž×•×© ×‘×¡×™×¡×™ ×”×•×? ×›×“×œ×§×ž×Ÿ:

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
