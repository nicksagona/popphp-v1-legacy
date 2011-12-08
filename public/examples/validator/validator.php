<?php

require_once '../../bootstrap.php';

use Pop\Validator\Validator,
    Pop\Validator\Validator\AlphaNumeric;

try {
    // Create an alphanumeric rule
    $rule = Validator::factory(new AlphaNumeric());

    // Evaluate if the input value meets the rule or not
    if (!$rule->evaluate('abcd1234')) {
        echo $rule->getMessage();
    } else {
        echo 'The rule test passed. The string is alphanumeric.';
    }

    echo PHP_EOL . PHP_EOL;
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
?>