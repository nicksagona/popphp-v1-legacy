Pop PHP Framework
=================

Documentation : Validator
-------------------------

Home

Die Service-Komponente fungiert als Service Locator für die laufende
Anwendung oder ein Projekt. Es unterstützt lazy-loading von
Service-Instanzen, so werden die Dienste erst erstellt, wenn die
Anwendung sie benötigt werden. Es gibt viele Möglichkeiten, wie Sie die
Dienste aufrufen können, von der Definition Klassen mit Verschlüssen.

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
