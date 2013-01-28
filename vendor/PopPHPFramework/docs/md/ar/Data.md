Pop PHP Framework
=================

Documentation : Data
--------------------

Home

Ø§Ù„Ù…ÙƒÙˆÙ† Ø§Ù„Ø¨ÙŠØ§Ù†Ø§Øª ÙŠÙˆÙ?Ø± Ø§Ù„Ù‚Ø¯Ø±Ø© Ø¹Ù„Ù‰ ØªØ­ÙˆÙŠÙ„
Ù…Ø¬Ù…ÙˆØ¹Ø§Øª Ù…Ù† Ø§Ù„Ø¨ÙŠØ§Ù†Ø§Øª Ù…Ù† ØµÙŠØºØ© Ø¥Ù„Ù‰ Ø£Ø®Ø±Ù‰
Ù…Ø´ØªØ±ÙƒØ©. Ø§Ù„ØªÙ†Ø³ÙŠÙ‚Ø§Øª Ø§Ù„Ù…Ø¹ØªÙ…Ø¯Ø© Ù‡ÙŠ:

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
