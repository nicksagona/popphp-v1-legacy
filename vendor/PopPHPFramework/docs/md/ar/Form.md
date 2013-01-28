Pop PHP Framework
=================

Documentation : Form
--------------------

Home

Ø§Ù„Ø¹Ù†ØµØ± Ù‡Ùˆ Ø¹Ù†ØµØ± Ù†Ù…ÙˆØ°Ø¬ Ø§Ù„Ù‚ÙˆÙŠØ© Ø§Ù„ØªÙŠ ØªÙ…ØªØ¯
Ø§Ù„Ù…ÙƒÙˆÙ† Ø¯ÙˆÙ…. Ù?Ø¥Ù†Ù‡ ÙŠÙˆÙ?Ø± ÙˆØ¸Ø§Ø¦Ù? Ù‚ÙˆÙŠØ© Ù„Ø®Ù„Ù‚ØŒ
Ø£Ùˆ Ø£Ù† ØªØµØ¨Ø­ ÙˆØ§Ù„ØªØ­Ù‚Ù‚ Ù…Ù† ØµØ­Ø© HTML Ø£Ø´ÙƒØ§Ù„
ÙˆØ¹Ù†Ø§ØµØ± Ø§Ù„Ù†Ù…ÙˆØ°Ø¬.

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

Ø£ÙˆØŒ ÙŠÙ…ÙƒÙ†Ùƒ Ø¥Ù†Ø´Ø§Ø¡ Ø¹Ù†Ø§ØµØ± Ø§Ù„Ù†Ù…ÙˆØ°Ø¬ Ø¹Ù† Ø·Ø±ÙŠÙ‚
Ù…Ø¬Ù…ÙˆØ¹Ø© Ù…Ù†Ø¸Ù…Ø© Ù…Ù† Ø§Ù„Ù‚ÙŠÙ….

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

Ù…Ø¹ Ø§Ù„Ø·Ø¨Ù‚Ø© Ø§Ù„Ø­Ù‚ÙˆÙ„ØŒ ÙŠÙ…ÙƒÙ†Ùƒ Ø§Ø³ØªØ®Ø¯Ø§Ù… Ø¬Ø¯ÙˆÙ„
Ù‚Ø§Ø¹Ø¯Ø© Ø¨ÙŠØ§Ù†Ø§Øª Ù…Ù† Ø®Ù„Ø§Ù„ Ø¹Ù†ØµØ± Ù„Ù„ÙˆØµÙˆÙ„ Ø¥Ù„Ù‰
Ø³Ø¬Ù„ ÙˆØ¨Ù†Ø§Ø¡ Ø§Ù„Ø­Ù‚ÙˆÙ„ Ø§Ù„Ø£ÙˆÙ„ÙŠØ© Ù…Ù† Ø§Ù„Ù†Ù…ÙˆØ°Ø¬.

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
