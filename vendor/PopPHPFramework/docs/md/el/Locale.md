Pop PHP Framework
=================

Documentation : Locale
----------------------

Το στοιχείο Τοπικές παρέχει γλωσσική υποστήριξη και τη λειτουργικότητα μετάφραση για την εφαρμογή σας. Μπορείτε απλά να δημιουργήσετε και να φορτώσετε τις δικές σας αρχεία XML από τις απαιτούμενες μεταφράσεις γλώσσα με τη μορφή που είχε παρουσιαστεί στην ίδια γλώσσα XML αρχεία της Ποπ.

Μπορείτε να φορτώσετε το δικό σας μετάφραση αρχεία γλώσσας, εφ 'όσον η τήρηση του προτύπου XML εγκατεστημένος στο φάκελο Pop / Τοπικές / δεδομένων.

<pre>
use Pop\Locale\Locale;

// Create a Locale object to translate to French, using your own language file.
$lang = Locale::factory('fr')->loadFile('folder/mylangfile.xml);

// Will output 'Ce champ est obligatoire.'
$lang->_e('This field is required.');

// Will return and output 'Ce champ est obligatoire.'
echo $lang->__('This field is required.');
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
