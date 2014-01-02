Pop PHP Framework
=================

Documentation : Overview
------------------------

The Pop PHP Framework is an object-oriented PHP framework with an
easy-to-use API that will allow you to utilize a wide range of
functionality. You can use it as a toolbox to assist with quickly
writing basic scripts, or you can use it as a full-fledged framework to
build and customize large-scale, robust applications. At the core of the
framework is a group of components, some of which can be used
independently and some of which can be used in tandem to leverage the
full power of the framework and PHP.

-   Archive
-   Auth
-   Cache
-   CLI
-   Code
-   Color
-   Compress
-   Config
-   Crypt
-   Curl
-   Data
-   Db
-   Dom
-   Event
-   Feed
-   File
-   Filter
-   Font
-   Form
-   Ftp
-   Geo
-   Graph
-   Http
-   I18n
-   Image
-   Loader
-   Log
-   Mail
-   Mvc
-   Nav
-   Paginator
-   Payment
-   Pdf
-   Project
-   Service
-   Shipping
-   Validator
-   Version
-   Web

### QuickStart

There are 2 ways that you can get up and running with the Pop PHP
Framework.

If you're just looking to write some quick scripts, you can simply drop
the source folder into your working project folder, reference the
'bootstrap.php' accordingly in a script and start writing code. You'll
find references and examples all throughout this documentation that will
explain the different components and how you can use them.

If you're looking to build a larger-scale application, you can use the
CLI component to create the project's base foundation, or "scaffolding."
This way, you can start writing project code quickly and not have to
burdened with getting everything up and running. All you have to do is
define your project in single installation file, run the Pop CLI command
using that file and Pop does all the dirty work for you. You can get to
writing project code faster. Review the documentation on the CLI
component to further explore how to take advantage of this robust
component.

### The MVC Component

The MVC component is available and especially useful when building a
large-scale application. MVC stands for Model-View-Controller and is a
design pattern that facilitates a well-organized separation of concerns.
It allows your presentation, business logic and data access to all be
kept separately.

The controller receives input (i.e. a web request) from the user and
based on that input, communicates that with the model. The model can
then process the request to determine what data or response is needed.
At that point, the model and view communicate so that the view can build
the presentation, or "view," based on the data obtained from the model.
Then, the controller will communicate with the view to display the
appropriate output to the user.

One extra piece of the MVC component that is available with the Pop PHP
Framework is a router. The router is simply an additional layer on top
that does exactly what its name suggests - it routes different types of
user requests to their corresponding controllers. In other words, it
provides an easy way to manage multiple user paths and controllers.

Often times, it can be difficult to grasp the MVC design pattern until
you actually start using it. Once you do though, you'll immediately see
the benefit of having everything separated out in easy-to-manage
concepts with very little, if any, overlap. Your controller handles the
delegation of requests, your model handles the business logic and your
view determines how to display the output to the user. By far, this
pattern trumps the olden days of cramming everything into a single
script with numerous include statements.

### The Db Component

The Db component has the potential to be used quite a bit in any
application. Obviously, the Db class provides direct access to query a
database. The supported adapters include native MySQL, MySQLi, Oracle,
PDO, PostgreSQL, Sqlite and SQLServer. They serve to normalize database
access across different environments so that you don't have to worry as
much about re-tooling an application to work with a different type of
database in a different environment.

The Record class is a powerful component that provides standardized
access to data within a database, specifically the database tables and
individual records within the tables. The Record class is really a
hybrid of the Active Record and Table Gateway patterns. It can provide
access to a single row or record like an Active Record pattern would,
or multiple rows at one time, like a Table Gateway would. With the Pop
PHP Framework, the most common approach is to write a child class that
extends the Record class that represents a table in the database. The
name of the child class should be the name of the table. By simply
creating:

    use Pop\Db\Record;

    class Users extends Record { }

you create a class that has all of the functionality of the Record
class built in and the class knows the name of the database table to
query from the class name. For example,  'Users' translates into
\`users\` or 'DbUsers' translates into \`db_users\` (CamelCase is
automatically converted into lower_case_underscore.) Review the Db
documentation to see how you can fine tune the child table class.

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
