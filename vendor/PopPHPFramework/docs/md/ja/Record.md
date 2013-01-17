Pop PHP Framework
=================

Documentation : Record
----------------------

としてのドキュメントの概要で説明されているレコードのコンポーネントは、Active Recordのとテーブルデータゲートウェイパターンの間にある種の "ハイブリッド"です。標準化されたAPIを介して、それが一度にデータベーステーブル内の単一の行またはレコードへのアクセス、または複数の行またはレコードを提供することができます。最も一般的なアプローチは、データベース内のテーブルを表すレコードクラスを拡張子クラスを作成することです。子クラスの名前は、テーブルの名前でなければなりません。単に作成することにより、

<pre>
use Pop\Record\Record;

class Users extends Record { }
</pre>

あなたは、年に建てられ、クラスはクラス名からクエリを実行するデータベーステーブルの名前を知っているレコード·コンポーネントのすべての機能を持つクラスを作成します。たとえば、そこから `db_users`（キャメルケースは自動的にlower_case_underscoreに変換されます。）に `ユーザー`または 'DbUsers'変換に 'ユーザー'に変換するには、などのさまざまなクラスのプロパティを持つテーブルを表す子クラスを微調整することができます：

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

そこから、基本的な使い方は次のとおりです。

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

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
