IMPORTANT!
==========
This version is now end-of-life, and represents only legacy code for reference.
You are strongly encouraged to upgrade to version 2 of the Pop PHP Framework
and its components. You can find them here:

[Pop PHP Website](http://www.popphp.org/)  
[Github](https://github.com/popphp/popphp)

Welcome to the Pop PHP Framework 1.7.0 Release!
===============================================

RELEASE INFORMATION
-------------------
Pop PHP Framework 1.7.0 Release  
Released December 1, 2013

OVERVIEW
--------
The Pop PHP Framework is a robust, yet easy-to-use PHP framework
with a verbose API. It supports PHP 5.3+.

The beginnings of this framework were humble. Originally containing only
9 components, the focus was placed in simplicity and being lightweight.
It attempted to provide solutions in areas such as graphics and images,
which were found lacking (or completely ignored) in other frameworks
and libraries.

Today, the Pop PHP Framework maintains its simplicity and is still
lightweight. And, even though many new features have been built in,
the framework can still easily be used as merely a toolbox, or as a
major framework for the foundation of your applications.

To see a list of the new and vastly improved features in the framework,
view the CHANGELOG.md file.


FEATURES
--------
The Pop PHP Framework is an object-oriented PHP framework with an
easy-to-use API to access and utilize the following components:

* Archive
* Auth
* Cache
* Cli
* Code
* Color
* Compress
* Config
* Crypt
* Curl
* Data
* Db
* Dom
* Event
* Feed
* File
* Filter
* Font
* Form
* Ftp
* Geo
* Graph
* Http
* I18n
* Image
* Loader
* Log
* Mail
* Mvc
* Nav
* Paginator
* Payment
* Pdf
* Project
* Service
* Shipping
* Validator
* Version
* Web


INSTALLATION
------------
Please see INSTALL.TXT.


SYSTEM REQUIREMENTS
-------------------
The Pop PHP Framework requires PHP 5.3.0 or later.

Some dependencies for the framework to fully function are as follows:

* The Phar, Rar, Tar and Zip extensions for the Archive component
* The Bzip2, Lzf and ZLib extensions for the Compress component
* The basic crypt support and the mcrypt extension for the Crypt component
* The basic MySQL extension for basic MySQL database connections and transactions
* The MySQLi extension to utilize MySQLi to connect to and interact with MySQL databases
* The PostgreSQL extension for PostgreSQL database connections and transactions
* The SQLite3 extension for SQLite database connections and transactions
* The SqlSrv extension for Microsoft SQLServer database connections and transactions
* The OCI8 extension for Oracle database connections and transactions
* The PDO extension for utilize PDO for database connections and transactions
* The GeoIP extension to utilize the Geo component
* The GD library for image manipulation (including FreeType support)
* The Imagick extension (with ImageMagick & Ghostscript) for advanced image manipulation
* The Apc extension for the Cache component (using the Apc adapter)
* The Memcache extension for the Cache component (using the Memcached adapter)
* The DOMDocument extension for the Image\Svg component
* The SimpleXML extension for the Data, Feed, Form, I18n, Image\Svg, Payment and Shipping components
* The Soap extension for the Shipping component
* The PHP mail function and SMTP server correctly set for the Mail component
* The cURL extension for the Curl component
* FTP support enabled for the FTP component

Most of these extensions are generally included in PHP 5.3.0+, but should there be
any issues in any of these areas, please verify that the related extensions are
installed and configured properly. The PHP mail function is dependant on the whichever
mail program is available and correctly installed on the server.

A Note on ImageMagick: As of July 28th, 2011, stable testing was successful with the
following versions of the required software:

* ImageMagick 6.5.*
* Ghostscript 8.70 or 8.71
* Imagick PHP Extension 3.0.1

Any variation in the versions of the required software may contribute to the
Pop\Image\Imagick component not functioning properly.

A Note on Permissions: The following classes may require the correct permissions
to be set for the files and the directories that they access in order to work
properly. If the permissions are not set correctly, an exception or error could
be thrown within any of the following components:

* Pop\File\File
    - Pop\Archive\Archive
    - Pop\Code\Generator
    - Pop\Font\Font
    - Pop\Image\Gd
    - Pop\Image\Imagick
    - Pop\Image\Svg
    - Pop\Pdf\Pdf


QUESTIONS AND FEEDBACK
----------------------
An online overview and documentation can be found at
http://www.popphp.org/

The Pop PHP Framework is available for anonymous checkout via
GitHub at https://github.com/nicksagona/PopPHP

Further contact or comments can be emailed to info@popphp.org.


LICENSE
-------
The files in this archive are released under the Pop PHP Framework license.
You can find a copy of this license in LICENSE.txt.
