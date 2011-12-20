Pop PHP Framework 0.9 (Forked from Moc10 PHP Library 1.9.7)
===========================================================

Completed:
----------
* Add Archive component
* Add Array component and wrap common features into in (sort, key exists, etc)
* Add dynamic element generator methods to Dom
* Form field/value access
* Improve dynamic field element generation
* Add text clean up to String (MS ASCII issues, convert EOL chars DOS => Unix => DOS, etc.)
* Improve File API
* Improve Image API overall, 'save'/'saveAs'/'output' methods, better chaining, etc.
* Add 'rotate' method to Image
* Add 'add rectangle' method to Image
* Add 'add ellipse' method to Image
* Add 'add line' method to Image
* Add alpha control and compositing to Image
* Add color control to Image
* Add 'destroy' method to Image
* Add advanced image filter methods to Image
* Add Imagick Component
* Address the 'touch' file creation issue in File and all child classes
* Add count() method to Record
* Add methods to get system and upload temp directories in the Dir class
* Change setString and setArray to factory
* Add Auth Component
* Add PDO support
* Modify the structure and naming convention of the Db component to fall under "Adapter"
* Add SQL query builder object/API to the DB component
* Add prepared/binded statements to the DB/Record component
  - MySQLi
  - PostgreSQL
  - SQLite
  - PDO
* Add multiple database connection support
* Revisit Record component and DB integration
  - Address save/update of row entry that's auto increment or not
  - Record Component: Class name to get table name
  - Record Component: Better access to create/get fields and their values
  - Add prepared statement support to the Record class.
  - Convert methods to static to facilitate easier API calls.
* Add extended image functionality with ImageMagick
* Add Cache Component
* Add JSON support
* Add ability to convert sets of data between SQL, XML, CSV, YAML, JSON and PHP
* Add SVG Component
* Add Color Component and add it to the components that use color.
* Add Graph component, Image, Imagick, Pdf, Svg
  - Background color/images
* Add Http Request/Response Component
* Add MVC Component
* Code review/cleanup - Phase 1
  - Overall class layout
  - Change is_null($var) to (null === $var)
  - Change print to echo
* Refactor Autoloader Component
  - Add classmap generator
* Refactor framework with namespaces


ON HOLD/TO BE CONTINUED/DEBUGGED/WORKED ON
------------------------------------------
* Rework the integration of the new/improved image components into Pdf
* Improve Pdf API
* Fix PDF import bug
* Address page ordering issue for PDF import
* Fix addFont bug
* Add compression to PDF
* Add a font component
* Add font embedding/compression to PDF
* Revisit PDF layer/clipping issues
* Revisit embedding GIFs into PDF issue
* Revisit pie chart text for PDF
* Revisit File write/buffer, etc.


CURRENTLY BEING WORKED ON & ON DECK
-----------------------------------
* Add Project Install & Code Generator
  - Data mapping classes to database tables
  - Generate code for classes and create database from template
  - Forms
  - Project class object?
  - Test with Pgsql and Sqlite
* Major Refactor/Restructure
  - Compression
  - Filter
  - Images
  - Evaluate possible benefits from interfaces, abstact classes, etc.
* Look at creating more dependency injections throughout (config/ini file?)
* Add Geo support via Google API (get address, city, state, long/lat, calculate distances, etc.)
  - Integrate GeoIP?
* Officially integrate Ralph's USAePay and Paymentech support components,
  as well as create support components for Authorize.net and PayPal.


NEXT UP:
--------
* Phase 2 of code review/cleanup
* Testing, testing & more testing
* Documentation


METHOD/PROPERTY RENAMES:
------------------------
### Form:
* setPostValues to setFieldValues
* processInitValues to generateFields

### String:
* setString to factory

### Array:
* setArray to factory


