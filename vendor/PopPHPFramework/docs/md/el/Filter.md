Pop PHP Framework
=================

Documentation : Filter
----------------------

Το φίλτρο στοιχείο παρέχει κάποιες χρήσιμες λειτουργίες φιλτραρίσματος για string χειραγώγησης, της κρυπτογράφησης, αναζήτηση πίνακα και κάποια βασικά μαθηματικά.


<pre>
use Pop\Filter\String;

$unfiltered1 = "Hello You &lt;script type=\"text/javascript\"&gt;alert('Something Bad');&lt;/script&gt;283 &^%$ 'Dud\\e798(*0:";
$unfiltered2 = "Hello What's &lt;script type=\"text/javascript\"&gt;alert('Something Else Bad');&lt;/script&gt; happening hot stuf!";

$str1 = String::factory($unfiltered1)->stripTags()->html();
$str2 = String::factory($unfiltered2)->upper()->stripTags()->html();

// Outputs the filtered strings
echo $str1;
echo $str2;
</pre>

Εδώ είναι ένα παράδειγμα της Κρύπτης φίλτρο.


<pre>
use Pop\Filter\Crypt;

$key = md5('Pop PHP Framework');

$encrypted = Crypt::encrypt('Hello World!', $key);
echo $encrypted;

$decrypted = Crypt::decrypt($encrypted, $key);
echo $decrypted;
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
