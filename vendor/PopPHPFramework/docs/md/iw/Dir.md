Pop PHP Framework
=================

Documentation : Dir
-------------------

הרכיבים בימוי שימושי רשימות של קבצים בספרייה, באופן רקורסיבי או לא באופן רקורסיבי. כמו כן, יש שיטה כדי לרוקן לחלוטין את המדריך, אבל זה כמובן צריך להשתמש בו בזהירות.

<pre>
use Pop\Dir\Dir;

// Create the Dir object
$dir = new Dir('../mydir);

// Loop through the files in the directory
foreach ($dir->files as $file) {
    echo $file;
}
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