LANGUAGE ADDITIONS & REVISIONS:
-------------------------------
Error: The image resource has not been created.  
Error: The image output resource has not been created.  
The argument passed is not valid.  
The archive file is compressed. It must only be either a TAR or ZIP archive file.  
The archive file must be either a TAR or ZIP archive file.  
Error: The compression type must either be Flate or LZW.  
Error: The font file does not seem to have all of the correct data to parse.  
Error: The GD library extension must be installed to use the Gd adapter.  
No source file or database table was passed.  
The options parameter must be an array.  
The options parameter must be an array that contains either a 'table' or 'file' key.  
Error: Could not connect to database. %1  
Error: The database interface object has not been instaniated.  
Error: That method does not exist within the database interface object.  
Error: The columns parameter must be an array.  
Error: The columns parameter must be an array that contains at least one key/value pair.  
Error: The table must be set.  
Error: A SQL type must be set.  
Error: The database statement resource is not currently set.  
(Change) The column and value parameters were not defined to describe the row(s) to delete.  
(Change) The column '%1' does not exist.  
(Remove) Error: Table name not set.  
Error: That database adapter class does not exist.  
Error: The Imagick library extension must be installed to use the Imagick adapter.  
Error: That image type is not supported.  
Error: The cache type must be 'File', 'Sqlite' or 'Memcached'.  
Error: You must pass either a directory or SQLite file store point.  
Error: That cache directory does not exist.  
Error: That cache directory is not writable.  
Error: That cache db file and/or directory is not writable.  
Error: Memcache is not available on this server.  
Error: Unable to connect to the memcached server.  
That data type is not supported.  
No database adapter was found.  
That font is not available.  
The percentages are greater than 100.  
A proper color array was not passed.  
One or more of the color values is out of range.  
The color parameter is not a valid color space object.  
That color space object does not exist.  
That color space object is already that type.  
The headers have already been sent.  
The response was not properly formatted.  
A template asset has not been assigned.  
That template file either does not exist or is not the correct format.  
Due to licensing restrictions, RAR files cannot be created and can only be decompressed.  
The value must only contain alphanumeric characters.  
The value must contain non-alphanumeric characters.  
The value must only contain characters of the alphabet.  
The value must contain characters not in the alphabet.  
The value must be between %1 and %2.  
The value must not be between %1 and %2.  
The value must be between or equal to %1 and %2.  
The value must not be between or equal to %1 and %2.  
The value must be a valid email format.  
The value must not be a valid email format.  
The value must be excluded.  
The value must not be excluded.  
The value must be included.  
The value must not be included.  
The value must be equal to %1.  
The value must not be equal to %1.  
The value must be greater than %1.  
The value must not be greater than %1.  
The value must be greater than or equal to %1.  
The value must not be greater than or equal to %1.  
The value length must be equal to %1.  
The value length must not be equal to %1.  
The value must be less than %1.  
The value must not be less than %1.  
The value must be less than or equal to %1.  
The value must not be less than or equal to %1.  
The value length must be between %1 and %2.  
The value length must not be between %1 and %2.  
The value length must be between or equal to %1 and %2.  
The value length must not be between or equal to %1 and %2.  
The value length must be greater than %1.  
The value length must not be greater than %1.  
The value length must be greater than or equal to %1.  
The value length must not be greater than or equal to %1.  
The value length must be less than %1.  
The value length must not be less than %1.  
The value length must be less than or equal to %1.  
The value length must not be less than or equal to %1.  
The value must be empty.  
The value must not be empty.  
The value must be numeric.  
The value must not be numeric.  
Error: The file type %1 is not an accepted file format.  
The value format is not correct.  
The value must be a valid IPv4 address.  
The value must not be a valid IPv4 address.  
The value must be a valid IPv6 address.  
The value must not be a valid IPv6 address.  
The user role has not been defined to evaluate against.  
Error: The file type %1 is not an accepted file format.  
The value must be part of the subnet %1.  
The value must not be part of the subnet %1.  
The value must be a valid IPv4 subnet.  
The value must not be a valid IPv4 subnet.  
The IP address must be a valid IPv4 address.  
The user is valid.  
The user was not found.  
The user is blocked.  
The password was incorrect.  
The allowed login attempts (%1) have been exceeded.  
That IP address is blocked.  
That IP address is not allowed.  
The access file does not exist.  
The user's role is not defined.  
That class map file does not exist.  
Unknown error.  
You must pass a source folder and a output file to generate a class map file.  
The source folder passed does not exist.  
The output file passed must be a PHP file.  
You must pass an install file to install the project.  
Unknown option:  
You must pass at least one argument.  
Run './pop -h' for help.  
Run '.\pop -h' for help.  
Aborted.  
Project folder exists. This may overwrite any project files you may already have under that project folder.  
Database credentials and schema detected.  
Test and install the database(s)?  
Testing the database(s)...  
Testing  
The database type and database name must be set for the database  
Database  
Installing database  
Add project to the bootstrap file?  
Project install complete.  
This process will create and install a lightweight framework for your project under the folder specified in the install file. Minimally, the install file should return a Pop\Config object containing your project install settings, such as project name, folders and any database credentials. Besides creating the folders and files for you, one of the main benefits is ability to test and install the database and the corresponding configuration and class files. You can enable this by having the SQL files in the same folder as your build file under a folder named after the database, i.e. './dbname'. The following folder structure is required for the database installation to work properly:  
Install a project based on the install file specified  
Check the current configuration for required dependencies  
Display this help  
Show project install instructions  
Set the default language for the project  
Create a class map file from the source folder and save to the output file  
Display version of Pop PHP Framework and latest available  
Continue?  
Enter the folder where the 'bootstrap.php' is located in relation to the current folder:  
Bootstrap file not found. Try again.  
Creating base folder and file structure...  
Creating database table class files...  
Enter the two-letter code for the default language:  
Real-time configuration changes are not allowed.  
Run the unit tests from a folder  
That folder does not exist.  
The folder argument is not a folder.  
The module name must be set in the module config.  
Install index controller and web configuration files?  
The docblock is not in the correct format.  
You will have to install your web server rewrite configuration manually.  
Creating controller class files...  
The Sqlite database file and folder are not writable.  
