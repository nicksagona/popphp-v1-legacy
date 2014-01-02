Pop PHP Framework
=================

Documentation : Version
-----------------------

Home

المكون النسخة بمجرد النص على القدرة على تحديد أي إصدار من البوب
​​الحالية التي لديك، وما هي أحدث البيانات المتاحة. أيضا، يتم استخدام هذا
المكون من قبل مكون CLI لأداء التبعية الاختيار.

    use Pop\Version;

    echo Version::getVersion();

    if (Version::compareVersion(1.0) == 1) {
        echo 'The current version is less than 1.0';
    } else {
        echo 'The current version is greater than or equal to 1.0';
    }

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
