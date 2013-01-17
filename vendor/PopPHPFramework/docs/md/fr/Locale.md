Pop PHP Framework
=================

Documentation : Locale
----------------------

La composante Locale apporte un soutien linguistique et des fonctionnalités de traduction pour votre application. Vous pouvez tout simplement créer et charger vos propres fichiers XML des traductions linguistiques requises dans le format qui est décrits dans ses propres fichiers Pop langage XML.

Vous pouvez charger vos propres fichiers de traduction de langue, aussi longtemps que l'adhésion à la norme XML créé dans le dossier Pop / Locale / données.

<pre>
use Pop\Locale\Locale;

// Create a Locale object to translate to French, using your own language file.
$lang = Locale::factory('fr')->loadFile('folder/mylangfile.xml);

// Will output 'Ce champ est obligatoire.'
$lang->_e('This field is required.');

// Will return and output 'Ce champ est obligatoire.'
echo $lang->__('This field is required.');
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
