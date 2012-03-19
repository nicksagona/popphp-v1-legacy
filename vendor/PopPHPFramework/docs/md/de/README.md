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


Wenn Sie schauen, um in einem größeren Maßstab Anwendung erstellen möchten, können Sie das CLI-Komponente, um das Projekt Basis-Stiftung, oder erstellen "Gerüst". Auf diese Weise können Sie mit dem Schreiben beginnen Projekt Code schnell und nicht mit, um alles zum Laufen belastet. Alles, was Sie tun müssen ist, definieren Sie Ihr Projekt in einzelne Installationsdatei, führen Sie den Pop-CLI-Befehl verwenden diese Datei und - voilà! - Pop macht die ganze schmutzige Arbeit für Sie und Sie können das Schreiben Projekt Code schneller zu bekommen. Lesen Sie die Dokumentation auf der CLI-Komponente weiter zu erkunden, wie man die Vorteile dieses robusten Komponente nehmen.

Das MVC-Komponenten

-----------------

Das MVC-Komponente zur Verfügung steht und besonders nützlich bei der Erstellung einer Anwendung im großen Maßstab. MVC steht für Model-View-Controller und ist ein Entwurfsmuster, die einen gut organisierten Trennung von Bereichen erleichtert. Es ermöglicht die Präsentation, Geschäftslogik und Datenzugriff auf alle separat gehalten werden.

Die Steuerung empfängt Eingang (dh ein Web-Anfrage) von dem Benutzer und basierend auf dieser Eingabe, kommuniziert, dass mit dem Modell. Das Modell kann dann die Anfrage, um zu bestimmen, welche Daten oder tätig werden muss. An diesem Punkt, das Modell und Ansicht kommunizieren, so dass der Blick auf die Präsentation aufbauen kann, oder "Ansicht" auf den Daten aus dem Modell erzielt wurden. Dann wird die Steuerung im Hinblick kommunizieren, um die entsprechenden Anschlüsse mit dem Benutzer angezeigt werden.

Ein zusätzliches Gepäckstück des MVC-Komponente, die zur Verfügung mit dem Pop-PHP-Framework ist ein Router ist. Der Router ist einfach eine zusätzliche Schicht auf der Oberseite, die genau das tut, was der Name vermuten lässt - es leitet verschiedene Benutzeranforderungen zu den entsprechenden Controller. Mit anderen Worten, es eine einfache Möglichkeit, mehrere Benutzer Pfade und Steuerungen zu verwalten.

Oft kann es schwierig sein, das MVC-Entwurfsmuster erfassen, bis Sie beginnen tatsächlich benutzen. Sobald Sie aber tun, werden Sie sofort sehen den Vorteil, dass alles, was in einfach zu verwalten Konzepte mit sehr wenig voneinander getrennt, wenn überhaupt, überlappen. Ihr Controller übernimmt die Delegation von Anfragen, handhabt Ihr Modell der Business-Logik und Ihrer Sicht bestimmt, wie die Ausgabe an den Benutzer anzuzeigen. Bei weitem übertrumpft dieses Muster den alten Tagen von pauken alles in einem einzigen Skript oder verschiedenen Skripte, die alle über den Ort schaffen ein großes Durcheinander enthalten sind. Probieren Sie es aus und du wirst sehen!


Die DB & Record-Komponenten

--------------------------

Die DB-und Record-Komponenten sind zwei Komponenten, die das Potenzial genutzt ziemlich in jeder Anwendung werden müssen. Offensichtlich bietet das DB-Komponente den direkten Zugriff auf eine Datenbank abfragen. Die unterstützten Adapter gehören nativen MySQL, mysqli, PgSQL, SQLite und PDO. Sie dienen dazu, Zugriff auf die Datenbank in verschiedenen Umgebungen zu normalisieren, so dass Sie nicht so viel Sorgen um Umrüsten eine Anwendung mit einer anderen Art von Datenbank in einem anderen Umfeld zu arbeiten.


Die Record-Komponente ist eine leistungsfähige Komponente, die einen standardisierten Zugriff auf Daten innerhalb einer Datenbank, die speziell den Datenbank-Tabellen und einzelne Datensätze in den Tabellen zur Verfügung stellt. Der Rekord-Komponente ist wirklich ein Hybrid aus dem Active Record und Table Data Gateway-Muster. Es kann den Zugang zu einer einzelnen Zeile oder Platte wie ein Active Record-Muster würde, oder mehrere Zeilen auf einmal, wie ein Table Data Gateway würde. Mit der Pop-PHP-Framework, ist die häufigste Methode, um ein Kind-Klasse, die die Record-Klasse, die eine Tabelle in der Datenbank repräsentiert erstreckt schreiben. Der Name des Kindes Klasse sollte der Name der Tabelle sein. Durch einfaches Anlegen


<pre>
use Pop\Record\Record;

class Users extends Record { }
</pre>

Sie erstellen eine Klasse, die die gesamte Funktionalität des Record-Komponente eingebaut und die Klasse kennt den Namen der Datenbank-Tabelle, um aus den Namen der Klasse abfragen muss. Zum Beispiel, 'Benutzer' übersetzt in `users` oder 'DbUsers' übersetzt in `` db_users (CamelCase wird automatisch in lower_case_underscore umgewandelt.) Überprüfen Sie die Record-Dokumentation zu sehen, wie können Sie eine Feinabstimmung der untergeordneten Tabelle Klasse.

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
