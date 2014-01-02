Pop PHP Framework
=================

Documentation : Validator
-------------------------

Home

The Validator component simply provides validation functionality for
many different use cases, such as validating whether or not a number is
of a certain value or a string is alphanumeric. More advanced validators
are available as well, such as validating an email address, and IP
address or a credit card number. And, if what you need isn't available,
of the component can be easily extended.

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
