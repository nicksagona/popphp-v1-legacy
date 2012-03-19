Pop PHP Framework
=================

Documentation : Overview
------------------------

Поп Framework PHP представляет собой объектно-ориентированный PHP рамки с помощью простого в использовании API, которые позволят вам использовать широкий спектр функциональных возможностей. Вы можете использовать его в качестве инструментов для оказания помощи в написании быстро основных сценариев, или вы можете использовать его в качестве полноценной платформы для создания и настройки большого масштаба, надежные приложения. В центре рамки группы компонентов, из которых некоторые могут быть использованы самостоятельно, а некоторые из них могут быть использованы в тандеме, чтобы использовать все возможности базы и PHP.


* Archive
* Auth
* Cache
* Cli
* Code
* Color
* Compress
* Config
* Curl
* Data
* Db
* Dir
* Dom
* Feed
* File
* Filter
* Font
* Form
* Ftp
* Geo
* Graph
* Http
* Image
* Loader
* Locale
* Mail
* Mvc
* Paginator
* Payment
* Pdf
* Project
* Record
* Validator
* Version
* Web

QuickStart

----------

Есть два способа, которые можно получить и работает с поп Framework PHP.


Если вы просто хотите написать несколько сценариев быстро, вы можете просто отказаться от исходной папки в вашу рабочую папку проекта, ссылка на "bootstrap.php 'соответственно в сценарий и начать писать код. Вы найдете ссылки и примеры на протяжении всей этой документации, которая будет объяснить различные компоненты и как вы можете их использовать.


If you're looking to build a larger-scale application, you can use the CLI component to create the project's base foundation, or scaffolding. This way, you can start writing project code quickly and not have to burdened with getting everything up and running. All you have to do is define your project in single installation file, run the Pop CLI command using that file and - voila! - Pop does all the dirty work for you and you can get to writing project code faster. Review the documentation on the CLI component to further explore how to take advantage of this robust component.

Компонент MVC

-----------------

Компонент MVC доступен и особенно полезна при построении крупномасштабных приложений. MVC означает Model-View-Controller и шаблонов проектирования, что способствует хорошо организованное разделение интересов. Это позволяет презентации, бизнес-логики и доступа к данным для всех храниться отдельно.


The controller receives input (i.e. a web request) from the user and based on that input, communicates that with the model. The model can then process the request to determine what data or response is needed. At that point, the model and view communicate so that the view can build the presentation, or view, based on the data obtained from the model. Then, the controller will communicate with the view to display the appropriate output to the user.

One extra piece of the MVC component that is available with the Pop PHP Framework is a router. The router is simply an additional layer on top that does exactly what its name suggests  it routes different types of user requests to their corresponding controllers. In other words, it provides an easy way to manage multiple user paths and controllers.

Зачастую, это может быть трудно понять MVC шаблон дизайна, пока вы на самом деле начать использовать его. Как только вы сделаете хотя, вы сразу видите преимущество иметь все выделяется в легкой в ​​управлении понятия очень мало, если таковые имеются, перекрытия. Ваш контроллер обрабатывает запросы делегации, ваша модель обрабатывает бизнес-логику и ваше мнение определяет способ отображения выходной для пользователя. До сих пор эта модель козыри старину зубрежки все в одном сценарии или различные сценарии, которые включены повсюду создания большой беспорядок. Просто попробуйте, и вы увидите!


Db и записи компоненты

--------------------------

Db и записи компоненты состоят из двух компонентов, которые могут быть использованы совсем немного в любом приложении. Очевидно, что компоненты БД обеспечивает прямой доступ к базе данных запросов. Поддерживаемых адаптеров включает родной MySQL, MySQLi, PgSQL, SQLite и PDO. Они служат для нормализации доступа к базам данных в разных средах, так что вам не придется беспокоиться, как много о повторной инструментов приложения для работы с различными типами баз данных в различных средах.


Запись компонент представляет собой мощный компонент, который обеспечивает унифицированный доступ к данным в базе данных, в частности, таблицы базы данных и отдельных записей в таблицах. Запись компонент действительно гибрид Active Record и в таблице данных моделей Gateway. Это может обеспечить доступ к одной строки или записи как модели активной записи будет, или несколько строк в свое время, как шлюз таблицы данных будет. С поп Framework PHP, наиболее распространенный подход заключается в написании дочерний класс, который расширяет класс, запись представляет собой таблицу в базе данных. Имя ребенку класса должны быть имя таблицы. Просто создание


<pre>
use Pop\Record\Record;

class Users extends Record { }
</pre>

you create a class that has all of the functionality of the Record component built in and the class knows the name of the database table to query from the class name. For example,  'Users' translates into `users` or 'DbUsers' translates into `db_users` (CamelCase is automatically converted into lower_case_underscore.) Review the Record documentation to see how you can fine tune the child table class.

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
