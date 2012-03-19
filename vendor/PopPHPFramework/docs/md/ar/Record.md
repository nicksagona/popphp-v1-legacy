Pop PHP Framework
=================

Documentation : Record
----------------------

المكون سجل، على النحو المبين في وثائق عامة، هو "مختلطة" من نوع ما بين السجل النشط وأنماط الجدول بوابة بيانات. عبر API موحدة، يمكن أن توفر فرص الحصول على صف واحد أو سجل في جدول قاعدة بيانات، أو عدة صفوف أو سجلات في آن واحد. النهج الأكثر شيوعا هو كتابة فئة الأطفال التي تمتد الطبقة السجل الذي يمثل الجدول في قاعدة البيانات. يجب أن يكون اسم الطبقة طفل يكون اسم الجدول. من خلال خلق ببساطة


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
