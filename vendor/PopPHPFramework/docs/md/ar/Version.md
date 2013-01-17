Pop PHP Framework
=================

Documentation : Version
-----------------------

المكون النسخة يوفر ببساطة القدرة على تحديد أي إصدار من البوب ​​كنت الحالي لديها، وما هي أحدث البيانات المتاحة. أيضا، يتم استخدام هذا المكون من قبل مكون CLI لأداء التبعية الاختيار.

<pre>
use Pop\Version;

echo Version::getVersion();

if (Version::compareVersion(1.0) == 1) {
    echo 'The current version is less than 1.0';
} else {
    echo 'The current version is greater than or equal to 1.0';
}
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
