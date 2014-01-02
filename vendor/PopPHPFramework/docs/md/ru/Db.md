Pop PHP Framework
=================

Documentation : Db
------------------

Home

Db компонент обеспечивает доступ к нормированной запросов к базам
данных. Поддерживаемых адаптеров являются:

-   mysql
-   mysqli
-   oracle
-   pdo
-   pgsql
-   sqlite
-   sqlsrv

Подготовленные заявления поддерживаются с MySQLi, Oracle, PDO,
PostgreSQL, SQLite и SQLSRV адаптеров. Сбежавший значения доступны для
всех адаптеров.

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

В дополнение к доступ к базе данных, Db компонент также имеет полезные
абстракции SQL объекта, который помогает вам в создании
стандартизированного SQL запросов.

    use Pop\Db\Db;
    use Pop\Db\Sql;

    $db = Db::factory('Sqlite', array('database' => 'mydb.sqlite'));

    $sql = new Sql($db, 'users');
    $sql->select()
        ->where()->equalTo('id', 1);

    // Outputs 'SELECT * FROM `users` WHERE `id` = 1'
    echo $sql;

Запись класса, как указано в документации описание, представляет собой «гибрид" сортов между Active Record и узоры Таблица Gateway. Через стандартизированные API, он может обеспечить доступ к одной строки или записи в таблице базы данных, или нескольких строк или записей сразу. Наиболее распространенный подход заключается в написании дочерний класс, который расширяет Record класса, который представляет собой таблицу в базе данных. Имя ребенку классе должно быть имя таблицы. Просто создания:

    use Pop\Db\Record;

    class Users extends Record { }

Вы создаете класс, который имеет все функциональные возможности Record класса построены в классе и знает имя таблицы базы данных для запросов от имени класса. Например, переводит "Пользователи" в `пользователи` или переводит "DbUsers 'в` db_users `(CamelCase автоматически преобразуются в lower_case_underscore). Оттуда вы можете подстроить ребенка класс, который представляет собой таблицу с различными свойствами класса, таких как :

    // Table prefix, if applicable
    protected $prefix = null;

    // Primary ID, if applicable, defaults to 'id'
    protected $primaryId = 'id';

    // Whether the table is auto-incrementing or not
    protected $auto = true;

    // Whether to use prepared statements or not, defaults to true
    protected $usePrepared = true;

Если вы в рамках структурированного проект, который имеет определенную базу данных адаптеров, то запись будет забрать класса, что и использовать его. Однако, если вы просто написав несколько быстрых сценариев с использованием компонента записи, то вы должны будете указать, какие базы данных адаптер для использования:

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

Оттуда, основное использование выглядит следующим образом:

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
