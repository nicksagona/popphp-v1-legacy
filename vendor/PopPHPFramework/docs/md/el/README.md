Pop PHP Framework
=================

Documentation : Overview
------------------------

Η Pop-πλαίσιο PHP είναι μια αντικειμενοστραφής πλαίσιο PHP με ένα εύκολο στη χρήση API που θα σας επιτρέψει να χρησιμοποιήσετε ένα ευρύ φάσμα λειτουργιών. Μπορείτε να το χρησιμοποιήσετε ως μια εργαλειοθήκη για να βοηθήσει με γρήγορα γραφή βασικά σενάρια, ή μπορείτε να το χρησιμοποιήσετε ως ένα ολοκληρωμένο πλαίσιο για τη δημιουργία και την προσαρμογή σε μεγάλη κλίμακα, ισχυρές εφαρμογές. Στο επίκεντρο του πλαισίου είναι μια ομάδα συστατικών στοιχείων, από τα οποία, ορισμένες από αυτές μπορούν να χρησιμοποιηθούν ανεξάρτητα και κάποιες μπορεί να χρησιμοποιηθεί σε συνδυασμό για να κινητοποιήσει πλήρως την ισχύ του πλαισίου και PHP.


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

Υπάρχουν δύο τρόποι που μπορείτε να σηκωθείτε και να λειτουργήσει με το Pop-πλαίσιο PHP.


Αν είστε απλά ψάχνουν για να γράψει κάποιες γρήγορες σενάρια, μπορείτε να ρίξετε απλά το φάκελο προέλευσης στον φάκελο του έργου σας, την αναφορά του «bootstrap.php» ανάλογα με το σενάριο και να αρχίσετε να γράφετε κώδικα. Θα βρείτε αναφορές και παραδείγματα σε όλη τη διάρκεια αυτής της τεκμηρίωσης που θα σας εξηγήσει τα διάφορα στοιχεία και το πώς μπορείτε να τα χρησιμοποιήσετε.


If you're looking to build a larger-scale application, you can use the CLI component to create the project's base foundation, or scaffolding. This way, you can start writing project code quickly and not have to burdened with getting everything up and running. All you have to do is define your project in single installation file, run the Pop CLI command using that file and - voila! - Pop does all the dirty work for you and you can get to writing project code faster. Review the documentation on the CLI component to further explore how to take advantage of this robust component.

Η συνιστώσα MVC

-----------------

Η συνιστώσα MVC είναι διαθέσιμο και ιδιαίτερα χρήσιμο κατά την κατασκευή μεγάλης κλίμακας εφαρμογή. MVC σημαίνει Μοντέλο-Προβολή-Ελεγκτής και είναι ένα πρότυπο σχέδιο που διευκολύνει μια καλά οργανωμένη διαχωρισμό των ανησυχιών. Επιτρέπει την παρουσίασή σας, επιχειρηματική λογική και η πρόσβαση σε όλα τα δεδομένα πρέπει να διατηρούνται χωριστά.


The controller receives input (i.e. a web request) from the user and based on that input, communicates that with the model. The model can then process the request to determine what data or response is needed. At that point, the model and view communicate so that the view can build the presentation, or view, based on the data obtained from the model. Then, the controller will communicate with the view to display the appropriate output to the user.

One extra piece of the MVC component that is available with the Pop PHP Framework is a router. The router is simply an additional layer on top that does exactly what its name suggests  it routes different types of user requests to their corresponding controllers. In other words, it provides an easy way to manage multiple user paths and controllers.

Πολλές φορές, μπορεί να είναι δύσκολο να γίνει αντιληπτό το πρότυπο σχεδίασης MVC μέχρι να αρχίσετε πραγματικά τη χρήση του. Μόλις το κάνετε όμως, θα δείτε αμέσως το όφελος που έχουν τα πάντα διαχωρίζονται σε εύκολο στη διαχείριση των εννοιών με πολύ λίγα, εάν υπάρχουν, επικάλυψη. Το χειριστήριο χειρίζεται την αντιπροσωπεία των αιτήσεων, το μοντέλο σας χειρίζεται την επιχειρηματική λογική και την άποψή σας καθορίζει τον τρόπο εμφάνισης της εξόδου στο χρήστη. Μέχρι στιγμής, αυτό το πρότυπο ατού τις παλιές ημέρες της εσπευσμένο τα πάντα σε ένα ενιαίο σενάριο ή διάφορα σενάρια που περιλαμβάνονται σε όλη τη χώρα δημιουργώντας ένα μεγάλο χάος. Απλά να το δοκιμάσετε και θα δείτε!


Τα συστατικά Db & Εγγραφή

--------------------------

Τα στοιχεία της DB και της εγγραφής είναι δύο συστατικά που έχουν τη δυνατότητα να χρησιμοποιείται αρκετά σε οποιαδήποτε εφαρμογή. Προφανώς, το στοιχείο DB παρέχει άμεση πρόσβαση σε μια βάση δεδομένων ερώτημα. Οι προσαρμογείς υποστηρίζονται περιλαμβάνουν εγγενές MySQL, mysqli, pgsql, SQLite και ΠΟΠ. Χρησιμεύουν για την εξομάλυνση πρόσβαση σε βάσεις δεδομένων σε διαφορετικά περιβάλλοντα, έτσι ώστε να μην χρειάζεται να ανησυχούν τόσο πολύ για την εκ νέου αίτηση εργαλεία για να εργαστείτε με ένα διαφορετικό τύπο της βάσης δεδομένων σε ένα διαφορετικό περιβάλλον.


Η συνιστώσα της εγγραφής είναι ένα ισχυρό συστατικό που παρέχει πρόσβαση σε τυποποιημένα δεδομένα σε μια βάση δεδομένων, ειδικά στους πίνακες της βάσης δεδομένων και μεμονωμένες εγγραφές από τους πίνακες. Η συνιστώσα της ρεκόρ είναι πραγματικά ένα υβρίδιο της ενεργούς και τα πρότυπα πύλης πίνακα δεδομένων. Μπορεί να παρέχει πρόσβαση σε μία μόνο γραμμή ή εγγραφή σαν ένας ενεργός μοτίβο θα Εγγραφή, ή πολλαπλές σειρές σε ένα χρόνο, σαν μια πύλη πίνακα δεδομένων θα. Με την Ποπ πλαίσιο της PHP, η πιο κοινή προσέγγιση είναι να γράψει μια κατηγορία παιδί που επεκτείνει την τάξη εγγραφής που αντιπροσωπεύει έναν πίνακα στη βάση δεδομένων. Το όνομα του παιδιού στην τάξη πρέπει να είναι το όνομα του πίνακα. Με απλά δημιουργώντας


<pre>
use Pop\Record\Record;

class Users extends Record { }
</pre>

you create a class that has all of the functionality of the Record component built in and the class knows the name of the database table to query from the class name. For example,  'Users' translates into `users` or 'DbUsers' translates into `db_users` (CamelCase is automatically converted into lower_case_underscore.) Review the Record documentation to see how you can fine tune the child table class.

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
