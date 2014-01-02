Pop PHP Framework
=================

Documentação: Visão geral
-------------------------

O quadro PHP Pop é um objeto-orientado framework PHP com um fácil de
usar API que permitirá que você utilizar uma vasta gama de
funcionalidades. Você pode usá-lo como uma caixa de ferramentas para
auxiliar na rápida criação de scripts básicos, ou você pode usá-lo como
um quadro de pleno direito de construir e personalizar em grande escala,
aplicações robustas. No núcleo da estrutura é um grupo de componentes,
alguns dos quais podem ser utilizados de forma independente e alguns dos
quais podem ser usados ​​em tandem para aproveitar a capacidade total da
estrutura e PHP.

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

### Início Rápido

Há duas maneiras que você pode começar a trabalhar com o quadro PHP pop.

Se você está olhando apenas para escrever alguns scripts rápidos, você
pode simplesmente deixar cair a pasta de origem na pasta do seu projeto
de trabalho, faz referência a "bootstrap.php 'de acordo em um script e
começar a escrever código. Você vai encontrar referências e exemplos por
toda esta documentação que irá explicar os diferentes componentes e como
você pode usá-los.

Se você está procurando construir uma aplicação em maior escala, você
pode usar o componente CLI para criar fundação do projeto base, ou
"andaime". Dessa forma, você pode começar a escrever o código do projeto
de forma rápida e não tem que ficar sobrecarregado com tudo instalado e
funcionando. Tudo que você tem a fazer é definir o seu projeto em único
arquivo de instalação, execute o comando CLI Pop usando esse arquivo e
Pop faz todo o trabalho sujo para você. Você pode começar a escrever o
código do projeto mais rápido. Reveja a documentação sobre o componente
CLI para explorar ainda mais como tirar proveito deste componente
robusto.

### O Componente MVC

O componente MVC está disponível e especialmente útil quando a
construção de uma aplicação em grande escala. MVC significa
Model-View-Controller e é um padrão de design que facilita a separação
bem organizado de preocupações. Ele permite que sua apresentação lógica
de negócios e acesso a dados para tudo ser mantidos separadamente.

O controlador recebe uma entrada (ou seja, um pedido na Internet) do
usuário e com base em que a entrada, comunica que, com o modelo. O
modelo pode, em seguida, processar o pedido para determinar quais os
dados ou a resposta for necessária. Nesse ponto, se comunicam modelo e
vista para que a exibição pode construir a apresentação, ou "vista", com
base nos dados obtidos a partir do modelo. Em seguida, o controlador irá
comunicar-se com o objectivo de exibir a saída apropriada para o
utilizador.

Um pedaço extra do componente MVC que está disponível com o Pop PHP
Framework é um roteador. O roteador é simplesmente uma camada adicional
na parte superior que faz exatamente o que seu nome sugere - ele
encaminha diferentes tipos de solicitações de usuários para seus
controladores correspondentes. Em outras palavras, ele fornece uma
maneira fácil de gerenciar caminhos múltiplos usuários e controladores.

Muitas vezes, pode ser difícil de entender o padrão de projeto MVC até
que você realmente começar a usar. Uma vez que você faz, porém, você vai
ver imediatamente o benefício de ter tudo separado em fáceis de
gerenciar conceitos com muito pouco, se algum, sobreposição. Seu
controlador lida com a delegação de pedidos, o modelo lida com a lógica
do negócio e sua visão determina como exibir a saída para o usuário. De
longe, este supera o padrão velhos tempos de colocar tudo em um único
script com numerosos incluem declarações.

### O Componente Db

O componente Db tem o potencial de ser usado um pouco em toda a aplicação.
Obviamente, a classe Db fornece acesso direto para consultar um banco de
dados. Os adaptadores suportados incluem MySQL nativa, MySQLi, Oracle, DOP,
PostgreSQL, SQLite e SQLServer. Eles servem para normalizar o acesso de
dados em ambientes diferentes de modo que você não precisa se preocupar
tanto com novos equipamentos de um aplicativo para trabalhar com um tipo
diferente de banco de dados em um ambiente diferente.

A classe Record é um componente poderoso que fornece acesso padronizado
aos dados em um banco de dados, especificamente as tabelas de banco de
dados e registros individuais dentro das tabelas. A classe Record é
realmente um híbrido do Active Record e padrões de gateway da tabela.
Ele pode fornecer acesso a uma única linha ou registro como um padrão
Active Record seria, ou várias linhas de uma só vez, como um Gateway
Tabela faria. Com o quadro PHP Pop, a abordagem mais comum é escrever
uma classe filha que estende a classe Record que representa uma tabela
no banco de dados. O nome da classe criança deve ser o nome da tabela.
Simplesmente criando:

    use Pop\Db\Record;

    class Users extends Record { }

você criar uma classe que tem todas as funcionalidades da classe
construído em Registro e da classe sabe o nome da tabela de banco de
dados para consulta a partir do nome da classe. Por exemplo, se traduz
'Usuários' em `usuários` ou 'traduz DbUsers' em `db_users` (CamelCase
é automaticamente convertido em lower_case_underscore.) Analisar a
documentação Db para ver como você pode ajustar a classe tabela filho.

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
