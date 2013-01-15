<?php

require_once '../../bootstrap.php';

use Pop\Data\Type\Csv;

try {
    $record = array(
        array('item1' => 'Test1', 'item2' => 'Test,2', 'item3' => 'Test,3', 'item4' => '2010-01-01'),
        array('item1' => "Test'4", 'item2' => 'Test5', 'item3' => "'Test6'", 'item4' => '2010-02-02'),
        array('item1' => "7,Test", 'item2' => '8Test', 'item3' => '9"Test"', 'item4' => '2010-03-03')
    );

    $csv = Csv::encode($record);
    echo $csv;

    $php = Csv::decode(file_get_contents('../assets/files/test-import.csv'));
    print_r($php);

} catch (\Exception $e) {
    echo $e->getMessage();
}

