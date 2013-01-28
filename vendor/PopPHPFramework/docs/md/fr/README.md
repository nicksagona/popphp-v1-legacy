Pop PHP Framework
=================

Documentation: Vue d'ensemble
-----------------------------

Le Cadre Pop PHP est un framework PHP orientÃ©e objet avec un outil
facile Ã utiliser l'API qui vous permettra d'utiliser un large Ã©ventail
de fonctionnalitÃ©s. Vous pouvez l'utiliser comme une boÃ®te Ã outils
pour aider Ã rapidement l'Ã©criture de scripts de base, ou vous pouvez
l'utiliser comme un cadre Ã part entiÃ¨re de construire et de
personnaliser Ã grande Ã©chelle, des applications robustes. Au cÅ“ur de
ce cadre est un groupe de composants, dont certains peuvent Ãªtre
utilisÃ©es indÃ©pendamment et dont certains peuvent Ãªtre utilisÃ©s en
tandem pour exploiter toute la puissance du cadre et PHP.

-   Archive
-   Auth
-   Cache
-   CLI
-   Code

-   Color
-   Compress
-   Config
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
-   Image
-   Loader
-   Locale

-   Log
-   Mail
-   Mvc
-   Paginator
-   Payment

-   Pdf
-   Project
-   Record
-   Service
-   Validator

-   Version
-   Web

### DÃ©marrage rapide

Il ya 2 faÃ§ons que vous pouvez obtenir en marche avec le Cadre Pop PHP.

Si vous cherchez simplement Ã Ã©crire des scripts rapides, il vous
suffit de glisser le dossier source dans le dossier du projet de
travail, rÃ©fÃ©rence Ã la Â«bootstrap.php 'en consÃ©quence dans un
script et commencer Ã Ã©crire du code. Vous trouverez des rÃ©fÃ©rences
et des exemples tout au long de cette documentation qui vous expliquera
les diffÃ©rentes composantes et comment vous pouvez les utiliser.

Si vous cherchez Ã construire une application Ã plus grande Ã©chelle,
vous pouvez utiliser le composant CLI pour crÃ©er la fondation de base
du projet, ou Â«Ã©chafaudageÂ». De cette faÃ§on, vous pouvez commencer Ã
Ã©crire le code de projet rapidement et ne pas avoir Ã faire tout ce
accablÃ©s par les rails. Tout ce que vous avez Ã faire est de dÃ©finir
votre projet en fichier d'installation unique, exÃ©cutez la commande CLI
Pop utilisant ce fichier et Pop fait tout le sale boulot pour vous. Vous
pouvez accÃ©der Ã l'Ã©criture de code projet plus rapidement. Consultez
la documentation sur le composant CLI d'explorer davantage comment tirer
parti de cette composante robuste.

### Le composant MVC

Le composant MVC est disponible et particuliÃ¨rement utile lors de la
construction d'une application Ã grande Ã©chelle. MVC Ã©quivaut Ã
ModÃ¨le-Vue-ContrÃ´leur et est un modÃ¨le de conception qui facilite une
sÃ©paration bien organisÃ©e des prÃ©occupations. Il permet Ã votre
logique mÃ©tier de prÃ©sentation, et l'accÃ¨s aux donnÃ©es Ã tout Ãªtre
conservÃ©s sÃ©parÃ©ment.

Le contrÃ´leur reÃ§oit une entrÃ©e (par exemple une demande de
navigateur) de l'utilisateur et en fonction de cette entrÃ©e, communique
avec celui du modÃ¨le. Le modÃ¨le peut alors traiter la demande afin de
dÃ©terminer quelles sont les donnÃ©es ou la rÃ©ponse est nÃ©cessaire. Ã€
ce stade, le modÃ¨le et la vue de communiquer afin que la vue peut
construire la prÃ©sentation, ou "vue", basÃ©e sur les donnÃ©es obtenues
Ã partir du modÃ¨le. Ensuite, le contrÃ´leur communique avec la vue pour
afficher la sortie appropriÃ©e Ã l'utilisateur.

Une piÃ¨ce supplÃ©mentaire de la composante MVC qui est disponible avec
le Pop Framework PHP est un routeur. Le routeur est tout simplement une
couche supplÃ©mentaire sur le dessus qui fait exactement ce que son nom
l'indique - il achemine les diffÃ©rents types de demandes des
utilisateurs Ã leurs contrÃ´leurs correspondants. En d'autres termes, il
fournit un moyen facile de gÃ©rer les chemins d'utilisateurs multiples
et les contrÃ´leurs.

Souvent, il peut Ãªtre difficile de comprendre le motif de conception
MVC jusqu'Ã ce que vous commencer Ã l'utiliser. Une fois que vous faites
bien, vous verrez immÃ©diatement l'avantage d'avoir tout sÃ©parÃ© dans
faciles Ã gÃ©rer concepts avec trÃ¨s peu, le cas Ã©chÃ©ant, se
chevauchent. Votre contrÃ´leur gÃ¨re la dÃ©lÃ©gation de demandes, votre
modÃ¨le gÃ¨re la logique mÃ©tier et votre point de vue dÃ©termine la
faÃ§on d'afficher la sortie Ã l'utilisateur. De loin, ce modÃ¨le
l'emporte sur les temps anciens de bachotage tout dans un seul script
avec de nombreux comprennent des dÃ©clarations.

### Les composants Db & enregistrement

Les composants Db et enregistrement sont deux composantes qui ont le
potentiel d'Ãªtre utilisÃ© un peu dans n'importe quelle application. De
toute Ã©vidence, la composante Db offre un accÃ¨s direct Ã interroger
une base de donnÃ©es. Les adaptateurs pris en charge comprennent natif
MySQL, MySQLi, Oracle, AOP, PostgreSQL, SQLite et SQLServer. Ils servent
Ã normaliser l'accÃ¨s base de donnÃ©es dans des environnements
diffÃ©rents de sorte que vous n'avez pas Ã s'inquiÃ©ter autant de
rÃ©outillage une demande de travailler avec un autre type de base de
donnÃ©es dans un environnement diffÃ©rent.

Le volet enregistrement est un Ã©lÃ©ment puissant qui fournit un accÃ¨s
standardisÃ© aux donnÃ©es dans une base de donnÃ©es, en particulier les
tables de bases de donnÃ©es et les dossiers individuels dans les
tableaux. La composante record est vraiment un hybride de l'Active
Record et les habitudes Table Data Gateway. Il peut donner accÃ¨s Ã une
seule ligne ou disque comme un modÃ¨le Active Record aurait ou plusieurs
lignes Ã la fois, comme une Table Data Gateway ferait. Avec le Cadre Pop
PHP, l'approche la plus courante consiste Ã Ã©crire une classe enfant
qui Ã©tend la classe enregistrement qui reprÃ©sente une table dans la
base de donnÃ©es. Le nom de la classe de l'enfant doit Ãªtre le nom de
la table. En crÃ©ant simplement

    use Pop\Record\Record;

    class Users extends Record { }

vous crÃ©ez une classe qui dispose de toutes les fonctionnalitÃ©s du
composant enregistrement intÃ©grÃ© et la classe connaÃ®t le nom de la
table de base de donnÃ©es Ã interroger Ã partir du nom de la classe. Par
exemple, se traduit par Â«UtilisateursÂ» dans \`utilisateurs\` ou
traduit 'DbUsers' dans \`\` db\_users (CamelCase est automatiquement
converti en lower\_case\_underscore.), Consultez la documentation
d'enregistrement pour voir comment vous pouvez affiner la classe table
enfant.

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
