Pop PHP Framework
=================

Documentation : Cli
-------------------

שורת פקודה (CLI) רכיב ממשק הוא מרכיב מאוד שימושי, המאפשר לך לבצע משימות מועילות כגון:


* להעריך את הסביבה הנוכחית של תלות הנדרשים
</li>
* התקנת פרויקט מקובץ ההתקנה הפרויקט
</li>
* לקבוע את שפת ברירת המחדל של יישום
</li>
* ליצור מפה בכיתה
</li>
* להגדיר מחדש את הפרויקט, כי כבר עבר
</li>
* לבדוק את הגרסה הנוכחית על הגרסה העדכנית ביותר
</li>

<pre>
script/pop --check                     // Check the current configuration for required dependencies
script/pop --help                      // Display this help
script/pop --install file.php          // Install a project based on the install file specified
script/pop --lang fr                   // Set the default language for the project
script/pop --map folder file.php       // Create a class map file from the source folder and save to the output file
script/pop --reconfig projectfolder    // Reconfigure the project based on the new location of the project
script/pop --show                      // Show project install instructions
script/pop --version                   // Display version of Pop PHP Framework and latest available
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
