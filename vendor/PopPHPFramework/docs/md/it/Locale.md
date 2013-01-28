Pop PHP Framework
=================

Documentation : Locale
----------------------

Home

Il componente Locale fornisce supporto per la lingua e la funzionalitÃ
di traduzione per la vostra applicazione. Si puÃ² semplicemente creare e
caricare i tuoi file XML delle traduzioni linguistiche richieste nel
formato che Ã¨ delineate nel Pop propri file di linguaggio XML.

Ãˆ possibile caricare i propri file di traduzione in lingua, fino a
quando il aderiscono allo standard XML stabilito nella Pop / Locale /
Data.

    use Pop\Locale\Locale;

    // Create a Locale object to translate to French, using your own language file.
    $lang = Locale::factory('fr')->loadFile('folder/mylangfile.xml);

    // Will output 'Ce champ est obligatoire.'
    $lang->_e('This field is required.');

    // Will return and output 'Ce champ est obligatoire.'
    echo $lang->__('This field is required.');

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
