Pop PHP Framework
=================

Documentation : Project
-----------------------

Home

أما عنصر المشروع يحتوي على الفئة المشروع الذي يمكنك توسيع وتغليف مواصفات
التطبيق الخاص بك، مثل جهاز التوجيه، وأجهزة التحكم وقواعد البيانات
والوحدات النمطية. مرة واحدة، إعداد بشكل صحيح، يمكن للمشروع "تشغيل"
والطريق بنجاح طلب المستخدم إلى المنطقة الصحيحة من التطبيق الخاص بك. عرض
الملف MVC ثيقة مكون لمشاهدة مثال من ملف مشروع فئة الموسعة.

أيضا، وعنصر من عناصر المشروع يحتوي على دروس تثبيت هذا المكون CLI يستخدم
لبناء وتثبيت السقالات المشروع. مثال على تكوين ملف المشروع هو تثبيت
أدناه.

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
