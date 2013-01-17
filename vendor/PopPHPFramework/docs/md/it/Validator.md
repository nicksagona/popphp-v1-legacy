Pop PHP Framework
=================

Documentation : Validator
-------------------------

Il componente Validator prevede semplicemente funzionalità di convalida per molti casi d'uso differenti, quali la convalida o meno di un numero è di un certo valore o una stringa alfanumerica. Validatori più avanzate sono disponibili così come convalida di un indirizzo e-mail e l'indirizzo IP o un numero di carta di credito. E, se quello che ti serve non è disponibile, il componente può essere facilmente esteso.

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
