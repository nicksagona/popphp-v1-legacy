Pop PHP Framework
=================

Documentation : Validator
-------------------------

El componente de validación sólo proporciona la funcionalidad de validación para infinidad de usos, tales como la validación de si un número es de un cierto valor o una cadena es alfanumérico. Validadores más avanzados están disponibles, así como validar una dirección de correo electrónico, y la dirección IP o un número de tarjeta de crédito. Y, si lo que usted necesita no está disponible, el componente se puede extender fácilmente.


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

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
