Pop PHP Framework
=================

Documentation : Project
-----------------------

Home

O componente do projeto contém a classe de projetos em que você pode
estender e encapsular as especificações de sua aplicação, como o
roteador, controladores, bancos de dados e módulos. Uma vez, configurado
corretamente, o projeto pode "correr" e com sucesso encaminhe a
solicitação do usuário para a área correta de sua aplicação. Ver o
componente Mvc arquivo doc para ver um exemplo de um arquivo de extensão
Projeto classe.

Além disso, o componente de projeto contém as classes de instalação que
o componente CLI usa para construir e instalar o andaime projeto. Um
exemplo de um arquivo de configuração do projeto de instalação está
abaixo.

    <?php
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
            '/' => array(
                'index' => 'index.phtml',
                'error' => 'error.phtml'
            ),
            '/admin' => array(
                'index' => 'index.phtml',
                'error' => 'error.phtml'
            )
        )
    ));

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
