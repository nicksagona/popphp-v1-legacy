Pop PHP Framework
=================

Documentation : Validator
-------------------------

Home

El componente Validator simplemente proporciona funcionalidad de
validación para muchos casos de uso, tales como la validación de si es o
no un número es de un valor determinado o una cadena es alfanumérico.
Validadores más avanzados están disponibles, así como validar una
dirección de correo electrónico y la dirección IP o un número de tarjeta
de crédito. Y, si lo que necesita no está disponible, el componente se
puede extender fácilmente.

    use Pop\Validator\AlphaNumeric;

    // Create an alphanumeric validator
    $val = new AlphaNumeric();

    // Evaluate if the input value meets the rule or not
    if (!$val->evaluate('abcd1234')) {
        echo $val->getMessage();
    } else {
        echo 'The validator test passed. The string is alphanumeric.';
    }

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
