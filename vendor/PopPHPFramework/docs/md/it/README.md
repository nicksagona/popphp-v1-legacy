Pop PHP Framework
=================

Documentazione: Panoramica
--------------------------

Il quadro Pop PHP è un framework orientato agli oggetti di PHP con un
facile da usare API che permette di utilizzare una vasta gamma di
funzionalità. Si può usare una funzione strumentale per assistere
rapidamente la scrittura di script di base, oppure è possibile
utilizzarlo come un vero e proprio quadro di riferimento per costruire e
personalizzare su larga scala, applicazioni robuste. Al centro del
quadro è un gruppo di componenti, alcuni dei quali possono essere usati
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

Ci sono 2 modi che si possono ottenere installato e funzionante con il
quadro di Pop PHP.

Se stai solo cercando di scrivere alcuni script veloce, si può
semplicemente eliminare la cartella di origine nella cartella del
progetto di lavoro, fare riferimento alla 'bootstrap.php' di conseguenza
in uno script e iniziare a scrivere codice. Troverete riferimenti ed
esempi in tutta questa documentazione che spiegherà le diverse
componenti e come si possono usare.

Se stai cercando di costruire una più grande scala applicazione, è
possibile utilizzare il componente CLI per creare basi di base del
progetto, o "impalcature". In questo modo, è possibile iniziare a
scrivere codice di progetto in modo rapido e non hanno a carico di
ottenere tutto attivo e funzionante. Tutto quello che dovete fare è
definire il progetto in unico file di installazione, eseguire il comando
Pop CLI utilizzando il file e Pop fa tutto il lavoro sporco per voi. Si
può arrivare a scrivere codice più velocemente progetto. Rivedere la
documentazione sul componente CLI di esplorare ulteriormente in che modo
sfruttare questo componente robusto.

### La componente MVC

Il componente MVC è disponibile ed è particolarmente utile quando si
costruisce una applicazione su vasta scala. MVC sta per
Model-View-Controller ed è un modello di progettazione che facilita una
ben organizzata separazione degli interessi. Esso consente la
presentazione, logica di business e di accesso ai dati a tutti essere
conservati separatamente.

Il controllore riceve input (cioè una richiesta web) da parte
dell'utente e sulla base di tale ingresso, che comunica con il modello.
Il modello può quindi elaborare la richiesta per determinare quali dati
o di risposta è necessario. A quel punto, il modello e comunicano vista
in modo che la visualizzazione può costruire la presentazione, o
"vista", in base ai dati ottenuti dal modello. Poi, il controllore
comunica con la visualizzazione per mostrare l'output appropriato per
l'utente.

Un pezzo in più della componente MVC che è disponibile con la Pop PHP
Framework è un router. Il router è semplicemente uno strato aggiuntivo
sulla parte superiore che fa esattamente ciò che suggerisce il nome - si
indirizza diversi tipi di richieste degli utenti ai loro rispettivi
controlli. In altre parole, fornisce un modo semplice per gestire i
percorsi più utenti e controllori.

Spesso, può essere difficile cogliere il pattern MVC di progettazione
fino a che realmente iniziare ad usarlo. Una volta fatto, però, vedrete
immediatamente il vantaggio di avere tutto separato in facili da gestire
con concetti molto poco, se del caso, si sovrappongono. Il controller
gestisce la delega delle richieste, il modello gestisce la logica di
business e la vostra vista determina come visualizzare l'output per
l'utente. Di gran lunga, questo trionfi motivo i vecchi tempi di stipare
tutto in un unico script con numerosi includono dichiarazioni.

### La componente Db

Il componente Db ha il potenziale di essere usato un po 'in qualsiasi
applicazione. Ovviamente, la classe Db offre accesso diretto a interrogare
un database. Gli adattatori supportati includono MySQL nativo, MySQLi,
Oracle, DOP, PostgreSQL, SQLite e SQLServer. Essi servono a normalizzare
l'accesso al database in ambienti diversi in modo che non ci si deve
preoccupare tanto di re-tooling un'applicazione per lavorare con un
diverso tipo di database in un ambiente diverso.

La classe Record è un componente potente che fornisce un accesso standard
ai dati all'interno di un database, in particolare le tabelle del database
e dei singoli record all'interno delle tabelle. La classe Record è in
realtà un ibrido di Active Record e modelli Gateway Tabella. E 'in grado
di fornire l'accesso a una singola riga o disco come un pattern Active
Record sia, o più righe in una sola volta, come un gateway tabella sarebbe.
Con il quadro Pop PHP, l'approccio più comune è quello di scrivere una
classe figlia che estende la classe record che rappresenta una tabella
nel database. Il nome della classe figlio dovrebbe essere il nome della
tabella. Con la semplice creazione di:

    use Pop\Db\Record;

    class Users extends Record { }

si crea una classe che dispone di tutte le funzionalità della classe
Record costruito e la classe conosce il nome della tabella di database
per eseguire query dal nome della classe. Ad esempio, si traduce 'utenti
INTO `utenti` o si traduce "DbUsers' in` `db_users (CamelCase viene
automaticamente convertito in lower_case_underscore.) Commenta la
documentazione Db per vedere come è possibile regolare con precisione la
classe tabella figlio.

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
