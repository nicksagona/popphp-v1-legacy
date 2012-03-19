Pop PHP Framework
=================

Documentation : Loader
----------------------

Погрузчик компонент, пожалуй, самый простой, но наиболее важным компонентом поп Framework PHP. Это компонент, который управляет автозагрузкой возможности платформы и ваши собственные приложения могут быть легко зарегистрированы с автозагрузки, чтобы загрузить свои собственные классы. Это в одиночку заменяет все те старые заявления включают Вы использовали, чтобы все вокруг. Теперь, все что вам нужно, это один требуется заявление о 'bootstrap.php "в верхней, и вы хорошо идти. По умолчанию файл загрузки содержит необходимые ссылки на Autoloader класс рамках, а затем загружает его. В загрузочном файле, вы можете легко выполнять другие функции загрузки, такие как регистрация имен вашего приложения с автозагрузки, или загрузки файла classmap уменьшить время загрузки.


<pre>
// Instantiate the autoloader object
$autoloader = new Pop\Loader\Autoloader();
$autoloader->splAutoloadRegister();

$autoloader->register('YourLib', '../vendor/YourLib/src');
$autoloader->loadClassMap('../vendor/YourLib/classmap.php');
</pre>

А если вам нужно classmap файл, созданный компонент Loader существует возможность легко генерировать classmap файл для вас.


<pre>
// Generate a classmap file
Pop\Loader\Classmap::generate('your/src/folder', 'your/src/folder/classmap.php');
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
