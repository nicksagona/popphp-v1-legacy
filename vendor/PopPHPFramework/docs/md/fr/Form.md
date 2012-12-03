Pop PHP Framework
=================

Documentation : Form
--------------------

La composante formulaire est un composant puissant qui étend la composante Dom. Il offre des fonctionnalités robustes pour créer, rendre et valides des formulaires HTML et les éléments de formulaire.

<pre>
use Pop\Form\Form,
    Pop\Form\Element,
    Pop\Form\Element\Checkbox,
    Pop\Form\Element\Radio,
    Pop\Form\Element\Select,
    Pop\Form\Element\Textarea,
    Pop\Validator\Validator,
    Pop\Validator\Validator\AlphaNumeric,
    Pop\Validator\Validator\Email,
    Pop\Validator\Validator\LengthGt;

$form = new Form($_SERVER['PHP_SELF'], 'post', null, '    ');

$username = new Element('text', 'username', 'Username here...');
$username->setLabel('Username:')
         ->setRequired(true)
         ->setAttributes('size', 40)
         ->addValidator(new AlphaNumeric());

$email = new Element('text', 'email');
$email->setLabel('Email:')
      ->setRequired(true)
      ->setAttributes('size', 40)
      ->addValidator(new Email());

$password = new Element('password', 'password');
$password->setLabel('Password:')
         ->setRequired(true)
         ->setAttributes('size', 40)
         ->addValidator(new LengthGt(6));

$checkbox = new Checkbox('colors', array('Red' => 'Red', 'Green' => 'Green', 'Blue' => 'Blue'));
$checkbox->setLabel('Colors:');

$radio = new Radio('answer', array('Yes' => 'Yes', 'No' => 'No', 'Maybe' => 'Maybe'));
$radio->setLabel('Answer:');

$select = new Select('days', Select::DAYS_OF_WEEK);
$select->setLabel('Day:');

$textarea = new Textarea('comments', 'Please type a comment...');
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
</pre>

Ou, vous pouvez créer des éléments de formulaire via un réseau structuré de valeurs.

<pre>
use Pop\Form\Form,
    Pop\Form\Element,
    Pop\Form\Element\Checkbox,
    Pop\Form\Element\Radio,
    Pop\Form\Element\Select,
    Pop\Form\Element\Textarea,
    Pop\Validator\Validator,
    Pop\Validator\Validator\AlphaNumeric,
    Pop\Validator\Validator\Email,
    Pop\Validator\Validator\LengthGt;

$fields = array(
    array(
        'type'       => 'text',
        'name'       => 'username',
        'value'      => 'Username here...',
        'label'      => 'Username:',
        'required'   => true,
        'attributes' => array('size', 40),
        'validators' => new AlphaNumeric()
    ),
    array(
        'type'       => 'text',
        'name'       => 'email',
        'label'      => 'Email:',
        'required'   => true,
        'attributes' => array('size', 40),
        'validators' => new Email()
    ),
    array(
        'type'       => 'password',
        'name'       => 'password',
        'label'      => 'Password:',
        'required'   => true,
        'attributes' => array('size', 40),
        'validators' => new LengthGt(6)
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
</pre>

Avec la classe Champs, vous pouvez utiliser une table de base de données via le composant enregistrement d'accès et de construire les champs initiaux de la forme.

<pre>
use Pop\Form\Form,
    Pop\Form\Fields,
    Pop\Form\Element,
    Pop\Record\Record;

class Users extends Record { }

class User extends Form { }

try {
    $attribs = array(
        'text'     =&gt; array('size', 40),
        'password' =&gt; array('size', 20),
        'textarea' =&gt; array(array('rows', 5), array('cols', 80))
    );

    $values = array(
        'id' =&gt; array(
            'type' =&gt; 'hidden'
        )
    );

    $fields = Fields::factory(
        new Users(),
        $attribs,
        $values,
        array('last_login', 'last_ua', 'last_ip', 'failed_attempts')
    );

    $fields-&gt;addFields(array(
        'type'  =&gt; 'submit',
        'name'  =&gt; 'submit',
        'label' =&gt; '&nbsp;',
        'value' =&gt; 'SUBMIT',
    ));

    $form = new User($_SERVER['REQUEST_URI'], 'post', $fields-&gt;getFields());

    if ($_POST) {
        $form-&gt;setFieldValues($_POST);
        if ($form-&gt;isValid()) {
            echo 'Form is valid!';
        } else {
            $form-&gt;render();
        }
    } else {
        $form-&gt;render();
    }
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
