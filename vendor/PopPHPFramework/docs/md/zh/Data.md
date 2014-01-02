Pop PHP Framework
=================

Documentation : Data
--------------------

Home

数据组件提供的数据集从一个共同的格式转换的能力。支持的格式包括：

-   csv
-   json
-   php
-   sql
-   xml
-   yaml

<!-- -->

    use Pop\Data\Data;

    // Parses the data file into a usable PHP array
    $data = new Data('../assets/files/test-import.csv');
    $csv = $data->parseFile();

    // Takes the PHP array and creates an XML file from it
    $data = new Data($csv);
    $obj = $data->parseData('xml');

    // Prints out the data in the new XML format
    echo $obj;

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
