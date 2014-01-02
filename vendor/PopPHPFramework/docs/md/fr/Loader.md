Pop PHP Framework
=================

Documentation : Loader
----------------------

Home

Le composant Loader est probablement l'élément le plus basique, mais le
plus important du Cadre Pop PHP. C'est l'élément qui pousse les
capacités chargement automatique de ce cadre, et votre propre
application peut facilement être enregistrés auprès de l'autochargeur
pour charger vos propres classes. Cela remplace seul, toutes ces
déclarations comprennent des vieux vous l'habitude d'avoir dans tous les
sens. Maintenant, tout ce dont vous avez besoin est un besoin énoncé de
la «bootstrap.php" en haut et vous êtes bon pour aller. Par défaut, le
fichier bootstrap contient la référence à la classe requise Autoloader
le cadre, puis il charge. Dans le fichier de démarrage, vous pouvez
facilement effectuer d'autres fonctions de chargement, telles que
l'inscription d'espace de noms de votre application avec le chargeur
automatique ou le chargement d'un fichier classmap pour diminuer le
temps de chargement.

    // Instantiate the autoloader object
    $autoloader = new Pop\Loader\Autoloader();
    $autoloader->splAutoloadRegister();

    $autoloader->register('YourLib', '../vendor/YourLib/src');
    $autoloader->loadClassMap('../vendor/YourLib/classmap.php');

Et si vous avez besoin d'un fichier généré classmap, le composant Loader
a la fonctionnalité de facilement générer un fichier classmap pour vous
aussi.

    // Generate a classmap file
    Pop\Loader\Classmap::generate('your/src/folder', 'your/src/folder/classmap.php');

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
