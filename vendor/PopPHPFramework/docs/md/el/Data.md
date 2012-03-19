Pop PHP Framework
=================

Documentation : Data
--------------------

Η συνιστώσα των δεδομένων παρέχει τη δυνατότητα να μετατρέψετε σύνολα δεδομένων από ένα κοινό σχήμα σε άλλο. Οι υποστηριζόμενες μορφές είναι οι εξής:

* csv
* json
* php
* sql
* xml
* yaml

<pre>
use Pop\Data\Data;

// Parses the data file into a usable PHP array
$data = new Data('../assets/files/test-import.csv');
$csv = $data->parseFile();

// Takes the PHP array and creates an XML file from it
$data = new Data($csv);
$obj = $data->parseData('xml');

// Prints out the data in the new XML format
echo $obj;
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
