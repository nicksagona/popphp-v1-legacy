Pop PHP Framework
=================

Documentation : Record
----------------------

La composante d'enregistrement, comme indiqué dans la vue d'ensemble de la documentation, est un «hybride» de toutes sortes entre les Active Record et les modèles Table Data Gateway. Via une API normalisée, elle peut donner accès à une seule ligne ou enregistrement dans une table de base de données, ou plusieurs lignes ou des dossiers à la fois. L'approche la plus courante est d'écrire une classe enfant qui étend la classe d'enregistrement qui représente une table dans la base de données. Le nom de la classe enfant doit être le nom de la table. En créant simplement

<pre>
use Pop\Record\Record;

class Users extends Record { }
</pre>

vous créez une classe qui possède toutes les fonctionnalités du composant d'enregistrement construit dans la classe et sait le nom de la table de base de données à interroger à partir du nom de la classe. Par exemple, se traduit par «des utilisateurs INTO` utilisateurs `ou traduit des DbUsers 'sur` db_users `(CamelCase est automatiquement converti en lower_case_underscore.) De là, vous pouvez affiner la classe enfant qui représente la table avec des propriétés de classe divers tels que :

<pre>
// Table prefix, if applicable
protected $prefix = null;

// Primary ID, if applicable, defaults to 'id'
protected $primaryId = 'id';

// Whether the table is auto-incrementing or not
protected $auto = true;

// Whether to use prepared statements or not, defaults to true
protected $usePrepared = true;
</pre>

De là, l'utilisation de base est la suivante:

<pre>
use Users;

// Get a single user
$user = Users::findById(1001);
echo $user->name;
echo $user->email;

// Get multiple users
$users = Users::findAll('last_name ASC');
foreach ($users->rows as $user) {
    echo $user->name;
    echo $user->email;
}
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
