Pop PHP Framework
=================

Documentation : Loader
----------------------

Home

El componente Loader es probablemente el componente mÃ¡s bÃ¡sico, aÃºn
mÃ¡s importante del Pop Framework PHP. Es el componente que impulsa las
capacidades de carga automÃ¡tica del marco, y su propia aplicaciÃ³n
puede estar registrados en el cargador para cargar sus propias clases.
Esto sin ayuda sustituye a todas esas viejas declaraciones incluyen que
solÃ­a tener todo el lugar. Ahora, todo lo que necesita es una
declaraciÃ³n de exigir la "Bootstrap.php 'en la parte superior y ya
estÃ¡ bueno para ir. Por defecto, el archivo de arranque contiene la
referencia obligada a la clase autocargador del marco y luego lo carga.
En el archivo de arranque, podrÃ¡ realizar otras funciones de carga,
tales como el registro de espacio de nombres de la aplicaciÃ³n con el
cargador automÃ¡tico, o cargar un archivo ClassMap para disminuir el
tiempo de carga.

    // Instantiate the autoloader object
    $autoloader = new Pop\Loader\Autoloader();
    $autoloader->splAutoloadRegister();

    $autoloader->register('YourLib', '../vendor/YourLib/src');
    $autoloader->loadClassMap('../vendor/YourLib/classmap.php');

Y si necesitas un archivo ClassMap generado, el componente Loader tiene
la funcionalidad para generar fÃ¡cilmente un archivo ClassMap para usted
tambiÃ©n.

    // Generate a classmap file
    Pop\Loader\Classmap::generate('your/src/folder', 'your/src/folder/classmap.php');

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
