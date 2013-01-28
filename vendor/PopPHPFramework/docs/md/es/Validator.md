Pop PHP Framework
=================

Documentation : Validator
-------------------------

Home

El componente Validator simplemente proporciona funcionalidad de
validaciÃ³n para muchos casos de uso, tales como la validaciÃ³n de si es
o no un nÃºmero es de un valor determinado o una cadena es
alfanumÃ©rico. Validadores mÃ¡s avanzados estÃ¡n disponibles, asÃ­ como
validar una direcciÃ³n de correo electrÃ³nico y la direcciÃ³n IP o un
nÃºmero de tarjeta de crÃ©dito. Y, si lo que necesita no estÃ¡
disponible, el componente se puede extender fÃ¡cilmente.

    use Pop\Validator\AlphaNumeric;

    // Create an alphanumeric validator
    $val = new AlphaNumeric();

    // Evaluate if the input value meets the rule or not
    if (!$val->evaluate('abcd1234')) {
        echo $val->getMessage();
    } else {
        echo 'The validator test passed. The string is alphanumeric.';
    }

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
