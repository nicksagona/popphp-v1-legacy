Pop PHP Framework
=================

Documentation : Db
------------------

Home

المكون ديسيبل يوفر الوصول إلى قواعد البيانات تطبيع الاستعلام. محولات
المعتمدة هي:

-   mysql
-   mysqli
-   oracle
-   pdo
-   pgsql
-   sqlite
-   sqlsrv

يتم اعتماد البيانات المعدة مع MySQLi، أوراكل، شركة تنمية نفط عمان،
الإنترنت، سكليتي ومحولات SQLSrv. القيم هرب متاحة لجميع المحولات.

    use Pop\Db\Db;

    // Define DB credentials
    $creds = array(
        'database' => 'helloworld',
        'host'     => 'localhost',
        'username' => 'hello',
        'password' => '12world34'
    );

    // Create DB object
    $db = Db::factory('Mysqli', $creds);

    // Perform the query
    $db->adapter()->query('SELECT * FROM users');

    // Fetch the results
    while (($row = $db->adapter()->fetch()) != false) {
        print_r($row);
    }

بالإضافة إلى الوصول إلى قاعدة البيانات، المكون ديسيبل كما تحتوي على
التجريد مزود مفيدة الكائن الذي يساعدك في إنشاء استعلامات SQL موحدة.

    use Pop\Db\Db;
    use Pop\Db\Sql;

    $db = Db::factory('Sqlite', array('database' => 'mydb.sqlite'));

    $sql = new Sql($db, 'users');
    $sql->select()
        ->where()->equalTo('id', 1);

    // Outputs 'SELECT * FROM `users` WHERE `id` = 1'
    echo $sql;

            سجل الطبقة، كما ورد في الوثائق نظرة عامة، هو "مختلطة" من نوع ما بين السجل النشط وأنماط بوابة الجدول. عبر API موحدة، يمكن أن توفر إمكانية الوصول إلى صف واحد أو سجل في جدول قاعدة بيانات، أو صفوف متعددة في وقت واحد أو السجلات. النهج الأكثر شيوعا هو كتابة فئة الأطفال التي تمتد الطبقة سجل الذي يمثل الجدول في قاعدة البيانات. يجب أن يكون اسم الطبقة الطفل يكون اسم الجدول. من خلال خلق ببساطة:

    use Pop\Db\Record;

    class Users extends Record { }

            إنشاء فئة التي لديها كل من وظائف من الفئة التي بنيت في سجل والطبقة يعرف اسم جدول قاعدة البيانات للاستعلام عن اسم الفئة. على سبيل المثال، يترجم "المستخدمين" في `` المستخدمين أو يترجم 'DbUsers' إلى `` db_users (يتم تحويل تلقائيا إلى CamelCase lower_case_underscore.) من هناك، يمكنك صقل الطبقة الطفل الذي يمثل الجدول مع خصائص فئة مختلفة مثل :

    // Table prefix, if applicable
    protected $prefix = null;

    // Primary ID, if applicable, defaults to 'id'
    protected $primaryId = 'id';

    // Whether the table is auto-incrementing or not
    protected $auto = true;

    // Whether to use prepared statements or not, defaults to true
    protected $usePrepared = true;

            إذا كنت ضمن مشروع منظم يحتوي على قاعدة بيانات تعريف محول، ثم الطبقة سجل تختار أن تصل واستخدامها. ومع ذلك، إذا كنت تكتب ببساطة بعض الكتابات السريع باستخدام المكون سجل، فإنك سوف تحتاج لمعرفة ما الذي محول لاستخدام قاعدة البيانات:

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

            من هناك، واستخدام الأساسية هي كما يلي:

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

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
