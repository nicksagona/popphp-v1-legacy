Pop PHP Framework
=================

Documentation : Overview
------------------------

O Quadro PHP Pop é um objeto orientado a framework PHP com um fácil de usar API que permitirá que você utilize uma ampla gama de funcionalidades. Você pode usá-lo como uma caixa de ferramentas para auxiliar na rápida criação de scripts de base, ou você pode usá-lo como um quadro de pleno direito de construir e personalizar de grande escala, aplicações robustas. No centro do quadro é um grupo de componentes, dos quais alguns podem ser utilizados de forma independente e alguns podem ser usados ​​em conjunto para aproveitar o poder completo do quadro e PHP.

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
* Event
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
* Log
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

Há duas maneiras que você pode começar a trabalhar com o quadro Pop PHP.

Se você está olhando apenas para escrever alguns scripts rápidos, você pode simplesmente largar a pasta de origem para a pasta do projeto de trabalho, faz referência a 'bootstrap.php' de acordo em um script e começar a escrever código. Você vai encontrar referências e exemplos por toda esta documentação que vai explicar os diferentes componentes e como você pode usá-los.

Se você estiver olhando para construir uma aplicação em maior escala, você pode usar o componente CLI para criar fundação do projeto base, ou "andaimes". Dessa forma, você pode começar a escrever o código do projeto de forma rápida e não ter que arcar com obtendo tudo instalado e funcionando. Tudo que você precisa fazer é definir o seu projeto no arquivo de instalação simples, execute o comando CLI Pop usando esse arquivo e - voilà! - Pop faz todo o trabalho sujo para você e você pode começar a escrever o código do projeto mais rápido. Reveja a documentação sobre o componente CLI para explorar ainda mais como tirar proveito deste componente robusto.

O Componente MVC
----------------

O componente MVC está disponível e especialmente útil quando a construção de uma aplicação em larga escala. MVC significa Model-View-Controller e é um padrão de design que facilita a separação bem organizada de preocupações. Ele permite que a sua apresentação lógica de negócios e acesso a dados para tudo ser mantidos separadamente.

O controlador recebe a entrada (ou seja, um pedido na Internet) do usuário e com base nessa entrada, que comunica com o modelo. O modelo pode então processar o pedido para determinar quais os dados de resposta ou é necessário. Nesse ponto, se comunicam modelo e vista para que a exibição pode construir a apresentação, ou "vista", com base nos dados obtidos a partir do modelo. Em seguida, o controlador irá comunicar com o fim de exibir a saída apropriada para o utilizador.

Um pedaço extra do componente MVC que está disponível com o Pop PHP Framework é um roteador. O roteador é simplesmente uma camada adicional na parte superior que faz exatamente o que o próprio nome sugere - que direciona diferentes tipos de solicitações de usuários de seus controladores correspondentes. Em outras palavras, ele fornece uma maneira fácil de gerenciar caminhos múltiplos usuários e controladores.

Muitas vezes, pode ser difícil de entender o padrão de projeto MVC até que você realmente começar a usar. Uma vez que você faz, porém, você verá imediatamente o benefício de ter tudo separado em fáceis de gerenciar conceitos com muito pouco, se for o caso, se sobrepõem. O controlador manipula a delegação de pedidos, o modelo lida com a lógica de negócios e sua visão determina como exibir a saída para o usuário. De longe, este padrão trunfos antigamente de colocar tudo em um único script ou vários scripts que estão incluídos em todo o lugar, criando uma grande confusão. Basta experimentá-lo e você vai ver!

Os Componentes Db & Record
--------------------------

Os componentes Db e Record são dois componentes que têm o potencial de ser usado um pouco em qualquer aplicação. Obviamente, o componente Db fornece acesso direto para consultar um banco de dados. Os adaptadores suportados incluem MySQL nativa, MySQLi, PgSQL, Sqlite e DOP. Eles servem para normalizar o acesso de dados em ambientes diferentes para que você não precisa se preocupar tanto com novos equipamentos de um aplicativo para trabalhar com um tipo diferente de banco de dados em um ambiente diferente.

O componente de Registro é um componente poderoso que fornece acesso padronizado aos dados em um banco de dados, especificamente as tabelas de banco de dados e registros individuais dentro das tabelas. O componente de registro é realmente um híbrido do Active Record e padrões da tabela de dados do Gateway. Ele pode fornecer acesso a uma única linha ou registro como um padrão Active Record seria, ou várias linhas de uma só vez, como um Gateway de Tabela de Dados faria. Com o Framework PHP Pop, a abordagem mais comum é escrever uma classe filha que estende a classe Record que representa uma tabela no banco de dados. O nome de classe criança deve ser o nome da tabela. Simplesmente criando

<pre>
use Pop\Record\Record;

class Users extends Record { }
</pre>

você criar uma classe que tem toda a funcionalidade do componente registro embutido e da classe sabe o nome da tabela de banco de dados para consulta a partir do nome da classe. Por exemplo, traduz 'Usuários' em `users` ou traduz dos DbUsers 'em `db_users` (CamelCase é automaticamente convertido em lower_case_underscore.) Revise a documentação Record para ver como você pode afinar a classe tabela filho.

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
