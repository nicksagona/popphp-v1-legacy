Pop PHP Framework
=================

Documentation : Validator
-------------------------

La composante Validator fournit simplement une fonctionnalité de validation de nombreux cas d'utilisation différentes, telles que la validation ou non d'un nombre est d'une certaine valeur ou une chaîne est alphanumérique. Validateurs plus avancées sont disponibles aussi bien, comme la validation d'une adresse e-mail, et l'adresse IP ou un numéro de carte de crédit. Et, si ce dont vous avez besoin n'est pas disponible, de la composante peut être facilement étendu.

<pre>
use Pop\Validator\Validator,
    Pop\Validator\Validator\AlphaNumeric;

// Create an alphanumeric validator
$val = Validator::factory(new AlphaNumeric());

// Evaluate if the input value meets the rule or not
if (!$val->evaluate('abcd1234')) {
    echo $val->getMessage();
} else {
    echo 'The validator test passed. The string is alphanumeric.';
}
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
