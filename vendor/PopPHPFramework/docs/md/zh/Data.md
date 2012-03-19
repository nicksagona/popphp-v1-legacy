Pop PHP Framework
=================

Documentation : Data
--------------------

数据组件提供了一个共同的格式转换到另一个数据集的能力。支持的格式是：

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
