Pop PHP Framework
=================

Documentation : Record
----------------------

としてのドキュメントの概要で説明されているレコードのコンポーネントは、Active Recordのとテーブルデータゲートウェイパターンの間にある種の "ハイブリッド"です。標準化されたAPIを介して、それが一度にデータベーステーブル内の単一の行またはレコードへのアクセス、または複数の行またはレコードを提供することができます。最も一般的なアプローチは、データベース内のテーブルを表すレコードクラスを拡張子クラスを作成することです。子クラスの名前は、テーブルの名前でなければなりません。単に作成することにより、


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

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
