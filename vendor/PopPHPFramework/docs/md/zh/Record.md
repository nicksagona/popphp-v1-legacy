Pop PHP Framework
=================

Documentation : Record
----------------------

Home

中列出的文档概述，记录组件，是一种“混合”的类型之间的活动记录表数据网关模式。通过标准化的API，它可以提供一个单一的行或记录在一个数据库中的表或多个行或记录一次。最常用的方法是写一个子类，扩展类，它代表一个数据库中的表的记录。子类的名称应该是表的名称。通过简单的创建

    use Pop\Record\Record;

    class Users extends Record { }

您可以创建一个类，它具有记录的功能组件和类知道的类名来查询数据库中的表的名称。例如，'用户'转化为'用户'或'DbUsers'转化为'db\_users（驼峰被自动转换成lower\_case\_underscore）。从那里，你可以精细调整的子类，它代表了不同的类属性，如表：

    // Table prefix, if applicable
    protected $prefix = null;

    // Primary ID, if applicable, defaults to 'id'
    protected $primaryId = 'id';

    // Whether the table is auto-incrementing or not
    protected $auto = true;

    // Whether to use prepared statements or not, defaults to true
    protected $usePrepared = true;

如果你在一个结构化的项目，有一个定义的数据库适配器，然后将选择的记录组件，并使用它。但是，如果你仅仅是写一些简单的脚本，使用记录组件，那么你需要告诉它的数据库适配器使用：

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

从那里，基本用法如下：

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
