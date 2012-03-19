Pop PHP Framework
=================

Documentation : Cli
-------------------

コマンドラインインターフェイス（CLI）のコンポーネントを使用するなどのいくつかの有用なタスクを実行することができ非常に便利なコンポーネントです。


* 必要な依存関係のために現在の環境を評価する
</li>
* プロジェクトのインストールファイルからプロジェクトをインストールする
</li>
* アプリケーションのデフォルトの言語を設定する
</li>
* クラスマップを作成する
</li>
* 再移動されているプロジェクト
</li>
* 利用可能な最新のバージョンに対して現在のバージョンを確認
</li>

<pre>
script/pop --check                     // Check the current configuration for required dependencies
script/pop --help                      // Display this help
script/pop --install file.php          // Install a project based on the install file specified
script/pop --lang fr                   // Set the default language for the project
script/pop --map folder file.php       // Create a class map file from the source folder and save to the output file
script/pop --reconfig projectfolder    // Reconfigure the project based on the new location of the project
script/pop --show                      // Show project install instructions
script/pop --version                   // Display version of Pop PHP Framework and latest available
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
