Pop PHP Framework
=================

Documentation : Loader
----------------------

Il componente Loader è probabilmente il componente più semplice ma più importante del quadro Pop PHP. E 'il componente che spinge le funzionalità autocaricamento il quadro, e la propria applicazione possono essere facilmente registrati con il caricatore automatico per caricare proprie classi. Questo sostituisce da solo tutte quelle vecchie dichiarazioni di inclusione che hai usato per avere tutto il luogo. Ora, tutto ciò che serve è una richiedono dichiarazione del 'bootstrap.php' in alto e sei a posto. Per impostazione predefinita, il file di bootstrap contiene il riferimento alla classe richiesta Autoloader il quadro e poi lo carica su. All'interno del file di bootstrap, è possibile eseguire facilmente funzioni di caricamento di altri, quali la registrazione dello spazio dei nomi dell'applicazione con il caricatore automatico, o il caricamento di un file classmap per diminuire il tempo di caricamento.

<pre>
// Instantiate the autoloader object
$autoloader = new Pop\Loader\Autoloader();
$autoloader->splAutoloadRegister();

$autoloader->register('YourLib', '../vendor/YourLib/src');
$autoloader->loadClassMap('../vendor/YourLib/classmap.php');
</pre>

E se avete bisogno di un file generato classmap, il componente Loader ha la funzionalità di generare facilmente un file classmap per voi pure.

<pre>
// Generate a classmap file
Pop\Loader\Classmap::generate('your/src/folder', 'your/src/folder/classmap.php');
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
