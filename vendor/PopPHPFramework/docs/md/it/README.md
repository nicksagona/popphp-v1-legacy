Pop PHP Framework
=================

Documentazione: Panoramica
--------------------------

Il quadro Pop PHP Ã¨ un framework orientato agli oggetti di PHP con un
facile da usare API che permette di utilizzare una vasta gamma di
funzionalitÃ . Si puÃ² usare una funzione strumentale per assistere
rapidamente la scrittura di script di base, oppure Ã¨ possibile
utilizzarlo come un vero e proprio quadro di riferimento per costruire e
personalizzare su larga scala, applicazioni robuste. Al centro del
quadro Ã¨ un gruppo di componenti, alcuni dei quali possono essere usati
indipendentemente e alcuni dei quali possono essere utilizzati insieme
per sfruttare tutta la potenza del quadro e PHP.

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

Ci sono 2 modi che si possono ottenere installato e funzionante con il
quadro di Pop PHP.

Se stai solo cercando di scrivere alcuni script veloce, si puÃ²
semplicemente eliminare la cartella di origine nella cartella del
progetto di lavoro, fare riferimento alla 'bootstrap.php' di conseguenza
in uno script e iniziare a scrivere codice. Troverete riferimenti ed
esempi in tutta questa documentazione che spiegherÃ le diverse
componenti e come si possono usare.

Se stai cercando di costruire una piÃ¹ grande scala applicazione, Ã¨
possibile utilizzare il componente CLI per creare basi di base del
progetto, o "impalcature". In questo modo, Ã¨ possibile iniziare a
scrivere codice di progetto in modo rapido e non hanno a carico di
ottenere tutto attivo e funzionante. Tutto quello che dovete fare Ã¨
definire il progetto in unico file di installazione, eseguire il comando
Pop CLI utilizzando il file e Pop fa tutto il lavoro sporco per voi. Si
puÃ² arrivare a scrivere codice piÃ¹ velocemente progetto. Rivedere la
documentazione sul componente CLI di esplorare ulteriormente in che modo
sfruttare questo componente robusto.

### La componente MVC

Il componente MVC Ã¨ disponibile ed Ã¨ particolarmente utile quando si
costruisce una applicazione su vasta scala. MVC sta per
Model-View-Controller ed Ã¨ un modello di progettazione che facilita una
ben organizzata separazione degli interessi. Esso consente la
presentazione, logica di business e di accesso ai dati a tutti essere
conservati separatamente.

Il controllore riceve input (cioÃ¨ una richiesta web) da parte
dell'utente e sulla base di tale ingresso, che comunica con il modello.
Il modello puÃ² quindi elaborare la richiesta per determinare quali dati
o di risposta Ã¨ necessario. A quel punto, il modello e comunicano vista
in modo che la visualizzazione puÃ² costruire la presentazione, o
"vista", in base ai dati ottenuti dal modello. Poi, il controllore
comunica con la visualizzazione per mostrare l'output appropriato per
l'utente.

Un pezzo in piÃ¹ della componente MVC che Ã¨ disponibile con la Pop PHP
Framework Ã¨ un router. Il router Ã¨ semplicemente uno strato aggiuntivo
sulla parte superiore che fa esattamente ciÃ² che suggerisce il nome -
si indirizza diversi tipi di richieste degli utenti ai loro rispettivi
controlli. In altre parole, fornisce un modo semplice per gestire i
percorsi piÃ¹ utenti e controllori.

Spesso, puÃ² essere difficile cogliere il pattern MVC di progettazione
fino a che realmente iniziare ad usarlo. Una volta fatto, perÃ², vedrete
immediatamente il vantaggio di avere tutto separato in facili da gestire
con concetti molto poco, se del caso, si sovrappongono. Il controller
gestisce la delega delle richieste, il modello gestisce la logica di
business e la vostra vista determina come visualizzare l'output per
l'utente. Di gran lunga, questo trionfi motivo i vecchi tempi di stipare
tutto in un unico script con numerosi includono dichiarazioni.

### I Db & Record componenti

I componenti Db e Record sono due componenti che hanno il potenziale per
essere utilizzato un po 'in tutta l'applicazione. Ovviamente, il
componente Db offre accesso diretto a interrogare un database. Gli
adattatori supportati includono MySQL nativo, MySQLi, Oracle, DOP,
PostgreSQL, SQLite e SQLServer. Essi servono a normalizzare l'accesso al
database in ambienti diversi in modo che non ci si deve preoccupare
tanto di re-tooling un'applicazione per lavorare con un diverso tipo di
database in un ambiente diverso.

Il componente di registrazione Ã¨ un componente potente che fornisce un
accesso standard ai dati all'interno di un database, in particolare le
tabelle del database e singoli record all'interno delle tabelle. Il
componente di registrazione Ã¨ in realtÃ un ibrido di Active Record e
dati della tabella modelli Gateway. E 'in grado di fornire l'accesso a
una singola riga o disco come un pattern Active Record sia, o piÃ¹ righe
in una sola volta, come un gateway Tabella dati avrebbe fatto. Con il
quadro Pop PHP, l'approccio piÃ¹ comune Ã¨ quello di scrivere una classe
figlia che estende la classe record che rappresenta una tabella nel
database. Il nome della classe figlio dovrebbe essere il nome della
tabella. Con la semplice creazione di

    use Pop\Record\Record;

    class Users extends Record { }

si crea una classe che dispone di tutte le funzionalitÃ del componente
di registrazione costruito e la classe conosce il nome della tabella di
database per eseguire query dal nome della classe. Ad esempio, si
traduce 'utenti INTO \`utenti\` o si traduce "DbUsers' in\` \`db\_users
(CamelCase viene automaticamente convertito in lower\_case\_underscore.)
Esaminare la documentazione di registrazione per vedere come Ã¨
possibile regolare con precisione la classe tabella figlio.

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
