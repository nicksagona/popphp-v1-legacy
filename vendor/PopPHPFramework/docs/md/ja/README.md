Pop PHP Framework
=================

Documentation : Overview
------------------------

ポップPHPフレームワークを使用すると、幅広い機能を利用することができるようになり、使いやすいAPIを使用してオブジェクト指向のPHPフレームワークです。あなたはすぐに基本的なスクリプトを書くことを支援するためのツールボックスとして使用することができ、または、大規模で堅牢なアプリケーションを構築し、カスタマイズするための本格的なフレームワークとして使用することができます。フレームワークの中核となるのは、一部が独立して使用することができ、一部は活用するためにタンデムでフレームワークやPHPのフルパワーを使用することができる、のコンポーネントのグループです。


* Archive
* Auth
* Cache
* Cli
* Code
* Color
* Compress
* Config
* Curl
* Data
* Db
* Dir
* Dom
* Feed
* File
* Filter
* Font
* Form
* Ftp
* Geo
* Graph
* Http
* Image
* Loader
* Locale
* Mail
* Mvc
* Paginator
* Payment
* Pdf
* Project
* Record
* Validator
* Version
* Web

クイックスタート

----------

あなたが立ち上がってポップPHPフレームワークを使用して実行できる2つの方法があります。


あなただけのいくつかの簡単なスクリプトを記述しようとしている場合は、単に、作業プロジェクトフォルダにソースフォルダをドロップしてスクリプトに応じて "bootstrap.phpを '参照し、コードを書き始めることができます。すべてのさまざまなコンポーネントを説明し、この文書全体を通して、どのようにあなたがそれらを使用することができます参照し、例を見つけることができます。


If you're looking to build a larger-scale application, you can use the CLI component to create the project's base foundation, or scaffolding. This way, you can start writing project code quickly and not have to burdened with getting everything up and running. All you have to do is define your project in single installation file, run the Pop CLI command using that file and - voila! - Pop does all the dirty work for you and you can get to writing project code faster. Review the documentation on the CLI component to further explore how to take advantage of this robust component.

MVCコンポーネント

-----------------

大規模なアプリケーションを構築する際にMVCコンポーネントが利用可能で、特に便利です。 MVCは、Model-View-Controllerの略で、懸念の計画的な分離を容易にするデザインパターンです。それはあなたのプレゼンテーション、ビジネスロジックとデータアクセスは、すべて別々に保持することができます。


The controller receives input (i.e. a web request) from the user and based on that input, communicates that with the model. The model can then process the request to determine what data or response is needed. At that point, the model and view communicate so that the view can build the presentation, or view, based on the data obtained from the model. Then, the controller will communicate with the view to display the appropriate output to the user.

One extra piece of the MVC component that is available with the Pop PHP Framework is a router. The router is simply an additional layer on top that does exactly what its name suggests  it routes different types of user requests to their corresponding controllers. In other words, it provides an easy way to manage multiple user paths and controllers.

しばしば、それはあなたが実際にそれを使用して起動するまで、MVCデザインパターンを把握することが困難な場合があります。一度でも行うには、すぐに非常に小さな、もしあれば、重複した概念を管理するために簡単に分離し、すべてを持つことの利点を見ることができます。コントローラが要求の委任を処理し、モデルはビジネスロジックを処理し、ビューは、ユーザーに出力を表示する方法を決定します。はるかに、このパターンは切り札大きな混乱を作成するあらゆる場所に含まれており、単一のスクリプトや様々なスクリプトにすべてを詰め込むの昔を。ちょうどそれをしようとすると次のように表示されます！


DB＆レコードのコンポーネント

--------------------------

Dbとレコードのコンポーネントは、どのアプリケーションでもかなり使用される可能性を持つ2つのコンポーネントです。明らかに、DBコンポーネントは、データベースを照会するための直接アクセスを提供します。サポートされているアダプタは、ネイティブのMySQLには、MySQLi、PgSQLの、SQLiteとPDOが含まれています。彼らはあなたが別の環境でデータベースの別のタイプで動作するように再ツーリングアプリケーションに関する限り心配する必要はありませんように複数の異なる環境をまたがったデータベースへのアクセスを正規化するのに役立つ。


レコード·コンポーネントは、データベース内のデータ、特にデータベースのテーブルとテーブル内の個々のレコードへの標準化されたアクセスを提供する強力なコンポーネントです。レコードの構成要素は、本当にアクティブレコードとテーブルデータゲートウェイパターンのハイブリッドです。テーブルデータゲートウェイがあるかのように、それは、一度になり、または複数の行Active Recordパターンのような単一の行またはレコードへのアクセスを提供することができます。ポップPHPのフレームワークを使用した、最も一般的なアプローチは、データベース内のテーブルを表すレコードクラスを拡張子クラスを作成することです。子クラスの名前は、テーブルの名前でなければなりません。単に作成することにより、


<pre>
use Pop\Record\Record;

class Users extends Record { }
</pre>

you create a class that has all of the functionality of the Record component built in and the class knows the name of the database table to query from the class name. For example,  'Users' translates into `users` or 'DbUsers' translates into `db_users` (CamelCase is automatically converted into lower_case_underscore.) Review the Record documentation to see how you can fine tune the child table class.

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
