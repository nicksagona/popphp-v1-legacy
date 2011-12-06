<?php

require_once '../../bootstrap.php';

use Pop\Filter\Rule,
    Pop\Filter\Rule\AlphaNumeric;

// Create an alphanumeric rule
$rule = Rule::factory(new AlphaNumeric());

// Evaluate if the input value meets the rule or not
if (!$rule->evaluate('abcd1234')) {
    echo $rule->getMessage() . PHP_EOL;
} else {
    echo 'Rule test passed.' . PHP_EOL;
}

echo 'Done.' . PHP_EOL . PHP_EOL;

?>