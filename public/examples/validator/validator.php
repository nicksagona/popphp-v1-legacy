<?php

require_once '../../bootstrap.php';

use Pop\Validator\Validator,
    Pop\Validator\Validator\AlphaNumeric;

try {
    // Create an alphanumeric validator
    $val = Validator::factory(new AlphaNumeric());

    // Evaluate if the input value meets the rule or not
    if (!$val->evaluate('abcd1234')) {
        echo $val->getMessage();
    } else {
        echo 'The validator test passed. The string is alphanumeric.';
    }

    echo PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}

?>