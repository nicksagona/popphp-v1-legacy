Pop PHP Framework
=================

Documentation : Loader
----------------------

Le composant Loader est probablement l'élément le plus basique, mais le plus important du cadre de Pop PHP. C'est la composante qui pousse les capacités chargement automatique du cadre, et votre propre application peut facilement être enregistrés auprès de l'autochargeur pour charger vos propres classes. Cela remplace tout seul, tous ces états: Old-vous l'habitude d'avoir un peu partout. Maintenant, tout ce que vous avez besoin est un besoin énoncé de la «bootstrap.php" en haut et vous êtes bon pour aller. Par défaut, le fichier bootstrap contient la référence nécessaire à la classe Autoloader le cadre, puis il charge. Dans le fichier d'amorçage, vous pouvez facilement exécuter des fonctions de chargement d'autres, tels que l'enregistrement d'espace de noms de votre application avec le chargeur automatique, ou le chargement d'un fichier classmap pour diminuer le temps de chargement.

<pre>
// Instantiate the autoloader object
$autoloader = new Pop\Loader\Autoloader();
$autoloader->splAutoloadRegister();

$autoloader->register('YourLib', '../vendor/YourLib/src');
$autoloader->loadClassMap('../vendor/YourLib/classmap.php');
</pre>

Et si vous avez besoin d'un fichier généré classmap, le composant Loader a la fonctionnalité de générer facilement un fichier classmap aussi bien pour vous.

<pre>
// Generate a classmap file
Pop\Loader\Classmap::generate('your/src/folder', 'your/src/folder/classmap.php');
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
