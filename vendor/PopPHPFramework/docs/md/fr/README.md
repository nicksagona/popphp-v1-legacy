Pop PHP Framework
=================

Documentation : Overview
------------------------

Le Cadre Pop PHP est un cadre PHP orienté objet avec une interface facile à utiliser l'API qui vous permettra d'utiliser un large éventail de fonctionnalités. Vous pouvez l'utiliser comme une boîte à outils pour aider à l'écriture de scripts de base rapidement, ou vous pouvez l'utiliser comme un cadre à part entière à construire et personnaliser à grande échelle, des applications robustes. Au cœur de ce cadre est un groupe de composants, dont certains peuvent être utilisés de façon indépendante et certains peuvent être utilisés en tandem pour exploiter toute la puissance du cadre et PHP.


* Archive
* Auth
* Cache
* Cli
* Code
* Color
* Compress
* Config
* Curl
* Data
* Db
* Dir
* Dom
* Feed
* File
* Filter
* Font
* Form
* Ftp
* Geo
* Graph
* Http
* Image
* Loader
* Locale
* Mail
* Mvc
* Paginator
* Payment
* Pdf
* Project
* Record
* Validator
* Version
* Web

QuickStart

----------

Il ya deux façons que vous pouvez obtenir et d'exécution avec le cadre Pop PHP.


Si vous cherchez simplement à écrire des scripts rapides, vous pouvez tout simplement laisser tomber le dossier source dans votre dossier de travail du projet, référence à la «bootstrap.php 'en conséquence dans un script et commencer à écrire du code. Vous trouverez des références et des exemples tout au long de cette documentation qui vous expliquera les différentes composantes et comment vous pouvez les utiliser.


Si vous cherchez à construire une application à plus grande échelle, vous pouvez utiliser le composant CLI pour créer la fondation de base du projet, ou «d'échafaudage». De cette façon, vous pouvez commencer à écrire le code du projet rapidement et ne pas avoir à faire tout ce fardeau avec et en cours d'exécution. Tout ce que vous avez à faire est de définir votre projet dans le fichier d'installation unique, exécutez la commande CLI Pop en utilisant ce fichier et - voilà! - Pop fait tout le sale boulot pour vous et vous pouvez obtenir à l'écriture de code de projet plus rapidement. Consultez la documentation sur la composante CLI pour explorer davantage la façon de profiter de cette composante robuste.

Le volet MVC

-----------------

Le composant MVC est disponible et s'avère particulièrement utile lors de la construction d'une application à grande échelle. MVC équivaut à Modèle-Vue-Contrôleur et est un modèle de conception qui facilite une séparation bien organisée des préoccupations. Il permet à votre logique métier de présentation et d'accès aux données à tous les être conservés séparément.


The controller receives input (i.e. a web request) from the user and based on that input, communicates that with the model. The model can then process the request to determine what data or response is needed. At that point, the model and view communicate so that the view can build the presentation, or view, based on the data obtained from the model. Then, the controller will communicate with the view to display the appropriate output to the user.

One extra piece of the MVC component that is available with the Pop PHP Framework is a router. The router is simply an additional layer on top that does exactly what its name suggests  it routes different types of user requests to their corresponding controllers. In other words, it provides an easy way to manage multiple user paths and controllers.

Souvent, il peut être difficile à saisir le design pattern MVC jusqu'à ce que vous commencer à l'utiliser. Une fois que vous faites bien, vous verrez immédiatement l'avantage d'avoir tout séparé dans un format facile à gérer avec très peu de concepts, le cas échéant, se chevauchent. Votre contrôleur gère la délégation des demandes, votre modèle gère la logique métier et votre point de vue détermine la façon d'afficher la sortie à l'utilisateur. De loin, cette tendance l'emporte sur les jours anciens de bachotage le tout dans un seul script ou de plusieurs scripts qui sont inclus dans tous les sens la création d'un grand désordre. Essayez-le et vous verrez!


Les composants Db & Record

--------------------------

Les composants Db et d'enregistrement sont deux composantes qui ont le potentiel pour être utilisé un peu dans n'importe quelle application. De toute évidence, la composante Db offre un accès direct à interroger une base de données. Les cartes prises en charge comprennent natif MySQL, MySQLi, PgSQL, SQLite et PDO. Ils servent à normaliser l'accès base de données dans des environnements différents de sorte que vous n'avez pas à s'inquiéter autant de ré-outillage d'une demande de travailler avec un autre type de base de données dans un environnement différent.


La composante d'enregistrement est un élément puissant qui fournit un accès standardisé aux données dans une base de données, en particulier les tables de bases de données et des dossiers individuels dans les tableaux. La composante d'enregistrement est vraiment un hybride de l'Active Record et les modèles Table Data Gateway. Il peut donner accès à une seule rangée ou un dossier comme un modèle Active Record serait, ou plusieurs lignes en une seule fois, comme une passerelle le tableau de données serait. Avec le Cadre Pop PHP, l'approche la plus courante est d'écrire une classe enfant qui étend la classe d'enregistrement qui représente une table dans la base de données. Le nom de la classe enfant doit être le nom de la table. En créant simplement


<pre>
use Pop\Record\Record;

class Users extends Record { }
</pre>

vous créez une classe qui possède toutes les fonctionnalités du composant d'enregistrement construit dans la classe et sait le nom de la table de base de données à interroger à partir du nom de la classe. Par exemple, se traduit par «des utilisateurs INTO` utilisateurs `ou traduit des DbUsers 'sur` db_users `(CamelCase est automatiquement converti en lower_case_underscore.) Consultez la documentation d'enregistrement pour voir comment vous pouvez affiner la classe table enfant.

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
