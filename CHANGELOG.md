Pop PHP Framework Changelog
===========================

1.7.0
-----
Released on December 1, 2013

* Add Shipping component with FedEx, UPS and USPS support to calculate and compare shipping rates and services
* Improve/update the Curl component

1.6.0
-----
Released on November 23, 2013

* Add Crypt component and improve use of crypt with the Auth component
    - The encrypt/decrypt methods in Filter\String have been deprecated in favor of the Crypt component

1.5.0
-----
Released on September 9, 2013

* Patch resource reference object bug in Pdf component
* Modify install functionality of the Project component
* Add isLoaded() method to the Project class
* Add file size validation support to Form\Element
* Add ability to inject XML data into Form\Element\Select object
* Patch null value return issue with getElement() in Form class
* Tweak/update isDenied() method of the Acl component
* Add sendJson() method to the Controller class
* Upgrades to the Nav component
    - Add leaf method to Nav
    - Add positioning to the new addLeaf() method in Nav
    - Add $prepend option to the addBranch() and addLeaf() methods in Nav
    - Add an empty return if the nav object doesn't have any child nodes
    - Add check in the Nav class to see if children are allowed under the parent
* Fix bug in prepared adapters/bindParams() with parameter naming conflict
* Add static formats() method to the Gd and Imagick classes
* Add exception to File::upload
* Add __toString() method to Dom\Child
* Add Paginator support to the new Html data class

1.4.0
-----
Released on July 15, 2013

* Added Nav component
    - Ability to construct an HTML-based navigation tree, with configuration
    - Ability to utilize the Acl component with it
* Added a KILL constant to the Event component to allow killing the project app
* Add field grouping to the Form component
* Add merge method to the Config class
* Add Html class to the Data component

1.3.0
-----
Released on May 31, 2013

* Refactor the Form component
    - Revise form fields PHP config pattern
    - Better support for control over error display
    - Better support for PHP view templates
    - Add support for generic callables for form element validators
* Update the File component
    - Add object support to Dir class to retrieve files and directories as objects
    - Add overwrite flag to copy() and move() methods
* Improve the Zip adapter for the Archive component

1.2.3
-----
Released on March 21, 2013

* Refactor the Auth/Acl component
    - Improve support for roles
    - Add support for resources and permissions

1.2.2
-----
Released on February 27, 2013

* Refactor the Auth component and its functionality
* Add getFullUri() method to the Request class
* Small improvement to the writeData() method of the Data class
* Add static getSql() method to the Record class

1.2.1
-----
Released on February 11, 2013

* Refactor the Db\Sql component and its functionality with the Db\Record component

1.2.0
-----
Released on February 4, 2013

* Large general code review and cleanup
* Add relative path support to project install functionality
* Move the Record component under the Db component
* Add a Service component
    - Ability to configure and lazy-load services as needed
    - Hooked into the Project component
* Refactor and improve Auth component
* Refactor and improve Cache component
    - Add support for APC
* Refactor and improve Color component
* Add factory method to the Config component
* Refactor and improve Feed component
    - Add built in support for Rss, Atom, JSON and PHP based feeds
    - Add support for standard feed services
        + Facebook
        + Flickr
        + Twitter
        + Vimeo
        + YouTube
* Improve File component with better file owner/group/permissions API
* Add Csrf and Captcha elements to the Form component
* Refactor and improve Graph component
* Add header support to the Http\Request class in the Http component
* Renamed the Locale component to I18n. Refactor and improve the component.
* Refactor, clean up and improve the API of the Image component
    - Add Captcha image class
* Refactor and improve Mail component
    - Add the ability to save emails to disk for later deployment
      via a external mail program, or Pop\Mail
* Refactor and improve Validator component
* Refactor and improve Web\Browser & Web\Mobile classes

1.1.2
-----
Released on January 7, 2013

* Refactor Record component to improve "findBy()" functionality

1.1.1
-----
Released on January 2, 2013

* Add CSRF and CAPTCHA elements to the Form component
* Improved multiple Select element support
* Add a protected parseData() method to the Http\Request class to allow
  for parsing of data from methods other than GET and POST

1.1.0
-----
Released on December 14, 2012

* Add Event component, hook into Project class
* Add Log component

1.0.3
-----
Released on December 2, 2012

* Fixed issue with the Autoloader, return back if class not located or registered
* Add Fields class to the Form component
* Removed under-used and unnecessary methods from the Record component
    - distinct()
    - search()
    - join()

1.0.2
-----
Released on November 21, 2012

* Small restructure of the Dir component. Moved under the File component
* Resolved and eliminated some unnecessary internal dependencies
* Code cleanup

1.0.1
-----
Released on October 23, 2012

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

1.0.0
-----
Released on August 9, 2012

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
