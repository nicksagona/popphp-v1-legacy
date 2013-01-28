Pop PHP Framework
=================

Documentation : Validator
-------------------------

Home

O componente Validator simplesmente fornece funcionalidade de
validaÃ§Ã£o para muitos casos de uso diferentes, como validar ou nÃ£o um
nÃºmero Ã© de um determinado valor ou uma string Ã© alfanumÃ©rico.
Validadores mais avanÃ§ados tambÃ©m estÃ£o disponÃ­veis, como a
validaÃ§Ã£o de um endereÃ§o de e-mail e endereÃ§o IP ou um nÃºmero de
cartÃ£o de crÃ©dito. E, se o que vocÃª precisa nÃ£o estiver disponÃ­vel,
o componente pode ser facilmente estendido.

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
