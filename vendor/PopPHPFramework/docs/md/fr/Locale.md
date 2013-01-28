Pop PHP Framework
=================

Documentation : Locale
----------------------

Home

La composante Locale apporte un soutien linguistique et des
fonctionnalitÃ©s de traduction pour votre application. Vous pouvez
simplement crÃ©er et de charger vos propres fichiers XML des traductions
linguistiques requises dans le format qui a dÃ©crites dans ses propres
Pop fichiers de langue XML.

Vous pouvez charger vos propres fichiers de traduction automatique,
aussi longtemps que l'adhÃ©sion Ã la norme XML crÃ©Ã© dans le dossier
Pop / Locale / DonnÃ©es.

    use Pop\Locale\Locale;

    // Create a Locale object to translate to French, using your own language file.
    $lang = Locale::factory('fr')->loadFile('folder/mylangfile.xml);

    // Will output 'Ce champ est obligatoire.'
    $lang->_e('This field is required.');

    // Will return and output 'Ce champ est obligatoire.'
    echo $lang->__('This field is required.');

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
