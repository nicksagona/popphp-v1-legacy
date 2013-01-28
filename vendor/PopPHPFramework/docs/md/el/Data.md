Pop PHP Framework
=================

Documentation : Data
--------------------

Home

Î¤Î¿ ÏƒÏ…ÏƒÏ„Î±Ï„Î¹ÎºÏŒ Î´ÎµÎ´Î¿Î¼Î­Î½Ï‰Î½ Ï€Î±Ï?Î­Ï‡ÎµÎ¹ Ï„Î·Î½
Î¹ÎºÎ±Î½ÏŒÏ„Î·Ï„Î± Î½Î± Î¼ÎµÏ„Î±Ï„Ï?Î­Ï€ÎµÎ¹ ÏƒÏ?Î½Î¿Î»Î±
Î´ÎµÎ´Î¿Î¼Î­Î½Ï‰Î½ Î±Ï€ÏŒ Î­Î½Î±Î½ ÎºÎ¿Î¹Î½ÏŒ Î¼Î¿Ï?Ï†Î® ÏƒÎµ Î¬Î»Î»Î·.
ÎŸÎ¹ Ï…Ï€Î¿ÏƒÏ„Î·Ï?Î¹Î¶ÏŒÎ¼ÎµÎ½ÎµÏ‚ Î¼Î¿Ï?Ï†Î­Ï‚ ÎµÎ¯Î½Î±Î¹ Î¿Î¹
ÎµÎ¾Î®Ï‚:

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
