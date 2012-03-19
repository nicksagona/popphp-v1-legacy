Pop PHP Framework
=================

Documentation : Validator
-------------------------

O componente Validator simplesmente fornece a funcionalidade de validação para muitos casos de uso diferentes, como validar ou não um número é de um determinado valor ou uma string é alfanumérico. Validadores mais avançados estão disponíveis também, como validar um endereço de e-mail, eo endereço IP ou um número de cartão de crédito. E, se o que você precisa não estiver disponível, do componente pode ser facilmente estendido.


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
