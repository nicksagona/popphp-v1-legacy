Pop PHP Framework
=================

Dokumentation: Übersicht
------------------------

Die Pop PHP Framework ist eine objektorientierte PHP-Framework mit einer
einfach zu bedienenden API, die Ihnen erlauben, eine breite Palette von
Funktionen nutzen kann. Sie können es als eine Toolbox zu verwenden, um
mit schnell schriftlich Basic Scripts unterstützen, oder Sie können es
als vollwertiges Rahmen zu bauen und zu gestalten großflächige, robuste
Anwendungen. Im Kern des Rahmens ist eine Gruppe von Komponenten, von
denen einige unabhängig verwendet werden kann und von denen einige in
Tandem verwendet werden, um die volle Leistung Hebelwirkung des
Frameworks und PHP.

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

Es gibt 2 Möglichkeiten, können Sie aufstehen und laufen mit der Pop PHP
Framework.

Wenn Sie gerade suchen, um ein paar schnelle Script schreiben, können
Sie einfach fallen die Quelle Ordner in Ihrer Arbeitskopie Projektordner
verweisen die "bootstrap.php 'entsprechend in einem Skript und starten
Sie das Schreiben von Code. Sie Referenzen und Beispiele Alle in dieser
Dokumentation, die die verschiedenen Komponenten erklären wird und wie
Sie sie nutzen können, zu finden.

Wenn Sie schauen, um in einem größeren Maßstab Anwendung erstellen
möchten, können Sie das CLI-Komponente des Projekts Basis Fundament,
oder erstellen "Gerüst". Auf diese Weise können Sie mit dem Schreiben
beginnen Projekt-Code schnell und nicht mit immer alles zum Laufen
belastet. Alles, was Sie tun müssen, ist zu definieren Ihr Projekt in
einzelne Installationsdatei, führen Sie den Pop-CLI-Befehl mit, dass
Datei-und Pop all die schmutzige Arbeit für Sie erledigt. Sie können
schriftlich Projekt-Code schneller. Überprüfen Sie die Dokumentation
über die CLI-Komponente weiter zu erkunden, wie die Vorteile der
robusten Komponenten nehmen.

### Das MVC-Komponenten

Das MVC-Komponente ist besonders nützlich, wenn Bau einer
großtechnischen Anwendung. MVC steht für Model-View-Controller und ist
ein Design-Muster, das eine gut organisierte Trennung von Bedenken
erleichtert. Es ermöglicht Ihre Präsentation, Geschäftslogik und
Datenzugriff auf alle separat gehalten werden.

Der Controller empfängt Eingang (dh ein Web-Anfrage) von dem Benutzer
und basierend auf diesen Eingang kommuniziert, dass mit dem Modell. Das
Modell kann dann zu verarbeiten, um zu bestimmen, welche Daten oder
Antwort benötigt wird. An diesem Punkt, das Modell und Blick
kommunizieren, so dass die Sicht aufbauen kann die Präsentation oder
"Ansicht" auf die Daten aus dem Modell erhaltenen. Dann wird die
Steuereinheit mit der Ansicht kommunizieren, um den entsprechenden
Ausgang für den Benutzer anzuzeigen.

Ein zusätzlicher Teil des MVC-Komponente, mit der Pop PHP Framework ist
ein Router. Der Router ist einfach eine zusätzliche Schicht auf der
Oberseite, die genau das tut, was der Name schon sagt - es leitet
verschiedene Benutzeranforderungen an den entsprechenden Controller. Mit
anderen Worten, es stellt eine einfache Möglichkeit, mehrere
Benutzer-Pfade und Steuerungen zu verwalten.

Oft kann es schwierig sein, das MVC-Entwurfsmuster begreifen, wenn man
tatsächlich beginnen es zu benutzen. Sobald Sie aber tun, werden Sie
sofort sehen, den Vorteil, dass alles in leicht zu verwaltende Konzepte
mit sehr wenig voneinander getrennt, wenn überhaupt, überlappen. Ihr
Controller übernimmt die Delegation von Anfragen, übernimmt Ihr Modell
der Business-Logik und Ihre Sicht bestimmt, wie die Ausgabe für den
Benutzer angezeigt. Bei weitem dieses Muster Trümpfe die alten Zeiten
pauken alles in einem einzigen Skript mit zahlreichen beinhalten
Aussagen.

### Der DB-Komponente

Die Db Komponente hat das Potential, verwendet einiges in jeder
Anwendung verwendet werden. Offensichtlich bietet die Db-Klasse den
direkten Zugriff auf eine Datenbank abzufragen. Die unterstützten
Adaptern zählen native MySQL, MySQLi, Oracle, PDO, PostgreSQL, SQLite
und SQLServer. Sie dienen dazu, Zugriff auf die Datenbank in
verschiedenen Umgebungen zu normalisieren, so dass Sie nicht haben,
um so viel kümmern Umrüstung eine Anwendung mit einer anderen Art von
Datenbank in einer anderen Umgebung zu arbeiten.

Die Record-Klasse ist eine leistungsfähige Komponente, die einen
standardisierten Zugriff auf Daten in einer Datenbank, die speziell
den Datenbanktabellen und einzelne Datensätze in den Tabellen zur
Verfügung stellt. Die Record-Klasse ist wirklich ein Hybrid aus dem
Active Record und Tabelle Gateway-Muster. Es kann Zugriff auf eine
einzelne Zeile oder Datensatz wie ein Active Record Pattern würde,
oder mehrere Zeilen auf einmal, wie ein Table-Gateway würde. Mit dem
Pop PHP Framework ist die häufigste Methode, um ein Kind-Klasse, die
Record-Klasse, die eine Tabelle in der Datenbank stellt sich schreiben.
Der Name des Kindes Klasse sollte der Name der Tabelle. Indem einfach:

    use Pop\Db\Record;

    class Users extends Record { }

Sie erstellen eine Klasse, die die gesamte Funktionalität der
Record-Klasse in und die Klasse kennt den Namen der Datenbank-Tabelle
aus den Namen der Klasse abzufragen gebaut hat. Zum Beispiel, 'Users'
übersetzt in `users` oder 'DbUsers' übersetzt in `db_users` (CamelCase
wird automatisch in lower_case_underscore umgewandelt.) Überprüfen Sie
die DB-Dokumentation zu sehen, wie können Sie eine Feinabstimmung der
untergeordneten Tabelle Klasse.

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
