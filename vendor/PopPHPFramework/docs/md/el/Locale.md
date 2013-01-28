Pop PHP Framework
=================

Documentation : Locale
----------------------

Home

Î¤Î¿ ÏƒÏ„Î¿Î¹Ï‡ÎµÎ¯Î¿ Î¤Î¿Ï€Î¹ÎºÎ­Ï‚ Ï€Î±Ï?Î­Ï‡ÎµÎ¹ Î³Î»Ï‰ÏƒÏƒÎ¹ÎºÎ®
Ï…Ï€Î¿ÏƒÏ„Î®Ï?Î¹Î¾Î· ÎºÎ±Î¹ Ï„Î· Î»ÎµÎ¹Ï„Î¿Ï…Ï?Î³Î¹ÎºÏŒÏ„Î·Ï„Î±
Î¼ÎµÏ„Î¬Ï†Ï?Î±ÏƒÎ· Î³Î¹Î± Ï„Î·Î½ ÎµÏ†Î±Ï?Î¼Î¿Î³Î® ÏƒÎ±Ï‚.
ÎœÏ€Î¿Ï?ÎµÎ¯Ï„Îµ Î±Ï€Î»Î¬ Î½Î± Î´Î·Î¼Î¹Î¿Ï…Ï?Î³Î®ÏƒÎµÏ„Îµ ÎºÎ±Î¹ Î½Î±
Ï†Î¿Ï?Ï„ÏŽÏƒÎµÏ„Îµ Ï„Î¹Ï‚ Î´Î¹ÎºÎ­Ï‚ ÏƒÎ±Ï‚ Î±Ï?Ï‡ÎµÎ¯Î± XML Ï„Ï‰Î½
Î±Ï€Î±Î¹Ï„Î¿Ï?Î¼ÎµÎ½Ï‰Î½ Î¼ÎµÏ„Î±Ï†Ï?Î¬ÏƒÎµÏ‰Î½ Î³Î»ÏŽÏƒÏƒÎ± Î¼Îµ Ï„Î·
Î¼Î¿Ï?Ï†Î® Ï€Î¿Ï… ÎµÎ¯Ï‡Îµ Ï€Î±Ï?Î¿Ï…ÏƒÎ¹Î±ÏƒÏ„ÎµÎ¯ ÏƒÏ„Î·Î½ Î¯Î´Î¹Î±
Î³Î»ÏŽÏƒÏƒÎ± XML Î±Ï?Ï‡ÎµÎ¯Î± Ï„Î·Ï‚ Î Î¿Ï€.

ÎœÏ€Î¿Ï?ÎµÎ¯Ï„Îµ Î½Î± Ï†Î¿Ï?Ï„ÏŽÏƒÎµÏ„Îµ Ï„Î¹Ï‚ Î´Î¹ÎºÎ­Ï‚ ÏƒÎ±Ï‚
Î±Ï?Ï‡ÎµÎ¯Î± Î¼ÎµÏ„Î¬Ï†Ï?Î±ÏƒÎ·Ï‚ Î³Î»ÏŽÏƒÏƒÎ±, ÎµÏ† 'ÏŒÏƒÎ¿Î½ Î·
Ï„Î·Ï?Î¿Ï?Î½ Ï„Î¿ Ï€Ï?ÏŒÏ„Ï…Ï€Î¿ XML ÎµÎ³ÎºÎ±Ï„ÎµÏƒÏ„Î·Î¼Î­Î½Î¿Ï‚ ÏƒÏ„Î¿
Ï†Î¬ÎºÎµÎ»Î¿ Pop / Locale / Î´ÎµÎ´Î¿Î¼Î­Î½Ï‰Î½.

    use Pop\Locale\Locale;

    // Create a Locale object to translate to French, using your own language file.
    $lang = Locale::factory('fr')->loadFile('folder/mylangfile.xml);

    // Will output 'Ce champ est obligatoire.'
    $lang->_e('This field is required.');

    // Will return and output 'Ce champ est obligatoire.'
    echo $lang->__('This field is required.');

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
