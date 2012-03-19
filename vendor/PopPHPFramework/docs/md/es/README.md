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

Hay dos maneras que usted puede conseguir en marcha con el Pop framework PHP.


Si usted está buscando para escribir algunos scripts rápidos, sólo tiene que colocar la carpeta de origen en su carpeta de trabajo del proyecto, hacer referencia a la 'Bootstrap.php' en consecuencia en un guión y empezar a escribir código. Usted encontrará referencias y ejemplos lo largo de toda esta documentación que le explicará los diferentes componentes y cómo puede utilizarlos.


If you're looking to build a larger-scale application, you can use the CLI component to create the project's base foundation, or scaffolding. This way, you can start writing project code quickly and not have to burdened with getting everything up and running. All you have to do is define your project in single installation file, run the Pop CLI command using that file and - voila! - Pop does all the dirty work for you and you can get to writing project code faster. Review the documentation on the CLI component to further explore how to take advantage of this robust component.

El componente del MVC

-----------------

El componente MVC está disponible y útil sobre todo cuando la construcción de una aplicación a gran escala. MVC significa Modelo-Vista-Controlador y es un patrón de diseño que facilita una separación bien organizada de intereses. Esto permite a su presentación, lógica de negocio y acceso a los datos a todos se guardan por separado.


The controller receives input (i.e. a web request) from the user and based on that input, communicates that with the model. The model can then process the request to determine what data or response is needed. At that point, the model and view communicate so that the view can build the presentation, or view, based on the data obtained from the model. Then, the controller will communicate with the view to display the appropriate output to the user.

One extra piece of the MVC component that is available with the Pop PHP Framework is a router. The router is simply an additional layer on top that does exactly what its name suggests  it routes different types of user requests to their corresponding controllers. In other words, it provides an easy way to manage multiple user paths and controllers.

Muchas veces, puede ser difícil de entender el patrón de diseño MVC hasta que comiencen a utilizarlo. Una vez que usted hace, sin embargo, usted verá inmediatamente el beneficio de tener todo lo que separa en fáciles de manejar conceptos con muy poco, en su caso, la superposición. El controlador se encarga de la delegación de las solicitudes, el modelo se encarga de la lógica de negocio y su punto de vista determina cómo se muestran los resultados al usuario. Por el momento, este modelo supera a los viejos tiempos de abarrotar todo en una única secuencia de comandos o scripts que se incluyen varias por todo el lugar creando un gran desorden. Haga la prueba y verás!


Los componentes de la BD y Registro

--------------------------

Los componentes de la BD y el registro son dos componentes que tienen el potencial de ser utilizado un poco en cualquier aplicación. Obviamente, el componente DB proporciona un acceso directo para consultar una base de datos. Los adaptadores compatibles incluyen nativa de MySQL, MySQLi, PgSQL, SQLite y la denominación de origen. Sirven para normalizar el acceso de base de datos en entornos de modo que usted no tiene que preocuparse tanto de reequipamiento de una aplicación para trabajar con un tipo diferente de base de datos en un entorno diferente.


El componente de Registro es un componente de gran alcance que proporciona un acceso estandarizado a los datos dentro de una base de datos, específicamente las tablas de bases de datos y registros individuales dentro de las tablas. El componente de disco es realmente un híbrido de Active Record y de los patrones de datos de tabla de puerta de enlace. Puede proporcionar acceso a una sola fila o registro como un patrón de registro activo lo haría, o varias filas de una sola vez, como una puerta de enlace de datos de la tabla lo haría. Con el Pop marco de PHP, el enfoque más común es la de escribir una clase de niños que se extiende a la clase de registro que representa una tabla en la base de datos. El nombre de la clase niño debe ser el nombre de la mesa. Por la simple creación de


<pre>
use Pop\Record\Record;

class Users extends Record { }
</pre>

you create a class that has all of the functionality of the Record component built in and the class knows the name of the database table to query from the class name. For example,  'Users' translates into `users` or 'DbUsers' translates into `db_users` (CamelCase is automatically converted into lower_case_underscore.) Review the Record documentation to see how you can fine tune the child table class.

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
