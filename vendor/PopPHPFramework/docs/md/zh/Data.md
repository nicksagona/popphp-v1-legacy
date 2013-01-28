Pop PHP Framework
=================

Documentation : Data
--------------------

Home

æ•°æ?®ç»„ä»¶æ??ä¾›çš„æ•°æ?®é›†ä»Žä¸€ä¸ªå…±å?Œçš„æ
¼å¼?è½¬æ?¢çš„èƒ½åŠ›ã€‚æ”¯æŒ?çš„æ ¼å¼?åŒ…æ‹¬ï¼š

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

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
