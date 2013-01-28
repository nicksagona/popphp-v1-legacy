Pop PHP Framework
=================

Documentation : Form
--------------------

Home

è¡¨å?•ç»„ä»¶æ˜¯ä¸€ä¸ªåŠŸèƒ½å¼ºå¤§çš„ç»„ä»¶ï¼Œæ‰©å±•äº†DOMç»„ä»¶ã€‚å®ƒæ??ä¾›äº†å¼ºå¤§çš„åŠŸèƒ½æ?¥åˆ›å»ºï¼Œå‘ˆçŽ°å’ŒéªŒè¯?HTMLè¡¨æ
¼å’Œè¡¨æ ¼å…ƒç´ ã€‚

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

æˆ–è€…ï¼Œæ‚¨å?¯ä»¥åˆ›å»ºä¸€ä¸ªç»“æž„åŒ–çš„è¡¨å?•å…ƒç´
é€šè¿‡æ•°ç»„çš„å€¼ã€‚

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

çš„å­—æ®µç±»ï¼Œä½
å?¯ä»¥ä½¿ç”¨ä¸€ä¸ªæ•°æ?®åº“è¡¨ï¼Œé€šè¿‡è®°å½•ç»„ä»¶è®¿é—®çš„å½¢å¼?ï¼Œå¹¶å»ºç«‹åˆ?å§‹åœºã€‚

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
