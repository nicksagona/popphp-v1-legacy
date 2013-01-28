Pop PHP Framework
=================

Documentation : Locale
----------------------

Home

El componente de configuraciÃ³n regional proporciona apoyo lingÃ¼Ã­stico
y funcionalidad de traducciÃ³n para su aplicaciÃ³n. Usted puede
simplemente crear y cargar sus propios archivos XML de las traducciones
de la lengua requeridos en el formato que se describen en propias radios
de archivos de idioma XML.

Usted puede cargar sus propios archivos de traducciÃ³n de idiomas,
siempre y cuando el adherirse a la norma XML creado en la carpeta Pop /
locale / Datos.

    use Pop\Locale\Locale;

    // Create a Locale object to translate to French, using your own language file.
    $lang = Locale::factory('fr')->loadFile('folder/mylangfile.xml);

    // Will output 'Ce champ est obligatoire.'
    $lang->_e('This field is required.');

    // Will return and output 'Ce champ est obligatoire.'
    echo $lang->__('This field is required.');

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
