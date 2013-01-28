Pop PHP Framework
=================

Documentation : Form
--------------------

Home

Î¤Î¿ ÏƒÏ…ÏƒÏ„Î±Ï„Î¹ÎºÏŒ Î­Î½Ï„Ï…Ï€Î¿ ÎµÎ¯Î½Î±Î¹ Î­Î½Î± Î¹ÏƒÏ‡Ï…Ï?ÏŒ
ÏƒÏ…ÏƒÏ„Î±Ï„Î¹ÎºÏŒ Ï€Î¿Ï… ÎµÏ€ÎµÎºÏ„ÎµÎ¯Î½ÎµÎ¹ Ï„Î¿ ÏƒÏ„Î¿Î¹Ï‡ÎµÎ¯Î¿
Dom. Î Î±Ï?Î­Ï‡ÎµÎ¹ Î¹ÏƒÏ‡Ï…Ï?Î® Î»ÎµÎ¹Ï„Î¿Ï…Ï?Î³Î¹ÎºÏŒÏ„Î·Ï„Î± Î³Î¹Î±
Ï„Î· Î´Î·Î¼Î¹Î¿Ï…Ï?Î³Î¯Î±, Ï„Î·Î½ Î±Ï€ÏŒÎ´Î¿ÏƒÎ· ÎºÎ±Î¹ Ï„Î·Î½
ÎµÏ€Î¹ÎºÏ?Ï?Ï‰ÏƒÎ· HTML Ï†ÏŒÏ?Î¼ÎµÏ‚ ÎºÎ±Î¹ ÏƒÏ„Î¿Î¹Ï‡ÎµÎ¯Î±
Ï†ÏŒÏ?Î¼Î±Ï‚.

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
    $submit->setAttributes('style', 'padding: 5px; border: solid 2px #000; background-color: #00f; color: #fff; font-weight: bold;');

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

Î‰, Î¼Ï€Î¿Ï?ÎµÎ¯Ï„Îµ Î½Î± Î´Î·Î¼Î¹Î¿Ï…Ï?Î³Î®ÏƒÎµÏ„Îµ ÏƒÏ„Î¿Î¹Ï‡ÎµÎ¯Î±
Î¼Î¿Ï?Ï†Î® Î¼Î­ÏƒÏ‰ Î¼Î¹Î±Ï‚ Î´Î¿Î¼Î·Î¼Î­Î½Î·Ï‚ Ï€Î¯Î½Î±ÎºÎ± Ï„Î¹Î¼ÏŽÎ½.

    use Pop\Form\Form,
        Pop\Form\Element,
        Pop\Validator;

    $fields = array(
        array(
            'type'       => 'text',
            'name'       => 'username',
            'value'      => 'Username here...',
            'label'      => 'Username:',
            'required'   => true,
            'attributes' => array('size', 40),
            'validators' => new Validator\AlphaNumeric()
        ),
        array(
            'type'       => 'text',
            'name'       => 'email',
            'label'      => 'Email:',
            'required'   => true,
            'attributes' => array('size', 40),
            'validators' => new Validator\Email()
        ),
        array(
            'type'       => 'password',
            'name'       => 'password',
            'label'      => 'Password:',
            'required'   => true,
            'attributes' => array('size', 40),
            'validators' => new Validator\LengthGt(6)
        ),
        array(
            'type'       => 'checkbox',
            'name'       => 'colors',
            'label'      => 'Colors:',
            'value'      => array('Red' => 'Red', 'Green' => 'Green', 'Blue' => 'Blue')
        ),
        array(
            'type'       => 'submit',
            'name'       => 'submit',
            'value'      => 'SUBMIT',
            'attributes' => array('style', 'padding: 5px; border: solid 2px #000; background-color: #00f; color: #fff; font-weight: bold;')
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

ÎœÎµ Ï„Î·Î½ ÎºÎ±Ï„Î·Î³Î¿Ï?Î¯Î± Ï€ÎµÎ´Î¯Î±, Î¼Ï€Î¿Ï?ÎµÎ¯Ï„Îµ Î½Î±
Ï‡Ï?Î·ÏƒÎ¹Î¼Î¿Ï€Î¿Î¹Î®ÏƒÎµÏ„Îµ Î­Î½Î±Î½ Ï€Î¯Î½Î±ÎºÎ± Î²Î¬ÏƒÎ·Ï‚
Î´ÎµÎ´Î¿Î¼Î­Î½Ï‰Î½ Î¼Î­ÏƒÏ‰ Ï„Î¿Ï… ÏƒÏ„Î¿Î¹Ï‡ÎµÎ¯Î¿Ï… ÎµÎ³Î³Ï?Î±Ï†Î®Ï‚
Î³Î¹Î± Î½Î± Î­Ï‡Î¿Ï…Î½ Ï€Ï?ÏŒÏƒÎ²Î±ÏƒÎ· ÎºÎ±Î¹ Î½Î±
Î¿Î¹ÎºÎ¿Î´Î¿Î¼Î®ÏƒÎ¿Ï…Î¼Îµ Ï„Î¹Ï‚ Î±Ï?Ï‡Î¹ÎºÎ­Ï‚ Ï€ÎµÎ´Î¯Î± Ï„Î·Ï‚
Ï†ÏŒÏ?Î¼Î±Ï‚.

    use Pop\Form\Form,
        Pop\Form\Fields,
        Pop\Form\Element,
        Pop\Record\Record;

    class Users extends Record { }

    class User extends Form { }

    try {
        $attribs = array(
            'text'     => array('size', 40),
            'password' => array('size', 20),
            'textarea' => array(array('rows', 5), array('cols', 80))
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
            'type'  => 'submit',
            'name'  => 'submit',
            'label' => ' ',
            'value' => 'SUBMIT',
        ));

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

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
