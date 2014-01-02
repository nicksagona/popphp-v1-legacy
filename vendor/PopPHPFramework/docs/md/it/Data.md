Pop PHP Framework
=================

Documentation : Data
--------------------

Home

Il componente dati fornisce la capacità di convertire insiemi di dati da
un formato ad un altro comune. I formati supportati sono:

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
