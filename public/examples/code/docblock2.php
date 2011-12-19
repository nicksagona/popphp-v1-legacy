<?php

require_once '../../bootstrap.php';

use Pop\Code\DocblockGenerator;

try {
    $doc = <<<DOC
    /**
     * Aliquam velit massa, ultricies sit amet, facilisis vitae, placerat
     * vitae, justo. Pellentesque tortor orci, ornare a.
     *
     * @category Pop
     * @package  Pop_Code
     * @author   Nick Sagona, III
     * @param    array   \$ary
     * @param    boolean \$blah
     * @throws   Exception
     * @return   mixed
     */
DOC;

    $docblock = DocblockGenerator::parse($doc);
    print_r($docblock);
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
?>