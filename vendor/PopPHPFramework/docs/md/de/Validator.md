Pop PHP Framework
=================

Documentation : Validator
-------------------------

Der Validator Komponente stellt lediglich Validierung Funktionalität für viele verschiedene Anwendungsfälle, wie zB die Validierung, ob eine Zahl von einem bestimmten Wert ist oder ein String ist alphanumerisch. Weiter fortgeschrittene Validatoren sind ebenso verfügbar, wie zB die Validierung eine E-Mail-Adresse und IP-Adresse oder eine Kreditkartennummer. Und wenn das, was Sie brauchen, ist nicht vorhanden, kann der Komponente problemlos erweitert werden.

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
