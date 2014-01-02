Pop PHP Framework
=================

Documentation : Form
--------------------

Home

L'élément du formulaire est un composant puissant qui étend la
composante Dom. Il offre des fonctionnalités robustes pour créer,
afficher et valider les formulaires HTML et des éléments de formulaire.

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

Ou, vous pouvez créer des éléments de formulaire via un réseau structuré
de valeurs.

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

Avec la classe Champs, vous pouvez utiliser une table de base de données
via le composant enregistrement d'accès et de construire les champs
initiaux de la forme.

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
