Pop PHP Framework
=================

Documentación: Información general
----------------------------------

The Pop Framework PHP es un framework orientado a objetos de PHP con un
fácil de usar API que le permite utilizar una amplia gama de funciones.
Se puede utilizar como una caja de herramientas para ayudar con rapidez
escribiendo guiones básicos, o se puede utilizar como un marco integral
para crear y personalizar a gran escala, aplicaciones robustas. En el
centro de este marco es un grupo de componentes, algunos de los cuales
se puede utilizar de forma independiente y algunas de las cuales se
pueden utilizar en tándem para aprovechar toda la potencia del marco y
PHP.

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

### Inicio Rápido

Hay dos maneras que usted puede ponerse en marcha con el Pop Framework
PHP.

Si usted está buscando para escribir algunos scripts rápidos, sólo tiene
que soltar la carpeta fuente en la carpeta de trabajo del proyecto, haga
referencia a la "Bootstrap.php 'en consecuencia en un guión y empezar a
escribir código. Usted encontrará referencias y ejemplos lo largo de
toda esta documentación que le explicará los diferentes componentes y
cómo puede utilizarlos.

Si usted está buscando para construir una aplicación a gran escala,
puede utilizar el componente CLI para crear bases del proyecto base, o
"andamiaje". De esta manera, usted puede comenzar a escribir código de
proyecto rápidamente y no tener que cargar con tener todo en marcha y
funcionando. Todo lo que tienes que hacer es definir su proyecto en un
solo archivo de instalación, ejecute el comando CLI Pop utilizando dicho
archivo y Pop hace todo el trabajo sucio por ti. Se puede llegar a
escribir código de proyecto más rápido. Revise la documentación del
componente CLI para explorar más a fondo la manera de tomar ventaja de
este componente robusto.

### El componente MVC

El componente MVC es disponibles y son útiles especialmente cuando la
construcción de una aplicación a gran escala. MVC significa
Modelo-Vista-Controlador y es un patrón de diseño que facilita una
separación bien organizado de preocupaciones. Esto permite a su
presentación, lógica de negocio y acceso a datos a todos mantenerse
separado.

El controlador recibe la entrada (es decir, una petición Web) del
usuario y en base a esa entrada, que se comunica con el modelo. El
modelo puede entonces procesar la solicitud para determinar qué datos o
de respuesta que se necesita. En ese momento, se comunican modelo y la
vista para que la vista se puede construir de la presentación, o
"vista", basada en los datos obtenidos a partir del modelo. Entonces, el
controlador se comunicará con el fin de mostrar la salida adecuada al
usuario.

Una pieza adicional del componente MVC que está disponible con el Pop
Marco PHP es un router. El router es simplemente una capa adicional en
la parte superior que hace exactamente lo que su nombre sugiere - que
las rutas de los diferentes tipos de peticiones de usuarios para sus
controladores correspondientes. En otras palabras, proporciona una
manera fácil de manejar múltiples rutas de usuario y controladores.

Muchas veces, puede ser difícil de entender el patrón de diseño MVC
hasta que realmente empieza a usarlo. Una vez hecho, sin embargo,
inmediatamente verá la ventaja de tener todo separado en fáciles de
manejar conceptos con muy poca o ninguna superposición. El controlador
se encarga de la delegación de las solicitudes, el modelo se encarga de
la lógica de negocio y su vista determina cómo mostrar el resultado al
usuario. Por el momento, este modelo supera a los viejos tiempos de
abarrotar todo en una única secuencia de comandos con numerosas include.

### El componente Db

El componente Db tiene el potencial de ser usado un poco en cualquier
aplicación. Obviamente, la clase Db proporciona acceso directo para
consultar una base de datos. Los adaptadores compatibles incluyen MySQL
nativa, MySQLi, Oracle, PDO, PostgreSQL, SQLite y SQLServer. Sirven
para normalizar el acceso de base de datos a través de diferentes
ambientes para que usted no tiene que preocuparse tanto de
reequipamiento una aplicación para trabajar con un tipo diferente de
base de datos en un entorno diferente.

La clase de registro es un componente poderoso que proporciona acceso
normalizado a los datos dentro de una base de datos, específicamente
las tablas de base de datos y los registros individuales dentro de las
tablas. La clase de registro es realmente un híbrido de la Active Record
y los patrones de la tabla Gateway. Puede proporcionar acceso a una sola
fila o registro como un patrón Active Record haría, o varias filas a la
vez, como una puerta de enlace de la tabla lo haría. Con el Pop
Framework PHP, el enfoque más común es escribir una clase hija que se
extiende a la clase de registro que representa una tabla en la base de
datos. El nombre de la clase hija debe ser el nombre de la tabla. Por
la simple creación:

    use Pop\Db\Record;

    class Users extends Record { }

se crea una clase que tiene toda la funcionalidad de la clase Record
construido en la clase y conoce el nombre de la tabla de base de datos
para consultar el nombre de la clase. Por ejemplo, se traduce 'Usuarios'
en `usuarios` o 'traduce' en `DbUsers db_users` (CamelCase se convierte
automáticamente en lower_case_underscore.) Revisar la documentación Db a
ver cómo se puede ajustar con precisión la clase de tabla secundaria.

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
