Pop PHP Framework
=================

Documentation : Locale
----------------------

El componente de configuración regional proporciona compatibilidad con el idioma y la funcionalidad de traducción para su aplicación. Usted puede simplemente crear y cargar sus propios archivos XML de las traducciones de idiomas requeridos en el formato que se perfiladas en las propias Pop archivos de idioma XML.


Usted puede cargar sus propios archivos de traducción de idiomas, siempre y cuando el se adhieren al estándar XML creado en la carpeta de Pop / locale / Datos.


<pre>
use Pop\Locale\Locale;

// Create a Locale object to translate to French, using your own language file.
$lang = Locale::factory('fr')->loadFile('folder/mylangfile.xml);

// Will output 'Ce champ est obligatoire.'
$lang->_e('This field is required.');

// Will return and output 'Ce champ est obligatoire.'
echo $lang->__('This field is required.');
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
