Pop PHP Framework
=================

Documentation : Validator
-------------------------

Компонент Validator просто обеспечивает проверку функциональности для различных вариантов использования, таких как проверка, является ли число определенного значения или буквенно-цифровой строке. Более продвинутые средства проверки доступны, например, такие как проверка электронной почты и IP-адрес или номер кредитной карты. И, если то, что вам нужно, это не доступно, компонент может быть легко расширен.

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
