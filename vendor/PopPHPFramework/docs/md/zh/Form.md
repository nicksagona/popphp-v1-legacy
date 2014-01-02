Pop PHP Framework
=================

Documentation : Form
--------------------

Home

表单组件是一个功能强大的组件，扩展了DOM组件。它提供了强大的功能来创建，呈现和验证HTML表格和表格元素。

    use Pop\Form\Form,
        Pop\Form\Element,
        Pop\Validator;

    $form = new Form($_SERVER['PHP_SELF'], 'post', null, '    ');

    $username = new Element('text', 'username', 'Username here...');
    $username->setLabel('Username:')
             ->setRequired(true)
             ->setAttributes('size', 40)
             ->addValidator(new Validator\AlphaNumeric());

    $email = new Element('text', 'email');
    $email->setLabel('Email:')
          ->setRequired(true)
          ->setAttributes('size', 40)
          ->addValidator(new Validator\Email());

    $password = new Element('password', 'password');
    $password->setLabel('Password:')
             ->setRequired(true)
             ->setAttributes('size', 40)
             ->addValidator(new Validator\LengthGt(6));

    $checkbox = new Element\Checkbox('colors', array('Red' => 'Red', 'Green' => 'Green', 'Blue' => 'Blue'));
    $checkbox->setLabel('Colors:');

    $radio = new Element\Radio('answer', array('Yes' => 'Yes', 'No' => 'No', 'Maybe' => 'Maybe'));
    $radio->setLabel('Answer:');

    $select = new Element\Select('days', Element\Select::DAYS_OF_WEEK);
    $select->setLabel('Day:');

    $textarea = new Element\Textarea('comments', 'Please type a comment...');
    $textarea->setAttributes('rows', '5')
             ->setAttributes('cols', '40')
             ->setLabel('Comments:');

    $submit = new Element('submit', 'submit', 'SUBMIT');
    $submit->setAttributes('style', 'padding: 5px; border: solid 2px #000;');

    $form->addElements(array(
        $username,
        $email,
        $password,
        $checkbox,
        $radio,
        $select,
        $textarea,
        $submit
    ));

    if ($_POST) {
        $form->setFieldValues($_POST);
        if (!$form->isValid()) {
            $form->render();
        } else {
            echo 'Form is valid.';
        }
    } else {
        $form->render();
    }

或者，您可以创建一个结构化的表单元素通过数组的值。

    use Pop\Form\Form,
        Pop\Form\Element,
        Pop\Validator;

    $fields = array(
        'username' => array(
            'type'       => 'text',
            'value'      => 'Username here...',
            'label'      => 'Username:',
            'required'   => true,
            'attributes' => array('size' => 40),
            'validators' => new Validator&#92;AlphaNumeric()
        ),
        'email' => array(
            'type'       => 'text',
            'label'      => 'Email:',
            'required'   => true,
            'attributes' => array('size' => 40),
            'validators' => new Validator&#92;Email()
        ),
        'password' => array(
            'type'       => 'password',
            'label'      => 'Password:',
            'required'   => true,
            'attributes' => array('size' => 40),
            'validators' => new Validator&#92;LengthGt(6)
        ),
        'colors' => array(
            'type'       => 'checkbox',
            'label'      => 'Colors:',
            'value'      => array('Red' => 'Red', 'Green' => 'Green', 'Blue' => 'Blue')
        ),
        'submit' => array(
            'type'       => 'submit',
            'value'      => 'SUBMIT',
            'attributes' => array('style' => 'padding: 5px; border: solid 2px #000;')
        )
    );

    $form = new Form($_SERVER['PHP_SELF'], 'post', $fields, '    ');
    $form->setTemplate('form.phtml');

    if ($_POST) {
        $form->setFieldValues($_POST);
        if (!$form->isValid()) {
            $form->render();
        } else {
            echo 'Form is valid.';
        }
    } else {
        $form->render();
    }

的字段类，你可以使用一个数据库表，通过记录组件访问的形式，并建立初始场。

    use Pop\Form\Form,
        Pop\Form\Fields,
        Pop\Form\Element,
        Pop\Record\Record;

    class Users extends Record { }

    class User extends Form { }

    $attribs = array(
        'text'     => array('size' => 40),
        'password' => array('size' => 20),
        'textarea' => array('rows' => 5, 'cols' => 80)
    );

    $values = array(
        'id' => array(
            'type' => 'hidden'
        )
    );

    // The last parameter is an array of fields from the DB table to omit
    $fields = Fields::factory(
        new Users(),
        $attribs,
        $values,
        array('last_login', 'last_ua', 'last_ip', 'failed_attempts')
    );

    $fields->addFields(array(
        'submit' => array(
            'type'  => 'submit',
            'label' => '&nbsp;',
            'value' => 'SUBMIT',
        )
    );

    $form = new User($_SERVER['REQUEST_URI'], 'post', $fields->getFields());

    if ($_POST) {
        $form->setFieldValues($_POST);
        if ($form->isValid()) {
            echo 'Form is valid!';
        } else {
            $form->render();
        }
    } else {
        $form->render();
    }

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
