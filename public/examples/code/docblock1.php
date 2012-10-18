<?php

require_once '../../bootstrap.php';

use Pop\Code\DocblockGenerator;

try {
    // Define docblock description
    $desc = "Aliquam velit massa, ultricies sit amet, facilisis vitae, placerat vitae, justo. Pellentesque tortor orci, ornare a.";

    // Create docblock object and set tags
    $doc = DocblockGenerator::factory($desc)->setTag('category', 'Pop')
                                            ->setTag('package', 'Pop_Code')
                                            ->setTag('author', 'Joe Author')
                                            ->setTag('throws', 'Exception')
                                            ->setParam('array', '$ary')
                                            ->setParam('boolean', '$blah')
                                            ->setReturn('mixed');

    // Output the docblock
    echo $doc . PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
