Pop PHP Framework
=================

Documentation : Loader
----------------------

El componente Loader es probablemente el componente más básico, sin embargo, lo más importante del Pop framework PHP. Es el componente que impulsa las capacidades de carga automática del marco de trabajo, y su propia aplicación se puede registrar fácilmente con el cargador automático para cargar sus propias clases. Esto sin ayuda sustituye a todas esas viejas declaraciones incluyen los que solía tener por todo el lugar. Ahora, todo lo que necesita es un requiera la declaración de la "Bootstrap.php 'en la parte superior y ya está bueno para ir. Por defecto, el archivo de arranque contiene la referencia obligada a la clase autocargador el marco y luego lo carga. Dentro del archivo de arranque, podrá realizar otras funciones de carga, tales como el registro de espacio de nombres de la aplicación con el cargador automático, o cargar un archivo classmap para disminuir el tiempo de carga.

<pre>
// Instantiate the autoloader object
$autoloader = new Pop\Loader\Autoloader();
$autoloader->splAutoloadRegister();

$autoloader->register('YourLib', '../vendor/YourLib/src');
$autoloader->loadClassMap('../vendor/YourLib/classmap.php');
</pre>

Y si necesitas un archivo classmap generado, el componente Loader tiene la funcionalidad para generar fácilmente un archivo classmap para usted también.

<pre>
// Generate a classmap file
Pop\Loader\Classmap::generate('your/src/folder', 'your/src/folder/classmap.php');
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
