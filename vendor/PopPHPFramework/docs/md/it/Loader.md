Pop PHP Framework
=================

Documentation : Loader
----------------------

Home

La componente Loader Ã¨ probabilmente il componente piÃ¹ semplice, ma
piÃ¹ importante del quadro Pop PHP. E 'il componente che spinge le
capacitÃ autocaricamento del framework, e la propria applicazione
possono essere facilmente registrati con il caricatore automatico per
caricare proprie classi. Questo sostituisce singlehandedly tutte queste
affermazioni vecchie di inclusione che hai usato per avere in tutto il
luogo. Ora, tutto ciÃ² che serve Ã¨ una richiedono dichiarazione del
'bootstrap.php' in alto e sei a posto. Per impostazione predefinita, il
file di bootstrap contiene il riferimento richiesto alla classe
caricatore automatico il quadro e poi lo carica su. All'interno del file
di bootstrap, Ã¨ possibile eseguire facilmente funzioni di caricamento,
quali la registrazione dello spazio dei nomi dell'applicazione con il
caricatore automatico, o il caricamento di un file classmap per
diminuire il tempo di caricamento.

    // Instantiate the autoloader object
    $autoloader = new Pop\Loader\Autoloader();
    $autoloader->splAutoloadRegister();

    $autoloader->register('YourLib', '../vendor/YourLib/src');
    $autoloader->loadClassMap('../vendor/YourLib/classmap.php');

E se avete bisogno di un file di classmap generato, il componente Loader
ha anche la funzionalitÃ di generare facilmente un file classmap per voi
pure.

    // Generate a classmap file
    Pop\Loader\Classmap::generate('your/src/folder', 'your/src/folder/classmap.php');

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
