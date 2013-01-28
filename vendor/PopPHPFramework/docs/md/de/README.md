Pop PHP Framework
=================

Dokumentation: Ãœbersicht
-------------------------

Die Pop PHP Framework ist eine objektorientierte PHP-Framework mit einer
einfach zu bedienenden API, die Ihnen erlauben, eine breite Palette von
Funktionen nutzen kann. Sie kÃ¶nnen es als eine Toolbox zu verwenden, um
mit schnell schriftlich Basic Scripts unterstÃ¼tzen, oder Sie kÃ¶nnen es
als vollwertiges Rahmen zu bauen und zu gestalten groÃŸflÃ¤chige,
robuste Anwendungen. Im Kern des Rahmens ist eine Gruppe von
Komponenten, von denen einige unabhÃ¤ngig verwendet werden kann und von
denen einige in Tandem verwendet werden, um die volle Leistung
Hebelwirkung des Frameworks und PHP.

-   Archive
-   Auth
-   Cache
-   CLI
-   Code

-   Color
-   Compress
-   Config
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
-   Image
-   Loader
-   Locale

-   Log
-   Mail
-   Mvc
-   Paginator
-   Payment

-   Pdf
-   Project
-   Record
-   Service
-   Validator

-   Version
-   Web

### QuickStart

Es gibt 2 MÃ¶glichkeiten, kÃ¶nnen Sie aufstehen und laufen mit der Pop
PHP Framework.

Wenn Sie gerade suchen, um ein paar schnelle Script schreiben, kÃ¶nnen
Sie einfach fallen die Quelle Ordner in Ihrer Arbeitskopie Projektordner
verweisen die "bootstrap.php 'entsprechend in einem Skript und starten
Sie das Schreiben von Code. Sie Referenzen und Beispiele Alle in dieser
Dokumentation, die die verschiedenen Komponenten erklÃ¤ren wird und wie
Sie sie nutzen kÃ¶nnen, zu finden.

Wenn Sie schauen, um in einem grÃ¶ÃŸeren MaÃŸstab Anwendung erstellen
mÃ¶chten, kÃ¶nnen Sie das CLI-Komponente des Projekts Basis Fundament,
oder erstellen "GerÃ¼st". Auf diese Weise kÃ¶nnen Sie mit dem Schreiben
beginnen Projekt-Code schnell und nicht mit immer alles zum Laufen
belastet. Alles, was Sie tun mÃ¼ssen, ist zu definieren Ihr Projekt in
einzelne Installationsdatei, fÃ¼hren Sie den Pop-CLI-Befehl mit, dass
Datei-und Pop all die schmutzige Arbeit fÃ¼r Sie erledigt. Sie kÃ¶nnen
schriftlich Projekt-Code schneller. ÃœberprÃ¼fen Sie die Dokumentation
Ã¼ber die CLI-Komponente weiter zu erkunden, wie die Vorteile der
robusten Komponenten nehmen.

### Das MVC-Komponenten

Das MVC-Komponente ist besonders nÃ¼tzlich, wenn Bau einer
groÃŸtechnischen Anwendung. MVC steht fÃ¼r Model-View-Controller und ist
ein Design-Muster, das eine gut organisierte Trennung von Bedenken
erleichtert. Es ermÃ¶glicht Ihre PrÃ¤sentation, GeschÃ¤ftslogik und
Datenzugriff auf alle separat gehalten werden.

Der Controller empfÃ¤ngt Eingang (dh ein Web-Anfrage) von dem Benutzer
und basierend auf diesen Eingang kommuniziert, dass mit dem Modell. Das
Modell kann dann zu verarbeiten, um zu bestimmen, welche Daten oder
Antwort benÃ¶tigt wird. An diesem Punkt, das Modell und Blick
kommunizieren, so dass die Sicht aufbauen kann die PrÃ¤sentation oder
"Ansicht" auf die Daten aus dem Modell erhaltenen. Dann wird die
Steuereinheit mit der Ansicht kommunizieren, um den entsprechenden
Ausgang fÃ¼r den Benutzer anzuzeigen.

