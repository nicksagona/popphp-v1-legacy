Pop PHP Framework
=================

Documentation : Validator
-------------------------

Home

Il componente Validator fornisce il vantaggio di funzionalità di
validazione per molti casi d'uso differenti, quali convalida se un
numero è di un certo valore o una stringa alfanumerica è. Validatori più
avanzate sono disponibili pure, come ad esempio la convalida di un
indirizzo di posta elettronica, e l'indirizzo IP o un numero di carta di
credito. E se quello che ti serve non è disponibile, il componente può
essere facilmente esteso.

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
