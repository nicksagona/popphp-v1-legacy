Pop PHP Framework
=================

Documentation : Db
------------------

Home

DB组件提供了标准化的查询数据库的访问。支持的适配器：

-   mysql
-   mysqli
-   oracle
-   pdo
-   pgsql
-   sqlite
-   sqlsrv

支持预处理语句的mysqli，甲骨文，PDO时，PostgreSQL，SQLite和SQLSRV适配器。转义的值是适用于所有适配器。

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

除了数据库访问，DB组件还设有一个有用的的SQL抽象对象，帮助您在创建标准化的SQL查询。

    use Pop\Db\Db;
    use Pop\Db\Sql;

    $db = Db::factory('Sqlite', array('database' => 'mydb.sqlite'));

    $sql = new Sql($db, 'users');
    $sql->select()
        ->where()->equalTo('id', 1);

    // Outputs 'SELECT * FROM `users` WHERE `id` = 1'
    echo $sql;

中列出的文档概述，记录类，是一种“混合”的各种活动记录表网关模式之间的。通过标准化的API，它可以提供一个单一的行或记录在一个数据库中的表或多个行或记录一次。最常用的方法是写一个子类，扩展类，它代表一个数据库中的表的记录。子类的名称应该是表的名称。通过简单的创建：

    use Pop\Db\Record;

    class Users extends Record { }

您可以创建一个类，它具有所有功能的记录类和类知道的类名来查询数据库中的表的名称。例如，'用户'转化为'用户'或'DbUsers'转化为'db_users（驼峰被自动转换成lower_case_underscore）。从那里，你可以精细调整的子类，它代表了不同的类属性，如表：

    // Table prefix, if applicable
    protected $prefix = null;

    // Primary ID, if applicable, defaults to 'id'
    protected $primaryId = 'id';

    // Whether the table is auto-incrementing or not
    protected $auto = true;

    // Whether to use prepared statements or not, defaults to true
    protected $usePrepared = true;

如果你在一个结构化的项目，有一个定义的数据库适配器，然后将选择的记录类，并使用它。但是，如果你仅仅是写一些简单的脚本，使用记录组件，那么你需要告诉它的数据库适配器使用：

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

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
