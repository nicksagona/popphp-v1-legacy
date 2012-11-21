Pop PHP Framework
=================

Documentation : Overview
------------------------

El Pop framework PHP es un marco orientado a objetos de PHP con un fácil de usar API que le permite utilizar una amplia gama de funcionalidad. Usted puede usarlo como una caja de herramientas para ayudar en forma rápida la escritura de scripts básicos, o se puede utilizar como un marco de pleno derecho para construir y personalizar en gran escala, aplicaciones robustas. En el centro del marco es un grupo de componentes, de los cuales, algunos se pueden usar de forma independiente y algunos se pueden usar en conjunto para aprovechar toda la potencia de la estructura y PHP.

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

Hay dos maneras que usted puede conseguir en marcha con el Pop framework PHP.

Si usted está buscando para escribir algunos scripts rápidos, sólo tiene que colocar la carpeta de origen en su carpeta de trabajo del proyecto, hacer referencia a la 'Bootstrap.php' en consecuencia en un guión y empezar a escribir código. Usted encontrará referencias y ejemplos lo largo de toda esta documentación que le explicará los diferentes componentes y cómo puede utilizarlos.

Si usted está buscando para construir una aplicación a gran escala, puede utilizar el componente de la CLI para crear la fundación del proyecto base, o "andamiaje". De esta manera, usted puede comenzar a escribir el código del proyecto de forma rápida y no tener que cargar con tener todo en marcha y funcionando. Todo lo que tienes que hacer es definir el proyecto en un solo archivo de instalación, ejecute el comando de la CLI Pop usando ese archivo y - ¡voilà! - Pop hace todo el trabajo sucio por ti y puedes llegar a escribir código más rápido del proyecto. Revise la documentación sobre el componente de la CLI para explorar más a fondo cómo tomar ventaja de este componente robusto.

El componente del MVC
---------------------

El componente MVC está disponible y útil sobre todo cuando la construcción de una aplicación a gran escala. MVC significa Modelo-Vista-Controlador y es un patrón de diseño que facilita una separación bien organizada de intereses. Esto permite a su presentación, lógica de negocio y acceso a los datos a todos se guardan por separado.

El controlador recibe la entrada (es decir, una petición web) por parte del usuario y en base a esa entrada, se comunica que con el modelo. El modelo puede procesar la solicitud para determinar qué datos o la respuesta que se necesita. En ese momento, se comunica el modelo y la vista para que la vista se puede construir la presentación, o "vista", basada en los datos obtenidos a partir del modelo. Entonces, el controlador se comunicará con el fin de mostrar la salida apropiada para el usuario.

Una pieza extra del componente MVC que está disponible con el Pop framework PHP es un router. El router es simplemente una capa adicional en la parte superior que hace exactamente lo que su nombre sugiere - que las rutas de los diferentes tipos de peticiones de usuarios para sus controladores correspondientes. En otras palabras, proporciona una manera fácil de manejar varias rutas de acceso de usuario y los controladores.

Muchas veces, puede ser difícil de entender el patrón de diseño MVC hasta que comiencen a utilizarlo. Una vez que usted hace, sin embargo, usted verá inmediatamente el beneficio de tener todo lo que separa en fáciles de manejar conceptos con muy poco, en su caso, la superposición. El controlador se encarga de la delegación de las solicitudes, el modelo se encarga de la lógica de negocio y su punto de vista determina cómo se muestran los resultados al usuario. Por el momento, este modelo supera a los viejos tiempos de abarrotar todo en una única secuencia de comandos o scripts que se incluyen varias por todo el lugar creando un gran desorden. Haga la prueba y verás!


Los componentes de la BD y Registro
-----------------------------------

Los componentes de la BD y el registro son dos componentes que tienen el potencial de ser utilizado un poco en cualquier aplicación. Obviamente, el componente DB proporciona un acceso directo para consultar una base de datos. Los adaptadores compatibles incluyen nativa de MySQL, MySQLi, PgSQL, SQLite y la denominación de origen. Sirven para normalizar el acceso de base de datos en entornos de modo que usted no tiene que preocuparse tanto de reequipamiento de una aplicación para trabajar con un tipo diferente de base de datos en un entorno diferente.

El componente de Registro es un componente de gran alcance que proporciona un acceso estandarizado a los datos dentro de una base de datos, específicamente las tablas de bases de datos y registros individuales dentro de las tablas. El componente de disco es realmente un híbrido de Active Record y de los patrones de datos de tabla de puerta de enlace. Puede proporcionar acceso a una sola fila o registro como un patrón de registro activo lo haría, o varias filas de una sola vez, como una puerta de enlace de datos de la tabla lo haría. Con el Pop marco de PHP, el enfoque más común es la de escribir una clase de niños que se extiende a la clase de registro que representa una tabla en la base de datos. El nombre de la clase niño debe ser el nombre de la mesa. Por la simple creación de

<pre>
use Pop\Record\Record;

class Users extends Record { }
</pre>

crear una clase que tiene toda la funcionalidad del componente construido en el Registro y la clase conoce el nombre de la tabla de base de datos para consultar desde el nombre de la clase. Por ejemplo, se traduce 'de los usuarios en `usuarios` o traduce los DbUsers' en `` db_users (CamelCase se convierte automáticamente en lower_case_underscore.) Revisar la documentación de los expedientes para ver cómo se puede ajustar con precisión la clase de tabla secundaria.

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
