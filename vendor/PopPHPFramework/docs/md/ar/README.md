Pop PHP Framework
=================

Documentation : Overview
------------------------

في إطار PHP البوب ​​هو إطار PHP وجوه المنحى مع API للاستخدام سهلة التي تسمح لك للاستفادة من مجموعة واسعة من الوظائف. يمكنك استخدامه بمثابة أدوات للمساعدة في كتابة النصوص بسرعة الأساسية، أو يمكنك استخدامه بمثابة إطار متكامل لبناء وتخصيص واسعة النطاق، وتطبيقات قوية. في صميم الإطار هي مجموعة من العناصر، منها، ويمكن استخدام بعض بشكل مستقل ويمكن استخدام بعض جنبا إلى جنب للاستفادة من القوة الكاملة للإطار وPHP.


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

البداية السريعة

----------

هناك نوعان من الطرق التي يمكنك الحصول على وتشغيلها مع الإطار PHP البوب.


إذا كنت تبحث فقط لكتابة بعض النصوص السريعة، يمكنك ببساطة إسقاط المجلد المصدر إلى مجلد مشروع العمل، والرجوع إلى "bootstrap.php 'وفقا لذلك في السيناريو والبدء في كتابة التعليمات البرمجية. ستجد إشارات وأمثلة كل أنحاء هذه الوثائق التي تشرح العناصر المختلفة، وكيف يمكنك استخدامها.


If you're looking to build a larger-scale application, you can use the CLI component to create the project's base foundation, or scaffolding. This way, you can start writing project code quickly and not have to burdened with getting everything up and running. All you have to do is define your project in single installation file, run the Pop CLI command using that file and - voila! - Pop does all the dirty work for you and you can get to writing project code faster. Review the documentation on the CLI component to further explore how to take advantage of this robust component.

وMVC مكون

-----------------

المكون MVC هو متاح ومفيد خصوصا عند بناء تطبيق على نطاق واسع. MVC لتقف على نموذج وحدة تحكم، وعرض هو نمط التصميم الذي يسهل فصل منظمة تنظيما جيدا من المخاوف. لأنها تتيح لجميع منطقك عرض الأعمال، والوصول إلى البيانات أن تظل على حدة.


The controller receives input (i.e. a web request) from the user and based on that input, communicates that with the model. The model can then process the request to determine what data or response is needed. At that point, the model and view communicate so that the view can build the presentation, or view, based on the data obtained from the model. Then, the controller will communicate with the view to display the appropriate output to the user.

One extra piece of the MVC component that is available with the Pop PHP Framework is a router. The router is simply an additional layer on top that does exactly what its name suggests  it routes different types of user requests to their corresponding controllers. In other words, it provides an easy way to manage multiple user paths and controllers.

في كثير من الأحيان، يمكن أن يكون من الصعب فهم نمط تصميم MVC حتى تبدأ فعليا استخدامه. ذات مرة كنت تفعل الرغم من ذلك، سترى على الفور الاستفادة من وجود كل شيء يفصل في سهل إلى إدارة المفاهيم، مع القليل جدا، إن وجدت، والتداخل. جهاز تحكم يعالج وفد من الطلبات، والنموذج الخاص بك يتعامل مع منطق الأعمال وجهة نظركم يحدد كيفية عرض الإخراج للمستخدم. حتى الآن، هذا النمط ينسخ الأيام الخوالي من هدفهم كل شيء في نصي واحد أو النصوص المختلفة التي تم تضمينها في كل مكان خلق فوضى كبيرة. انها مجرد محاولة وسترون!


ديسيبل وسجل مكونات

--------------------------

مكونات DB و سجل نوعان من المكونات التي لديها القدرة على استخدامها لا بأس به في أي تطبيق. ومن الواضح أن عنصر ديسيبل يوفر الوصول المباشر إلى قاعدة بيانات الاستعلام. محولات معتمدة وتشمل الخلية الأصلية، MySQLi، PgSQL، سكليتي وشركة تنمية نفط عمان. أنها تعمل على تطبيع الوصول إلى قاعدة بيانات عبر بيئات مختلفة بحيث لم يكن لديك ما يدعو للقلق الكثير عن الأدوات إعادة تطبيق للعمل مع نوع مختلف من قاعدة البيانات في بيئة مختلفة.


المكون سجل هو عنصر قوي توفر الوصول إلى بيانات موحدة ضمن قاعدة بيانات، وتحديدا في جداول قاعدة البيانات والسجلات الفردية ضمن الجداول. المكون سجل هو في الحقيقة مزيج من السجل النشط وأنماط الجدول بوابة بيانات. يمكن أن توفر فرص الحصول على صف واحد أو تسجيل وكأنه نمط السجل النشط من شأنه، أو صفوف متعددة في وقت واحد، مثل بوابة بيانات الجدول من شأنه. مع الإطار PHP البوب، فإن النهج الأكثر شيوعا هو كتابة فئة الأطفال التي تمتد الطبقة السجل الذي يمثل الجدول في قاعدة البيانات. يجب أن يكون اسم الطبقة طفل يكون اسم الجدول. من خلال خلق ببساطة


<pre>
use Pop\Record\Record;

class Users extends Record { }
</pre>

you create a class that has all of the functionality of the Record component built in and the class knows the name of the database table to query from the class name. For example,  'Users' translates into `users` or 'DbUsers' translates into `db_users` (CamelCase is automatically converted into lower_case_underscore.) Review the Record documentation to see how you can fine tune the child table class.

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
