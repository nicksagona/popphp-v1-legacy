Pop PHP Framework
=================

Documentation : Form
--------------------

Home

Ð¤Ð¾Ñ€Ð¼Ð° ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚ Ñ?Ð²Ð»Ñ?ÐµÑ‚Ñ?Ñ? Ð¼Ð¾Ñ‰Ð½Ñ‹Ð¼
ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚Ð¾Ð¼, ÐºÐ¾Ñ‚Ð¾Ñ€Ñ‹Ð¹ Ñ€Ð°Ñ?ÑˆÐ¸Ñ€Ñ?ÐµÑ‚
ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚ Dom. ÐžÐ½Ð° Ð¾Ð±ÐµÑ?Ð¿ÐµÑ‡Ð¸Ð²Ð°ÐµÑ‚ Ð½Ð°Ð´ÐµÐ¶Ð½ÑƒÑŽ
Ñ„ÑƒÐ½ÐºÑ†Ð¸Ð¾Ð½Ð°Ð»ÑŒÐ½Ð¾Ñ?Ñ‚ÑŒ Ð´Ð»Ñ? Ñ?Ð¾Ð·Ð´Ð°Ð½Ð¸Ñ?,
Ð²Ð¸Ð·ÑƒÐ°Ð»Ð¸Ð·Ð°Ñ†Ð¸Ð¸ Ð¸ Ð¿Ñ€Ð¾Ð²ÐµÑ€ÐºÐ¸ HTML-Ñ„Ð¾Ñ€Ð¼ Ð¸
Ñ?Ð»ÐµÐ¼ÐµÐ½Ñ‚Ð¾Ð² Ñ„Ð¾Ñ€Ð¼Ñ‹.

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

Ð˜Ð»Ð¸, Ð²Ñ‹ Ð¼Ð¾Ð¶ÐµÑ‚Ðµ Ñ?Ð¾Ð·Ð´Ð°Ñ‚ÑŒ Ñ?Ð»ÐµÐ¼ÐµÐ½Ñ‚Ñ‹ Ñ„Ð¾Ñ€Ð¼Ñ‹ Ñ?
Ð¿Ð¾Ð¼Ð¾Ñ‰ÑŒÑŽ Ñ?Ñ‚Ñ€ÑƒÐºÑ‚ÑƒÑ€Ð¸Ñ€Ð¾Ð²Ð°Ð½Ð½Ð¾Ð³Ð¾ Ð¼Ð°Ñ?Ñ?Ð¸Ð²Ð°
Ð·Ð½Ð°Ñ‡ÐµÐ½Ð¸Ð¹.

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

Ð¡ Ð¿Ð¾Ð»ÐµÐ¹ ÐºÐ»Ð°Ñ?Ñ?Ð°, Ð²Ñ‹ Ð¼Ð¾Ð¶ÐµÑ‚Ðµ Ð¸Ñ?Ð¿Ð¾Ð»ÑŒÐ·Ð¾Ð²Ð°Ñ‚ÑŒ
Ñ‚Ð°Ð±Ð»Ð¸Ñ†Ñ‹ Ð±Ð°Ð·Ñ‹ Ð´Ð°Ð½Ð½Ñ‹Ñ… Ñ? Ð¿Ð¾Ð¼Ð¾Ñ‰ÑŒÑŽ
ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚Ð° Ð·Ð°Ð¿Ð¸Ñ?Ð¸ Ð´Ð»Ñ? Ð´Ð¾Ñ?Ñ‚ÑƒÐ¿Ð° Ð¸
Ñ?Ð¾Ð·Ð´Ð°Ð½Ð¸Ñ? Ð½Ð°Ñ‡Ð°Ð»ÑŒÐ½Ð¾Ð³Ð¾ Ð¿Ð¾Ð»Ñ? Ñ„Ð¾Ñ€Ð¼Ñ‹.

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
