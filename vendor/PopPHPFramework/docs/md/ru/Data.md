Pop PHP Framework
=================

Documentation : Data
--------------------

Home

Ð”Ð°Ð½Ð½Ñ‹Ðµ ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚ Ð¿Ñ€ÐµÐ´Ð¾Ñ?Ñ‚Ð°Ð²Ð»Ñ?ÐµÑ‚
Ð²Ð¾Ð·Ð¼Ð¾Ð¶Ð½Ð¾Ñ?Ñ‚ÑŒ ÐºÐ¾Ð½Ð²ÐµÑ€Ñ‚Ð¸Ñ€Ð¾Ð²Ð°Ñ‚ÑŒ Ð½Ð°Ð±Ð¾Ñ€Ð¾Ð²
Ð´Ð°Ð½Ð½Ñ‹Ñ… Ð¸Ð· Ð¾Ð´Ð½Ð¾Ð³Ð¾ Ð¾Ð±Ñ‰ÐµÐ³Ð¾ Ñ„Ð¾Ñ€Ð¼Ð°Ñ‚Ð° Ð²
Ð´Ñ€ÑƒÐ³Ð¾Ð¹. ÐŸÐ¾Ð´Ð´ÐµÑ€Ð¶Ð¸Ð²Ð°ÑŽÑ‚Ñ?Ñ? Ñ?Ð»ÐµÐ´ÑƒÑŽÑ‰Ð¸Ðµ
Ñ„Ð¾Ñ€Ð¼Ð°Ñ‚Ñ‹:

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
