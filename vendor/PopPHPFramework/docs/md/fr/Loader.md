Pop PHP Framework
=================

Documentation : Loader
----------------------

Home

Le composant Loader est probablement l'Ã©lÃ©ment le plus basique, mais
le plus important du Cadre Pop PHP. C'est l'Ã©lÃ©ment qui pousse les
capacitÃ©s chargement automatique de ce cadre, et votre propre
application peut facilement Ãªtre enregistrÃ©s auprÃ¨s de l'autochargeur
pour charger vos propres classes. Cela remplace seul, toutes ces
dÃ©clarations comprennent des vieux vous l'habitude d'avoir dans tous
les sens. Maintenant, tout ce dont vous avez besoin est un besoin
Ã©noncÃ© de la Â«bootstrap.php" en haut et vous Ãªtes bon pour aller.
Par dÃ©faut, le fichier bootstrap contient la rÃ©fÃ©rence Ã la classe
requise Autoloader le cadre, puis il charge. Dans le fichier de
dÃ©marrage, vous pouvez facilement effectuer d'autres fonctions de
chargement, telles que l'inscription d'espace de noms de votre
application avec le chargeur automatique ou le chargement d'un fichier
classmap pour diminuer le temps de chargement.

    // Instantiate the autoloader object
    $autoloader = new Pop\Loader\Autoloader();
    $autoloader->splAutoloadRegister();

    $autoloader->register('YourLib', '../vendor/YourLib/src');
    $autoloader->loadClassMap('../vendor/YourLib/classmap.php');

Et si vous avez besoin d'un fichier gÃ©nÃ©rÃ© classmap, le composant
Loader a la fonctionnalitÃ© de facilement gÃ©nÃ©rer un fichier classmap
pour vous aussi.

    // Generate a classmap file
    Pop\Loader\Classmap::generate('your/src/folder', 'your/src/folder/classmap.php');

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
