Pop PHP Framework
=================

Documentation : Validator
-------------------------

Home

O componente Validator simplesmente fornece funcionalidade de validação
para muitos casos de uso diferentes, como validar ou não um número é de
um determinado valor ou uma string é alfanumérico. Validadores mais
avançados também estão disponíveis, como a validação de um endereço de
e-mail e endereço IP ou um número de cartão de crédito. E, se o que você
precisa não estiver disponível, o componente pode ser facilmente
estendido.

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
