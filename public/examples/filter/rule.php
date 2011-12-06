<?php

require_once '../../bootstrap.php';

use Pop\Filter\Rule;

$input = 'BlahBlah@#$@#$123';
$rule = Rule::factory('AlphaNum');

if (!$rule->evaluate($input)) {
    echo $rule->getMessage() . '<br />' . PHP_EOL;
} else {
    echo 'Rule test passed.<br />' . PHP_EOL;
}


?>