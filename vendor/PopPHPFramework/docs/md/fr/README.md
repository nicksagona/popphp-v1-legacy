Pop PHP Framework
=================

Documentation: Vue d'ensemble
-----------------------------

Le Cadre Pop PHP est un framework PHP orientée objet avec un outil
facile à utiliser l'API qui vous permettra d'utiliser un large éventail
de fonctionnalités. Vous pouvez l'utiliser comme une boîte à outils pour
aider à rapidement l'écriture de scripts de base, ou vous pouvez
l'utiliser comme un cadre à part entière de construire et de
personnaliser à grande échelle, des applications robustes. Au cœur de ce
cadre est un groupe de composants, dont certains peuvent être utilisées
indépendamment et dont certains peuvent être utilisés en tandem pour
exploiter toute la puissance du cadre et PHP.

-   Archive
-   Auth
-   Cache
-   CLI
-   Code
-   Color
-   Compress
-   Config
-   Crypt
-   Curl
-   Data
-   Db
-   Dom
-   Event
-   Feed
-   File
-   Filter
-   Font
-   Form
-   Ftp
-   Geo
-   Graph
-   Http
-   I18n
-   Image
-   Loader
-   Log
-   Mail
-   Mvc
-   Nav
-   Paginator
-   Payment
-   Pdf
-   Project
-   Service
-   Shipping
-   Validator
-   Version
-   Web

### Démarrage rapide

Il ya 2 façons que vous pouvez obtenir en marche avec le Cadre Pop PHP.

Si vous cherchez simplement à écrire des scripts rapides, il vous suffit
de glisser le dossier source dans le dossier du projet de travail,
référence à la «bootstrap.php 'en conséquence dans un script et
commencer à écrire du code. Vous trouverez des références et des
exemples tout au long de cette documentation qui vous expliquera les
différentes composantes et comment vous pouvez les utiliser.

Si vous cherchez à construire une application à plus grande échelle,
vous pouvez utiliser le composant CLI pour créer la fondation de base du
projet, ou «échafaudage». De cette façon, vous pouvez commencer à écrire
le code de projet rapidement et ne pas avoir à faire tout ce accablés
par les rails. Tout ce que vous avez à faire est de définir votre projet
en fichier d'installation unique, exécutez la commande CLI Pop utilisant
ce fichier et Pop fait tout le sale boulot pour vous. Vous pouvez
accéder à l'écriture de code projet plus rapidement. Consultez la
documentation sur le composant CLI d'explorer davantage comment tirer
parti de cette composante robuste.

### Le composant MVC

Le composant MVC est disponible et particulièrement utile lors de la
construction d'une application à grande échelle. MVC équivaut à
Modèle-Vue-Contrôleur et est un modèle de conception qui facilite une
séparation bien organisée des préoccupations. Il permet à votre logique
métier de présentation, et l'accès aux données à tout être conservés
séparément.

Le contrôleur reçoit une entrée (par exemple une demande de navigateur)
de l'utilisateur et en fonction de cette entrée, communique avec celui
du modèle. Le modèle peut alors traiter la demande afin de déterminer
quelles sont les données ou la réponse est nécessaire. À ce stade, le
modèle et la vue de communiquer afin que la vue peut construire la
présentation, ou "vue", basée sur les données obtenues à partir du
modèle. Ensuite, le contrôleur communique avec la vue pour afficher la
sortie appropriée à l'utilisateur.

Une pièce supplémentaire de la composante MVC qui est disponible avec le
Pop Framework PHP est un routeur. Le routeur est tout simplement une
couche supplémentaire sur le dessus qui fait exactement ce que son nom
l'indique - il achemine les différents types de demandes des
utilisateurs à leurs contrôleurs correspondants. En d'autres termes, il
fournit un moyen facile de gérer les chemins d'utilisateurs multiples et
les contrôleurs.

Souvent, il peut être difficile de comprendre le motif de conception MVC
jusqu'à ce que vous commencer à l'utiliser. Une fois que vous faites
bien, vous verrez immédiatement l'avantage d'avoir tout séparé dans
faciles à gérer concepts avec très peu, le cas échéant, se chevauchent.
Votre contrôleur gère la délégation de demandes, votre modèle gère la
logique métier et votre point de vue détermine la façon d'afficher la
sortie à l'utilisateur. De loin, ce modèle l'emporte sur les temps
anciens de bachotage tout dans un seul script avec de nombreux
comprennent des déclarations.

### La composante Db

La composante Db a le potentiel d'être utilisé un peu dans n'importe
quelle application. De toute évidence, la classe Db offre un accès
direct à interroger une base de données. Les adaptateurs pris en charge
comprennent natif MySQL, MySQLi, Oracle, AOP, PostgreSQL, SQLite et
SQLServer. Ils servent à normaliser l'accès base de données dans des
environnements différents de sorte que vous n'avez pas à s'inquiéter
autant de réoutillage une demande de travailler avec un autre type de
base de données dans un environnement différent.

La classe enregistrement est un élément puissant qui fournit un accès
standardisé aux données dans une base de données, en particulier les
tables de bases de données et les dossiers individuels dans les tableaux.
La classe enregistrement est vraiment un hybride de l'Active Record et
les modèles de passerelle de table. Il peut donner accès à une seule
ligne ou disque comme un modèle Active Record aurait ou plusieurs lignes
à la fois, comme une passerelle tableau ferait. Avec le Cadre Pop PHP,
l'approche la plus courante consiste à écrire une classe enfant qui étend
la classe enregistrement qui représente une table dans la base de données.
Le nom de la classe de l'enfant doit être le nom de la table. En
créant simplement:

    use Pop\Db\Record;

    class Users extends Record { }

vous créez une classe qui dispose de toutes les fonctionnalités de la
classe enregistrement intégré et la classe connaît le nom de la table
de base de données à interroger à partir du nom de la classe. Par
exemple, se traduit par «Utilisateurs» dans `utilisateurs` ou traduit
'DbUsers' dans `` db_users (CamelCase est automatiquement converti en
lower_case_underscore.), Consultez la documentation Db pour voir comment
vous pouvez affiner la classe table enfant.

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
