Pop PHP Framework
=================

Documentation : Project
-----------------------

プロジェクトのコンポーネントを使用すると、ルータなど、コントローラ、データベース、およびモジュールなどのアプリケーションの仕様を拡張し、カプセル化することができるプロジェクトのクラスが含まれています。一度、正しく設定され、プロジェクトは、 "実行"することができ、正常にアプリケーションの正しい領域にユーザーの要求をルーティングします。拡張されたプロジェクトのクラスファイルの例を参照してMVCコンポーネントdocファイルを表示します。

また、プロジェクトのコンポーネントは、CLIコンポーネントがプロジェクトの足場を構築してインストールするために使用するインストールクラスが含まれています。プロジェクトのインストール設定ファイルの例は以下の通りです。

<pre>
&lt;?php
return new Pop\Config(array(
    'project' => array(
        'name'    => 'HelloWorld',
        'base'    => __DIR__ . '/../../',
        'docroot' => __DIR__ . '/../../public'
    ),
    'databases' => array(
        'helloworld' => array(
            'type'     => 'Mysqli',
            'database' => 'helloworld',
            'host'     => 'localhost',
            'username' => 'hello',
            'password' => '12world34',
            'prefix'   => 'pop_',
            'default'  => true
        )
    ),
    'forms' => array(
        'login' => array(
            'fields' => array(
                array(
                    'type'       => 'text',
                    'name'       => 'username',
                    'label'      => 'Username:',
                    'required'   => true,
                    'attributes' => array('size', 40),
                    'validators' => 'AlphaNumeric()'
                ),
                array(
                    'type'       => 'password',
                    'name'       => 'password',
                    'label'      => 'Password:',
                    'required'   => true,
                    'attributes' => array('size', 40),
                    'validators' => array('NotEmpty()', 'LengthGt(6)')
                ),
                array(
                    'type'       => 'submit',
                    'name'       => 'submit',
                    'value'      => 'LOGIN'
                )
            )
        )
    ),
    'controllers' => array(
        'default' => array(
            'index' => 'index.phtml',
            'error' => 'error.phtml'
        ),
        'admin' => array(
            'index' => 'index.phtml',
            'error' => 'error.phtml'
        )
    )
));
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
