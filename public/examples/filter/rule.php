<?php

require_once '../../bootstrap.php';

use Pop\Filter\Rule,
    Pop\Filter\Rule\AlphaNumeric;

try {
    // Create an alphanumeric rule
    $rule = Rule::factory(new AlphaNumeric());

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