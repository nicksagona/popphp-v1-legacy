<?php

require_once '../../bootstrap.php';

use Pop\Validator;

try {
    // Create an alphanumeric validator
    $val = new Validator\AlphaNumeric();
    $input = 'abcd1234';

    // Evaluate if the input value meets the rule or not
    if (!$val->evaluate($input)) {
        echo $val->getMessage();
    } else {
        echo 'The validator test passed. The string is alphanumeric.';
    }
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}

