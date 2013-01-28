Pop PHP Framework
=================

Documentation : Validator
-------------------------

Home

Die Service-Komponente fungiert als Service Locator fÃ¼r die laufende
Anwendung oder ein Projekt. Es unterstÃ¼tzt lazy-loading von
Service-Instanzen, so werden die Dienste erst erstellt, wenn die
Anwendung sie benÃ¶tigt werden. Es gibt viele MÃ¶glichkeiten, wie Sie
die Dienste aufrufen kÃ¶nnen, von der Definition Klassen mit
VerschlÃ¼ssen.

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
