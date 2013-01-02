Pop PHP Framework 1.1.1
=======================

COMPLETED:
----------
* Add CSRF and CAPTCHA elements to the Form component
* Add a protected parseQueryData() method to the Http\Request class
  to allow for parsing of data from methods other than GET and POST

Pop PHP Framework 1.1.0
=======================

COMPLETED:
----------
* Add Event component, hook into Project class
* Add Log component


Pop PHP Framework 1.0.3
=======================

COMPLETED:
----------
* Fixed issue with the Autoloader, return back if class not located or registered
* Add Fields class to the Form component
* Removed under-used and unnecessary methods from the Record component
    - distinct()
    - search()
    - join()


Pop PHP Framework 1.0.2
=======================

COMPLETED:
----------
* Small restructure of the Dir component. Moved under the File component
* Resolved and eliminated some unnecessary internal dependencies
* Code cleanup


Pop PHP Framework 1.0.1
=======================

COMPLETED:
----------
* Revise the Filter component
    - Remove unnecessary and under-used classes and methods
    - Convert remaining methods to static methods that return strings
    - Move the Crypt functionality into the String class
* Convert the $adapter property within the Db class to protected and create an access method adapter()
* Convert the $sql property within the Db class to protected and create an access method sql()
* Revise the File class to handle permissions better
* Refactor the setFieldValues() method within the Form class
    - Remove the dependency on Pop\Filter\String
    - Add the ability to pass basic PHP string functions with their respective parameters
* Refactor the Mvc Router
    - Change the mapping to the controller classes from keyword-based to direct URL mapping
    - Add the ability to route to sub-controllers
* Overall code cleanup


Pop PHP Framework 1.0.0
=======================

COMPLETED:
----------
* Refactor framework for 5.3+ only and restructure it using namespaces
* Add Archive component
* Add Compress component
* Add Auth component with user roles
* Add Validator component
* Refactor and improve the Dom and Form components
* Add Filter component, move String component under it, adding more filtering methods
* Improve File component
* Improve the Dir component
* Refactor and improve Image component overall
    - Add save/saveAs/output methods, better chaining, etc.
    - Add support for Imagick
    - Add support for SVG
* Refactor and improve the Db component
    - Add multiple database connection support
    - Add SQL query builder object/API to the DB component
    - Add PDO support
    - Add MSSQL support (via SqlSrv)
    - Add Oracle support
    - Add support for prepared/binded statements
        + MySQLi
        + MSSQL
        + Oracle
        + PostgreSQL
        + SQLite
        + PDO
* Refactor and improve the Record component
    - Address save/update issue regarding non-autoincrement tables
    - Use class name to get table name
    - Better access to create/get fields and their values
    - Add prepared statement support to the Record class.
    - Convert methods to static to facilitate easier API calls.
* Add Cache component
* Add Data component
    - Convert sets of data between SQL, XML, CSV, YAML, JSON and PHP
* Add Color component and add it to the components that use color.
* Add Graph component utilizing Image (GD/Imagick/SVG) and Pdf
* Add Http component
* Add MVC component
* Refactor Loader Component
    - Add classmap support and classmap generator
* Add Code generator component
* Add Project config/install component, and CLI scripts
    - Data mapping classes to database tables with prefix support
    - Generate config files and code for project classes
        + DB Tables
        + Controllers
        + Models
        + Forms
        + Project
* Add Geo component
* Add Payment component
    - Tested and completed
        + Authorize.net
        + PayPal (Website Payment Pro)
        + UsaEpay
        + Payleap
        + Trustcommerce
* Finish Pdf component and improve font support
    - Address, test and debug the Font component and embedding fonts
        + Finalize support for TTF, OTF and PFB (Type1) font files
    - Add embed override
* Write unit tests
* Generate new documentation
