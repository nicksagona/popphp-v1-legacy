<?php

require_once '../../bootstrap.php';

use Pop\Filter\String;

try {
    $str1 = String::factory("Hello You <script type=\"text/javascript\">alert('Something Bad');</script>283 &^%$ 'Dud\\e798(*0:")
                ->stripTags()
                ->html();

    $str2 = String::factory("Hello What's <script type=\"text/javascript\">alert('Something Else Bad');</script> happening hot stuf!")
                ->upper()
                ->stripTags()
                ->html();

    echo $str1 . PHP_EOL;
    echo $str2 . PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage();
}

?>