Ein zusÃ¤tzlicher Teil des MVC-Komponente, mit der Pop PHP Framework ist
ein Router. Der Router ist einfach eine zusÃ¤tzliche Schicht auf der
Oberseite, die genau das tut, was der Name schon sagt - es leitet
verschiedene Benutzeranforderungen an den entsprechenden Controller. Mit
anderen Worten, es stellt eine einfache MÃ¶glichkeit, mehrere
Benutzer-Pfade und Steuerungen zu verwalten.

Oft kann es schwierig sein, das MVC-Entwurfsmuster begreifen, wenn man
tatsÃ¤chlich beginnen es zu benutzen. Sobald Sie aber tun, werden Sie
sofort sehen, den Vorteil, dass alles in leicht zu verwaltende Konzepte
mit sehr wenig voneinander getrennt, wenn Ã¼berhaupt, Ã¼berlappen. Ihr
Controller Ã¼bernimmt die Delegation von Anfragen, Ã¼bernimmt Ihr Modell
der Business-Logik und Ihre Sicht bestimmt, wie die Ausgabe fÃ¼r den
Benutzer angezeigt. Bei weitem dieses Muster TrÃ¼mpfe die alten Zeiten
pauken alles in einem einzigen Skript mit zahlreichen beinhalten
Aussagen.

### Die Db & Record-Komponenten

Die Db und Record-Komponenten sind zwei Komponenten, die das Potenzial
genutzt ziemlich in jeder Anwendung werden mÃ¼ssen. Offensichtlich
bietet die DB-Komponente den direkten Zugriff auf eine Datenbank
abzufragen. Die unterstÃ¼tzten Adaptern zÃ¤hlen native MySQL, MySQLi,
Oracle, PDO, PostgreSQL, SQLite und SQLServer. Sie dienen dazu, Zugriff
auf die Datenbank in verschiedenen Umgebungen zu normalisieren, so dass
Sie nicht haben, um so viel kÃ¼mmern UmrÃ¼stung eine Anwendung mit einer
anderen Art von Datenbank in einer anderen Umgebung zu arbeiten.

Die Record-Komponente ist eine leistungsfÃ¤hige Komponente, die einen
standardisierten Zugriff auf Daten in einer Datenbank, die speziell den
Datenbanktabellen und einzelne DatensÃ¤tze in den Tabellen zur
VerfÃ¼gung stellt. Der Rekord-Komponente ist wirklich ein Hybrid aus dem
Active Record und Table Data Gateway Muster. Es kann Zugriff auf eine
einzelne Zeile oder Datensatz wie ein Active Record Pattern wÃ¼rde, oder
mehrere Zeilen auf einmal, wie ein Table Data Gateway wÃ¼rde. Mit dem
Pop PHP Framework ist die hÃ¤ufigste Methode, um ein Kind-Klasse, die
Record-Klasse, die eine Tabelle in der Datenbank stellt sich schreiben.
Der Name des Kindes Klasse sollte der Name der Tabelle. Durch einfaches
Erstellen

    use Pop\Record\Record;

    class Users extends Record { }

Sie erstellen eine Klasse, die die gesamte FunktionalitÃ¤t des
Record-Komponente eingebaut und die Klasse kennt den Namen der
Datenbank-Tabelle aus den Namen der Klasse abgefragt hat. Zum Beispiel,
'Users' Ã¼bersetzt in \`users\` oder 'DbUsers' Ã¼bersetzt in
\`db\_users\` (CamelCase wird automatisch in lower\_case\_underscore
umgewandelt.) ÃœberprÃ¼fen Sie die Aufnahme-Dokumentation zu sehen, wie
kÃ¶nnen Sie eine Feinabstimmung der untergeordneten Tabelle Klasse.

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
