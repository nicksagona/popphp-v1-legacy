Pop PHP Framework
=================

Documentation : Cli
-------------------

في واجهة سطر الأوامر (CLI) هو عنصر مكون من المفيد جدا أن يسمح لك تنفيذ بعض المهام المفيدة مثل:

* تقييم البيئة الحالية للتبعيات المطلوبة
* تثبيت المشروع من مشروع ملف التثبيت
* تعيين اللغة الافتراضية من تطبيق
* إنشاء خريطة فئة
* إعادة تكوين المشروع الذي تم نقله
* تحقق من الإصدار الحالي ضد آخر نسخة

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

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
