Pop PHP Framework
=================

Documentation : Record
----------------------

Home

المكون سجل، على النحو المبين في وثائق نظرة عامة، هو "مختلطة" من نوع ما
بين السجل النشط وأنماط الجدول بوابة البيانات. عبر API موحدة، يمكن أن
توفر إمكانية الوصول إلى صف واحد أو سجل في جدول قاعدة بيانات، أو صفوف
متعددة في وقت واحد أو السجلات. النهج الأكثر شيوعا هو كتابة فئة الأطفال
التي تمتد الطبقة سجل الذي يمثل الجدول في قاعدة البيانات. يجب أن يكون اسم
الطبقة الطفل يكون اسم الجدول. ببساطة عن طريق إنشاء

    use Pop\Record\Record;

    class Users extends Record { }

إنشاء فئة التي لديها كل من وظائف المكون سجل بنيت في والطبقة يعرف اسم
جدول قاعدة البيانات للاستعلام عن اسم الفئة. على سبيل المثال، يترجم
"المستخدمين" في \`\` المستخدمين أو يترجم 'DbUsers' إلى \`\` db\_users
(يتم تحويل تلقائيا إلى CamelCase lower\_case\_underscore.) من هناك،
يمكنك صقل الطبقة الطفل الذي يمثل الجدول مع خصائص فئة مختلفة مثل :

    // Table prefix, if applicable
    protected $prefix = null;

    // Primary ID, if applicable, defaults to 'id'
    protected $primaryId = 'id';

    // Whether the table is auto-incrementing or not
    protected $auto = true;

    // Whether to use prepared statements or not, defaults to true
    protected $usePrepared = true;

إذا كنت ضمن مشروع منظم يحتوي على قاعدة بيانات تعريف محول، ثم المكون سجل
تختار أن تصل واستخدامها. ومع ذلك، إذا كنت تكتب ببساطة بعض الكتابات
السريع باستخدام المكون سجل، فإنك سوف تحتاج لمعرفة ما الذي محول لاستخدام
قاعدة البيانات:

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

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
