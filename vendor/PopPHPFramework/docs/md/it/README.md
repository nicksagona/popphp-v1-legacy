Pop PHP Framework
=================

Documentation : Overview
------------------------

Il quadro Pop PHP è un framework orientato agli oggetti PHP con un facile da usare API che vi permetterà di utilizzare una vasta gamma di funzionalità. Potete usarlo come strumento per assistere rapidamente la scrittura di script di base, oppure è possibile utilizzarlo come un vero e proprio quadro per costruire e personalizzare su larga scala, applicazioni robuste. Al centro del quadro è un gruppo di componenti, di cui, alcuni possono essere utilizzati in modo indipendente e alcuni possono essere utilizzati insieme per sfruttare la potenza completa del quadro e PHP.

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
* Image
* Loader
* Locale
* Log
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

Ci sono due modi che si possono ottenere installato e funzionante con il quadro di Pop PHP.

Se stai solo cercando di scrivere alcuni script veloci, si può semplicemente eliminare la cartella di origine nella cartella del progetto di lavoro, fare riferimento alla 'bootstrap.php' di conseguenza in uno script e iniziare a scrivere codice. Troverete tutti i riferimenti ed esempi in tutta questa documentazione che spiegherà i vari componenti e come si possono usare.

Se stai cercando di costruire una più vasta scala dell'applicazione, è possibile utilizzare il componente CLI per creare basi di base del progetto, o "impalcature". In questo modo, è possibile iniziare a scrivere codice di progetto in modo rapido e non devono gravati da ottenere tutto attivo e funzionante. Tutto quello che dovete fare è definire il progetto in unico file di installazione, eseguire il comando Pop CLI usando il file e - voilà! - Pop fa tutto il lavoro sporco per voi e si può arrivare alla scrittura di codice del progetto più velocemente. Esaminare la documentazione relativa al componente CLI di esplorare ulteriormente come trarre vantaggio da questo componente robusto.

Il MVC Component
----------------

Il componente MVC è disponibile e particolarmente utile quando si costruisce una applicazione su vasta scala. MVC sta per Model-View-Controller ed è un modello di progettazione che facilita una ben organizzata separazione degli interessi. Esso consente la presentazione, business logic e accesso ai dati a tutti essere conservati separatamente.

Il controllore riceve in ingresso (cioè una richiesta web) dall'utente e sulla base di tale ingresso, che comunica con il modello. Il modello può quindi elaborare la richiesta per determinare quali dati o di risposta è necessaria. A quel punto, comunicano modello e vista in modo che la vista può costruire la presentazione, o "vista", sulla base dei dati ottenuti dal modello. Quindi, il controllore comunica con la visualizzazione per mostrare l'uscita appropriato per l'utente.

Un pezzo in più della componente MVC che è disponibile con la Pop PHP Framework è un router. Il router è semplicemente uno strato aggiuntivo sulla parte superiore che fa esattamente ciò che suggerisce il suo nome - si indirizza diversi tipi di richieste degli utenti ai loro controllori corrispondenti. In altre parole, fornisce un modo semplice per gestire i tracciati per utenti multipli e controllori.

Spesso, può essere difficile cogliere il pattern MVC di progettazione fino a quando effettivamente iniziare ad usarlo. Una volta fatto, però, vedrete immediatamente il vantaggio di avere tutto separato in facili da gestire concetti con molto poco, se del caso, si sovrappongono. Il controller gestisce la delega delle richieste, il modello gestisce la logica di business e la vista determina come per visualizzare l'output per l'utente. Di gran lunga, questo modello trionfi dei giorni antichi di stipare tutto in un singolo script o script vari che sono inclusi in tutto il luogo creando un gran casino. Basta provare e vedrete!

I DB & Record Components
------------------------

I componenti DB e Record sono due componenti che hanno il potenziale per essere utilizzato un po 'in qualsiasi applicazione. Ovviamente, il componente Db offre un accesso diretto per interrogare un database. Le schede supportate sono native MySQL, MySQLi, PgSQL, SQLite e DOP. Essi servono a normalizzare l'accesso al database in ambienti diversi in modo che non ci si deve preoccupare tanto di re-tooling un'applicazione per lavorare con un diverso tipo di database in un ambiente diverso.

Il componente Record è un componente potente che fornisce un accesso standardizzato ai dati all'interno di un database, in particolare le tabelle del database e dei singoli record all'interno delle tabelle. Il componente record è in realtà un ibrido tra il record attivo e dati della tabella Gateway modelli. Essa può fornire l'accesso a una singola riga o disco come un modello Active Record sarebbe, o più righe in una sola volta, come un Gateway Tabella dati avrebbe fatto. Con il Framework PHP Pop, l'approccio più comune è quello di scrivere una classe figlia che estende la classe Record che rappresenta una tabella nel database. Il nome della classe figlio dovrebbe essere il nome della tabella. Con la semplice creazione di

<pre>
use Pop\Record\Record;

class Users extends Record { }
</pre>

si crea una classe che ha tutte le funzionalità del componente Record costruito e la classe conosce il nome della tabella di database da interrogare dal nome della classe. Ad esempio, si traduce 'utenti' in `utenti` o traduce dei DbUsers 'in `db_users` (CamelCase viene automaticamente convertito in lower_case_underscore.) Esaminare la documentazione Record per vedere come si può regolare con precisione la classe tabella figlio.

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
