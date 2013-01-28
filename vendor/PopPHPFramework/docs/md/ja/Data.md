Pop PHP Framework
=================

Documentation : Data
--------------------

Home

ãƒ‡ãƒ¼ã‚¿ã‚³ãƒ³ãƒ?ãƒ¼ãƒ?ãƒ³ãƒˆã?¯ã€?åˆ¥ã?®å…±é€šã?®ãƒ•ã‚©ãƒ¼ãƒžãƒƒãƒˆã?‹ã‚‰ã?®ãƒ‡ãƒ¼ã‚¿ã‚»ãƒƒãƒˆã‚’å¤‰æ?›ã?™ã‚‹æ©Ÿèƒ½ã‚’æ??ä¾›ã?—ã?¾ã?™ã€‚ã‚µãƒ?ãƒ¼ãƒˆã?•ã‚Œã?¦ã?„ã‚‹å½¢å¼?ã?¯ä»¥ä¸‹ã?®ã?¨ã?Šã‚Šã?§ã?™ã€‚

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
