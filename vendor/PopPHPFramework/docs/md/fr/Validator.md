Pop PHP Framework
=================

Documentation : Validator
-------------------------

Home

La composante Validator fournit simplement une fonctionnalité de
validation de nombreux cas d'utilisation différentes, telles que la
validation ou non un nombre est d'une certaine valeur ou une chaîne est
alphanumérique. Validateurs les plus avancés sont également disponibles,
tels que la validation d'une adresse e-mail et l'adresse IP ou un numéro
de carte de crédit. Et, si ce que vous avez besoin n'est pas disponible,
le composant peut être facilement étendu.

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
