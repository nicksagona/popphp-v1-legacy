Pop PHP Framework
=================

Documentation : Record
----------------------

Home

としてドキュメント概要を説明してレコードの構成要素は、アクティブレコードとテーブルデータゲートウェイパターン間のある種の
"ハイブリッド"です。標準化されたAPIを介して、それが一度にデータベーステーブル内の単一の行またはレコードへのアクセス、または複数の行またはレコードを提供することができます。最も一般的なアプローチは、データベース内のテーブルを表すRecordクラスを拡張子クラスを記述することです。子クラスの名前は、表の名前でなければなりません。単に作成することにより、

    use Pop\Record\Record;

    class Users extends Record { }

あなたは、年に建設され、クラスはクラス名から照会するデータベーステーブルの名前を知っているレコードの構成要素のすべての機能を持つクラスを作成します。例えば、そこから
\`db\_users\`（キャメルケースが自動的lower\_case\_underscoreに変換されます。）に
\`ユーザ\`や 'DbUsers'変換中に
"ユーザー"変換は、次のような様々なクラスのプロパティを使用してテーブルを表す子クラスを微調整することができます：

    // Table prefix, if applicable
    protected $prefix = null;

    // Primary ID, if applicable, defaults to 'id'
    protected $primaryId = 'id';

    // Whether the table is auto-incrementing or not
    protected $auto = true;

    // Whether to use prepared statements or not, defaults to true
    protected $usePrepared = true;

使用して、定義済みのデータベースアダプタを持って構造化されたプロジェクト内にいる場合は、レコードの構成要素は、それを拾うと、それを使用します。しかし、あなたは、単にレコード·コンポーネントを使用して、いくつかの簡単なスクリプトを書いているなら、あなたは、どのデータベース·アダプタが使用するよう指示する必要があります：

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

そこから、基本的な使い方は以下の通りです：

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
