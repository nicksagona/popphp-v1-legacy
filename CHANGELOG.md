Pop PHP Framework 0.9 (Forked from Moc10 PHP Library 1.9.7)
===========================================================

Completed:
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
    - Add 'save'/'saveAs'/'output' methods, better chaining, etc.
    - Add support for Imagick
    - Add support for SVG
* Refactor and improve the Db component
    - Add multiple database connection support
    - Add SQL query builder object/API to the DB component
    - Add PDO support
    - Add support for prepared/binded statements
        + MySQLi
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
        + Forms
        + Project
* Add Geo component
* Payment component
    - Tested and completed
        + Authorize.net
        + PayPal (Website Payment Pro)
        + UsaEpay
        + Payleap
        + Trustcommerce


CURRENTLY BEING WORKED ON
-----------------------------------
* Finish XML language data
* Pdf Component
    - Improve Pdf API overall
    - Rework the integration of the new/improved image components into Pdf
    - Address, test and debug embed fonts and the Font component
    - Address, test and debug Pdf import
    - Add compression to Pdf
    - Revisit PDF layer/clipping issues
    - Revisit embedding GIFs into Pdf
    - Revisit pie chart text for Pdf


NEXT UP:
--------
* Phase 2 of code review/cleanup
* Testing, testing & more testing
* Documentation
