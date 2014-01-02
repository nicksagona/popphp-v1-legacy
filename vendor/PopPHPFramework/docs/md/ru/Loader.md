Pop PHP Framework
=================

Documentation : Loader
----------------------

Home

Погрузчик компонент, вероятно, самый простой, но самый важный компонент
Pop Framework PHP. Это компонент, который управляет автозагрузкой
возможностей рамках, и ваше собственное приложение может быть легко
зарегистрированы в автозагрузчик, чтобы загрузить свои собственные
классы. Это в одиночку заменяет все эти старые отчетность включает в
себя вы использовали, чтобы иметь повсюду. Теперь все, что вам нужно,
это один требуются заявление о 'bootstrap.php "в верхней, и вы хорошо
идти. По умолчанию загрузочный файл содержит необходимые ссылки на
Autoloader класс рамках, а затем загружает его. В загрузочный файл, вы
можете легко выполнять другие функции загрузки, такие как регистрация
имен вашего приложения с автозагрузки, или загрузка файлов classmap для
уменьшения времени загрузки.

    // Instantiate the autoloader object
    $autoloader = new Pop\Loader\Autoloader();
    $autoloader->splAutoloadRegister();

    $autoloader->register('YourLib', '../vendor/YourLib/src');
    $autoloader->loadClassMap('../vendor/YourLib/classmap.php');

А если вам нужно classmap файл, созданный компонент Loader существует
возможность легко создавать classmap файл для вас.

    // Generate a classmap file
    Pop\Loader\Classmap::generate('your/src/folder', 'your/src/folder/classmap.php');

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
