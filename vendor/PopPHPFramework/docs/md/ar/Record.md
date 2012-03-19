Pop PHP Framework
=================

Documentation : Record
----------------------

المكون سجل، على النحو المبين في وثائق عامة، هو "مختلطة" من نوع ما بين السجل النشط وأنماط الجدول بوابة بيانات. عبر API موحدة، يمكن أن توفر فرص الحصول على صف واحد أو سجل في جدول قاعدة بيانات، أو عدة صفوف أو سجلات في آن واحد. النهج الأكثر شيوعا هو كتابة فئة الأطفال التي تمتد الطبقة السجل الذي يمثل الجدول في قاعدة البيانات. يجب أن يكون اسم الطبقة طفل يكون اسم الجدول. من خلال خلق ببساطة

<pre>
use Pop\Record\Record;

class Users extends Record { }
</pre>

يمكنك إنشاء فئة التي لديها كل من وظائف المكون سجل بنيت في والطبقة يعرف اسم جدول قاعدة البيانات للاستعلام عن اسم الفئة. على سبيل المثال، يترجم "المستخدمين إلى المستخدمين` `أو يترجم 'DbUsers' الى` db_users `(يتم تحويلها تلقائيا إلى CamelCase lower_case_underscore.) من هناك، يمكنك صقل فئة الطفل الذي يمثل الجدول مع خصائص فئة مختلفة مثل :

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

من هناك، واستخدام الأساسية هي كما يلي:

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
