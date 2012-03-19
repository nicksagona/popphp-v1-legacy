Pop PHP Framework
=================

Documentation : Project
-----------------------

مكون المشروع يحتوي على فئة المشروع الذي يمكنك توسيع وتغليف مواصفات التطبيق الخاص بك، مثل جهاز التوجيه، وأجهزة التحكم وقواعد البيانات والوحدات. مرة واحدة، التي أنشئت بشكل صحيح، يمكن لمشروع "تشغيل" والطريق بنجاح طلب المستخدم إلى المكان الصحيح لطلبك. عرض ملف MVC ثيقة مكون لرؤية مثال لملف المشروع فئة الموسعة.

أيضا، المكون المشروع يحتوي على فصول تثبيت هذا العنصر CLI يستخدم لبناء وتركيب السقالات المشروع الخاص بك. مثال على تكوين ملف المشروع تركيب أقل.

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

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
