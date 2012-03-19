Pop PHP Framework
=================

Documentation : Overview
------------------------

Die Pop-PHP-Framework ist ein objektorientiertes PHP-Framework mit einer einfach zu bedienende API, mit denen Sie eine breite Palette von Funktionen nutzen kann. Sie können es als eine Toolbox nutzen, um schnell mit Basic-Skripte schreiben zu unterstützen, oder Sie können ihn als vollwertigen Rahmen zu bauen und zu gestalten großflächige, robuste Anwendungen zu verwenden. Den Kern des Frameworks ist eine Gruppe von Komponenten, von denen einige unabhängig voneinander eingesetzt werden können, und einige können im Tandem zu nutzen, die volle Leistung des Frameworks und PHP eingesetzt werden.


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

Es gibt zwei Möglichkeiten, dass Sie aufstehen und laufen mit dem Pop-PHP-Framework können.


Wenn Sie gerade suchen, um ein paar schnelle Skripte schreiben, können Sie einfach auf, Quell-Ordner in Ihrem Projekt-Ordner arbeiten, verweisen die "bootstrap.php 'entsprechend in einem Skript und starten Sie das Schreiben von Code. Sie werden alle Referenzen und Beispiele in dieser Dokumentation enthalten, die die verschiedenen Komponenten erklären wird und wie Sie sie nutzen können, zu finden.


If you're looking to build a larger-scale application, you can use the CLI component to create the project's base foundation, or scaffolding. This way, you can start writing project code quickly and not have to burdened with getting everything up and running. All you have to do is define your project in single installation file, run the Pop CLI command using that file and - voila! - Pop does all the dirty work for you and you can get to writing project code faster. Review the documentation on the CLI component to further explore how to take advantage of this robust component.

Das MVC-Komponenten

-----------------

Das MVC-Komponente zur Verfügung steht und besonders nützlich bei der Erstellung einer Anwendung im großen Maßstab. MVC steht für Model-View-Controller und ist ein Entwurfsmuster, die einen gut organisierten Trennung von Bereichen erleichtert. Es ermöglicht die Präsentation, Geschäftslogik und Datenzugriff auf alle separat gehalten werden.


The controller receives input (i.e. a web request) from the user and based on that input, communicates that with the model. The model can then process the request to determine what data or response is needed. At that point, the model and view communicate so that the view can build the presentation, or view, based on the data obtained from the model. Then, the controller will communicate with the view to display the appropriate output to the user.

One extra piece of the MVC component that is available with the Pop PHP Framework is a router. The router is simply an additional layer on top that does exactly what its name suggests  it routes different types of user requests to their corresponding controllers. In other words, it provides an easy way to manage multiple user paths and controllers.

Oft kann es schwierig sein, das MVC-Entwurfsmuster erfassen, bis Sie beginnen tatsächlich benutzen. Sobald Sie aber tun, werden Sie sofort sehen den Vorteil, dass alles, was in einfach zu verwalten Konzepte mit sehr wenig voneinander getrennt, wenn überhaupt, überlappen. Ihr Controller übernimmt die Delegation von Anfragen, handhabt Ihr Modell der Business-Logik und Ihrer Sicht bestimmt, wie die Ausgabe an den Benutzer anzuzeigen. Bei weitem übertrumpft dieses Muster den alten Tagen von pauken alles in einem einzigen Skript oder verschiedenen Skripte, die alle über den Ort schaffen ein großes Durcheinander enthalten sind. Probieren Sie es aus und du wirst sehen!


Die DB & Record-Komponenten

--------------------------

Die DB-und Record-Komponenten sind zwei Komponenten, die das Potenzial genutzt ziemlich in jeder Anwendung werden müssen. Offensichtlich bietet das DB-Komponente den direkten Zugriff auf eine Datenbank abfragen. Die unterstützten Adapter gehören nativen MySQL, mysqli, PgSQL, SQLite und PDO. Sie dienen dazu, Zugriff auf die Datenbank in verschiedenen Umgebungen zu normalisieren, so dass Sie nicht so viel Sorgen um Umrüsten eine Anwendung mit einer anderen Art von Datenbank in einem anderen Umfeld zu arbeiten.


Die Record-Komponente ist eine leistungsfähige Komponente, die einen standardisierten Zugriff auf Daten innerhalb einer Datenbank, die speziell den Datenbank-Tabellen und einzelne Datensätze in den Tabellen zur Verfügung stellt. Der Rekord-Komponente ist wirklich ein Hybrid aus dem Active Record und Table Data Gateway-Muster. Es kann den Zugang zu einer einzelnen Zeile oder Platte wie ein Active Record-Muster würde, oder mehrere Zeilen auf einmal, wie ein Table Data Gateway würde. Mit der Pop-PHP-Framework, ist die häufigste Methode, um ein Kind-Klasse, die die Record-Klasse, die eine Tabelle in der Datenbank repräsentiert erstreckt schreiben. Der Name des Kindes Klasse sollte der Name der Tabelle sein. Durch einfaches Anlegen


<pre>
use Pop\Record\Record;

class Users extends Record { }
</pre>

you create a class that has all of the functionality of the Record component built in and the class knows the name of the database table to query from the class name. For example,  'Users' translates into `users` or 'DbUsers' translates into `db_users` (CamelCase is automatically converted into lower_case_underscore.) Review the Record documentation to see how you can fine tune the child table class.

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
