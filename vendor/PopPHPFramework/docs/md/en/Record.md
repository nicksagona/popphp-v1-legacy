Pop PHP Framework
=================

Documentation : Record
----------------------

The Record component, as outlined in the documentation overview, is a "hybrid" of sorts between the Active Record and Table Data Gateway patterns. Via a standardized API, it can provide access to a single row or record within a database table, or multiple rows or records at once. The most common approach is to write a child class that extends the Record class that represents a table in the database. The name of the child class should be the name of the table. By simply creating

<pre>
use Pop\Record\Record;

class Users extends Record { }
</pre>

you create a class that has all of the functionality of the Record component built in and the class knows the name of the database table to query from the class name. For example,  'Users' translates into `users` or 'DbUsers' translates into `db_users` (CamelCase is automatically converted into lower_case_underscore.) From there, you can fine-tune the child class that represents the table with various class properties such as:

<pre>
// Table prefix, if applicable
protected $prefix = null;

// Primary ID, if applicable, defaults to 'id'
protected $primaryId = 'id';

// Whether the table is auto-incrementing or not
protected $auto = true;

// Whether to use prepared statements or not, defaults to true
protected $usePrepared = true;
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
