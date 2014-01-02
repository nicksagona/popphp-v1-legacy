Pop PHP Framework
=================

Documentation : Crypt
-----------------------

Home

מרכיב קריפטה מספק את היכולת ליצור hashes ולאמת ערכים נגד hashes אלה.כיתת Mcrypt תומכת בהצפנה דו כיוונית. סוגי הקריפטה הנתמכות הם:

    use Pop\Crypt\Bcrypt;

    $bc = new Bcrypt();
    $hash = $bc->create('12password34');

    echo $hash;

    if ($bc->verify('12password34', $hash)) {
        echo 'Verified!';
    } else {
        echo 'NOT Verified!';
    }

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
