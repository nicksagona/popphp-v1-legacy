Pop PHP Framework
=================

DocumentaciÃ³n: InformaciÃ³n general
------------------------------------

The Pop Framework PHP es un framework orientado a objetos de PHP con un
fÃ¡cil de usar API que le permite utilizar una amplia gama de funciones.
Se puede utilizar como una caja de herramientas para ayudar con rapidez
escribiendo guiones bÃ¡sicos, o se puede utilizar como un marco integral
para crear y personalizar a gran escala, aplicaciones robustas. En el
centro de este marco es un grupo de componentes, algunos de los cuales
se puede utilizar de forma independiente y algunas de las cuales se
pueden utilizar en tÃ¡ndem para aprovechar toda la potencia del marco y
PHP.

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

### Inicio RÃ¡pido

Hay dos maneras que usted puede ponerse en marcha con el Pop Framework
PHP.

Si usted estÃ¡ buscando para escribir algunos scripts rÃ¡pidos, sÃ³lo
tiene que soltar la carpeta fuente en la carpeta de trabajo del
proyecto, haga referencia a la "Bootstrap.php 'en consecuencia en un
guiÃ³n y empezar a escribir cÃ³digo. Usted encontrarÃ¡ referencias y
ejemplos lo largo de toda esta documentaciÃ³n que le explicarÃ¡ los
diferentes componentes y cÃ³mo puede utilizarlos.

Si usted estÃ¡ buscando para construir una aplicaciÃ³n a gran escala,
puede utilizar el componente CLI para crear bases del proyecto base, o
"andamiaje". De esta manera, usted puede comenzar a escribir cÃ³digo de
proyecto rÃ¡pidamente y no tener que cargar con tener todo en marcha y
funcionando. Todo lo que tienes que hacer es definir su proyecto en un
solo archivo de instalaciÃ³n, ejecute el comando CLI Pop utilizando
dicho archivo y Pop hace todo el trabajo sucio por ti. Se puede llegar a
escribir cÃ³digo de proyecto mÃ¡s rÃ¡pido. Revise la documentaciÃ³n del
componente CLI para explorar mÃ¡s a fondo la manera de tomar ventaja de
este componente robusto.

### El componente MVC

El componente MVC es disponibles y son Ãºtiles especialmente cuando la
construcciÃ³n de una aplicaciÃ³n a gran escala. MVC significa
Modelo-Vista-Controlador y es un patrÃ³n de diseÃ±o que facilita una
separaciÃ³n bien organizado de preocupaciones. Esto permite a su
presentaciÃ³n, lÃ³gica de negocio y acceso a datos a todos mantenerse
separado.

El controlador recibe la entrada (es decir, una peticiÃ³n Web) del
usuario y en base a esa entrada, que se comunica con el modelo. El
modelo puede entonces procesar la solicitud para determinar quÃ© datos o
de respuesta que se necesita. En ese momento, se comunican modelo y la
vista para que la vista se puede construir de la presentaciÃ³n, o
"vista", basada en los datos obtenidos a partir del modelo. Entonces, el
controlador se comunicarÃ¡ con el fin de mostrar la salida adecuada al
usuario.

Una pieza adicional del componente MVC que estÃ¡ disponible con el Pop
Marco PHP es un router. El router es simplemente una capa adicional en
la parte superior que hace exactamente lo que su nombre sugiere - que
las rutas de los diferentes tipos de peticiones de usuarios para sus
controladores correspondientes. En otras palabras, proporciona una
manera fÃ¡cil de manejar mÃºltiples rutas de usuario y controladores.

Muchas veces, puede ser difÃ­cil de entender el patrÃ³n de diseÃ±o MVC
hasta que realmente empieza a usarlo. Una vez hecho, sin embargo,
inmediatamente verÃ¡ la ventaja de tener todo separado en fÃ¡ciles de
manejar conceptos con muy poca o ninguna superposiciÃ³n. El controlador
se encarga de la delegaciÃ³n de las solicitudes, el modelo se encarga de
la lÃ³gica de negocio y su vista determina cÃ³mo mostrar el resultado al
usuario. Por el momento, este modelo supera a los viejos tiempos de
abarrotar todo en una Ãºnica secuencia de comandos con numerosas
include.

### Los componentes DB & Record

Los componentes de DB y registro son dos componentes que tienen el
potencial de ser utilizado bastante en cualquier aplicaciÃ³n.
Obviamente, el componente Db proporciona acceso directo para consultar
una base de datos. Los adaptadores compatibles incluyen MySQL nativa,
MySQLi, Oracle, PDO, PostgreSQL, SQLite y SQLServer. Sirven para
normalizar el acceso de base de datos a travÃ©s de diferentes ambientes
para que usted no tiene que preocuparse tanto de reequipamiento una
aplicaciÃ³n para trabajar con un tipo diferente de base de datos en un
entorno diferente.

El componente de registro es un componente poderoso que proporciona
acceso normalizado a los datos dentro de una base de datos,
especÃ­ficamente las tablas de base de datos y los registros
individuales dentro de las tablas. El componente de registro es
realmente un hÃ­brido de Active Record y especificaciones Tabla patrones
Gateway. Puede proporcionar acceso a una sola fila o registro como un
patrÃ³n Active Record harÃ­a, o varias filas a la vez, como una puerta
de enlace de la tabla de datos harÃ­a. Con el Pop Framework PHP, el
enfoque mÃ¡s comÃºn es escribir una clase hija que se extiende a la
clase de registro que representa una tabla en la base de datos. El
nombre de la clase hija debe ser el nombre de la tabla. Por la simple
creaciÃ³n de

    use Pop\Record\Record;

    class Users extends Record { }

se crea una clase que tiene toda la funcionalidad del componente de
grabaciÃ³n construido en la clase y conoce el nombre de la tabla de base
de datos para consultar el nombre de la clase. Por ejemplo, se traduce
'Usuarios' en \`usuarios\` o 'traduce' en \`DbUsers db\_users\`
(CamelCase se convierte automÃ¡ticamente en lower\_case\_underscore.)
Revisar la documentaciÃ³n de grabaciÃ³n para ver cÃ³mo se puede ajustar
con precisiÃ³n la clase de tabla secundaria.

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
