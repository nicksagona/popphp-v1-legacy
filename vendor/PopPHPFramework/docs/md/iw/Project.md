Pop PHP Framework
=================

Documentation : Project
-----------------------

Home

×ž×¨×›×™×‘ ×”×¤×¨×•×™×§×˜ ×ž×›×™×œ ×›×™×ª×ª ×¤×¨×•×™×§×˜ ×©×‘×• ×?×ª×”
×™×›×•×œ ×œ×”×¨×—×™×‘ ×•×œ×ª×ž×¦×ª ×ž×¤×¨×˜×™×? ×©×œ ×”×™×™×©×•×ž×™×?
×©×œ×š, ×›×’×•×Ÿ × ×ª×‘, ×‘×§×¨×™×?, ×ž×¡×“×™ × ×ª×•× ×™×?
×•×ž×•×“×•×œ×™×?. ×¤×¢×?, ×”×•×’×“×¨ ×›×¨×?×•×™, ×”×¤×¨×•×™×§×˜ ×™×›×•×œ
"×œ×¨×•×¥" ×•×œ× ×ª×‘ ×?×ª ×‘×§×©×ª×• ×©×œ ×”×ž×©×ª×ž×© ×œ×?×–×•×¨ ×”×
×›×•×Ÿ ×©×œ ×”×™×™×©×•×? ×©×œ×š ×‘×”×¦×œ×—×”. ×¦×¤×” ×‘×§×•×‘×¥ doc
×¨×›×™×‘ MVC ×›×“×™ ×œ×¨×?×•×ª ×“×•×’×ž×” ×©×œ ×§×•×‘×¥ ×ž×—×œ×§×ª
×¤×¨×•×™×§×˜ ×ž×•×¨×—×‘.

×›×ž×• ×›×Ÿ, ×ž×¨×›×™×‘ ×”×¤×¨×•×™×§×˜ ×ž×›×™×œ ×?×ª ×”×©×™×¢×•×¨×™×?
×©×”×ª×§× ×ª ×¨×›×™×‘ CLI ×ž×©×ª×ž×© ×›×“×™ ×œ×‘× ×•×ª ×•×œ×”×ª×§×™×Ÿ
×¤×™×’×•×ž×™ ×”×¤×¨×•×™×§×˜ ×©×œ×š. ×“×•×’×ž×” ×œ×§×•×‘×¥ ×ª×¦×•×¨×ª
×”×ª×§× ×ª ×¤×¨×•×™×§×˜ ×‘×”×ž×©×š.

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

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
