Pop PHP Framework
=================

Documentation : Record
----------------------

Home

Запись компоненты, как указано в документации описание, представляет
собой «гибрид" сортов между Active Record и таблица моделей данных
Gateway. Через стандартизированные API, он может обеспечить доступ к
одной строки или записи в таблице базы данных, или нескольких строк или
записей сразу. Наиболее распространенный подход заключается в написании
дочерний класс, который расширяет Record класса, который представляет
собой таблицу в базе данных. Имя ребенку классе должно быть имя таблицы.
Просто создавая

    use Pop\Record\Record;

    class Users extends Record { }

Вы создаете класс, который имеет все функциональные возможности
компонента записи построено в классе и знает имя таблицы базы данных для
запросов от имени класса. Например, переводит "Пользователи" в
\`пользователи\` или переводит "DbUsers 'в\` db\_users \`(CamelCase
автоматически преобразуются в lower\_case\_underscore). Оттуда вы можете
подстроить ребенка класс, который представляет собой таблицу с
различными свойствами класса, таких как :

    // Table prefix, if applicable
    protected $prefix = null;

    // Primary ID, if applicable, defaults to 'id'
    protected $primaryId = 'id';

    // Whether the table is auto-incrementing or not
    protected $auto = true;

    // Whether to use prepared statements or not, defaults to true
    protected $usePrepared = true;

Если вы в рамках структурированного проект, который имеет определенную
базу данных адаптеров, то запись компонента будет забрать, что до и
использовать его. Однако, если вы просто написав несколько быстрых
сценариев с использованием компонента записи, то вы должны будете
указать, какие базы данных адаптер для использования:

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

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
