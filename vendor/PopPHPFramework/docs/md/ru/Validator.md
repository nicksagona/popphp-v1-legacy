Pop PHP Framework
=================

Documentation : Validator
-------------------------

Home

Компонент Validator просто обеспечивает проверку функциональности для
различных случаев использования, например, проверку или нет номер имеет
определенное значение или строка буквенно-цифровой. Более продвинутые
проверяющие также доступны, такие как проверка электронной почты и
IP-адрес или номер кредитной карты. И, если то, что вам нужно, это не
доступно, компонент может быть легко расширен.

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
