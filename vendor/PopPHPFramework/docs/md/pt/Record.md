Pop PHP Framework
=================

Documentation : Record
----------------------

Home

O componente Record, como descrito na visÃ£o geral da documentaÃ§Ã£o, Ã©
um "hÃ­brido" das sortes entre o Active Record e padrÃµes de tabela de
dados Gateway. AtravÃ©s de uma API padronizada, pode fornecer acesso a
uma Ãºnica linha ou registro dentro de uma tabela de banco de dados, ou
vÃ¡rias linhas ou registros de uma vez. A abordagem mais comum Ã©
escrever uma classe filha que estende a classe Record que representa uma
tabela no banco de dados. O nome da classe crianÃ§a deve ser o nome da
tabela. Simplesmente criando

    use Pop\Record\Record;

    class Users extends Record { }

vocÃª criar uma classe que tem todas as funcionalidades do componente
construÃ­do em Registro e da classe sabe o nome da tabela de banco de
dados para consulta a partir do nome da classe. Por exemplo, se traduz
'UsuÃ¡rios' em \`usuÃ¡rios\` ou 'traduz DbUsers' em \`db\_users\`
(CamelCase Ã© automaticamente convertido em lower\_case\_underscore.) De
lÃ¡, vocÃª pode ajustar a classe filha que representa a tabela com as
propriedades da classe diversos, tais como :

    // Table prefix, if applicable
    protected $prefix = null;

    // Primary ID, if applicable, defaults to 'id'
    protected $primaryId = 'id';

    // Whether the table is auto-incrementing or not
    protected $auto = true;

    // Whether to use prepared statements or not, defaults to true
    protected $usePrepared = true;

Se vocÃª estÃ¡ dentro de um projeto estruturado, que tem um adaptador de
banco de dados definido, entÃ£o a componente Record serÃ¡ pegar isso e
usÃ¡-lo. No entanto, se vocÃª estÃ¡ simplesmente escrever alguns scripts
rÃ¡pidos usando o componente Record, entÃ£o vocÃª precisa dizer a ele
qual adaptador de banco de dados para usar:

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

A partir daÃ­, a utilizaÃ§Ã£o de base Ã© a seguinte:

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
