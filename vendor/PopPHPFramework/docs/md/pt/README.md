Pop PHP Framework
=================

DocumentaÃ§Ã£o: VisÃ£o geral
----------------------------

O quadro PHP Pop Ã© um objeto-orientado framework PHP com um fÃ¡cil de
usar API que permitirÃ¡ que vocÃª utilizar uma vasta gama de
funcionalidades. VocÃª pode usÃ¡-lo como uma caixa de ferramentas para
auxiliar na rÃ¡pida criaÃ§Ã£o de scripts bÃ¡sicos, ou vocÃª pode usÃ¡-lo
como um quadro de pleno direito de construir e personalizar em grande
escala, aplicaÃ§Ãµes robustas. No nÃºcleo da estrutura Ã© um grupo de
componentes, alguns dos quais podem ser utilizados de forma independente
e alguns dos quais podem ser usados â€‹â€‹em tandem para aproveitar a
capacidade total da estrutura e PHP.

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

### InÃ­cio RÃ¡pido

HÃ¡ duas maneiras que vocÃª pode comeÃ§ar a trabalhar com o quadro PHP
pop.

Se vocÃª estÃ¡ olhando apenas para escrever alguns scripts rÃ¡pidos,
vocÃª pode simplesmente deixar cair a pasta de origem na pasta do seu
projeto de trabalho, faz referÃªncia a "bootstrap.php 'de acordo em um
script e comeÃ§ar a escrever cÃ³digo. VocÃª vai encontrar referÃªncias e
exemplos por toda esta documentaÃ§Ã£o que irÃ¡ explicar os diferentes
componentes e como vocÃª pode usÃ¡-los.

Se vocÃª estÃ¡ procurando construir uma aplicaÃ§Ã£o em maior escala,
vocÃª pode usar o componente CLI para criar fundaÃ§Ã£o do projeto base,
ou "andaime". Dessa forma, vocÃª pode comeÃ§ar a escrever o cÃ³digo do
projeto de forma rÃ¡pida e nÃ£o tem que ficar sobrecarregado com tudo
instalado e funcionando. Tudo que vocÃª tem a fazer Ã© definir o seu
projeto em Ãºnico arquivo de instalaÃ§Ã£o, execute o comando CLI Pop
usando esse arquivo e Pop faz todo o trabalho sujo para vocÃª. VocÃª
pode comeÃ§ar a escrever o cÃ³digo do projeto mais rÃ¡pido. Reveja a
documentaÃ§Ã£o sobre o componente CLI para explorar ainda mais como
tirar proveito deste componente robusto.

### O Componente MVC

O componente MVC estÃ¡ disponÃ­vel e especialmente Ãºtil quando a
construÃ§Ã£o de uma aplicaÃ§Ã£o em grande escala. MVC significa
Model-View-Controller e Ã© um padrÃ£o de design que facilita a
separaÃ§Ã£o bem organizado de preocupaÃ§Ãµes. Ele permite que sua
apresentaÃ§Ã£o lÃ³gica de negÃ³cios e acesso a dados para tudo ser
mantidos separadamente.

O controlador recebe uma entrada (ou seja, um pedido na Internet) do
usuÃ¡rio e com base em que a entrada, comunica que, com o modelo. O
modelo pode, em seguida, processar o pedido para determinar quais os
dados ou a resposta for necessÃ¡ria. Nesse ponto, se comunicam modelo e
vista para que a exibiÃ§Ã£o pode construir a apresentaÃ§Ã£o, ou "vista",
com base nos dados obtidos a partir do modelo. Em seguida, o controlador
irÃ¡ comunicar-se com o objectivo de exibir a saÃ­da apropriada para o
utilizador.

Um pedaÃ§o extra do componente MVC que estÃ¡ disponÃ­vel com o Pop PHP
Framework Ã© um roteador. O roteador Ã© simplesmente uma camada
adicional na parte superior que faz exatamente o que seu nome sugere -
ele encaminha diferentes tipos de solicitaÃ§Ãµes de usuÃ¡rios para seus
controladores correspondentes. Em outras palavras, ele fornece uma
maneira fÃ¡cil de gerenciar caminhos mÃºltiplos usuÃ¡rios e
controladores.

Muitas vezes, pode ser difÃ­cil de entender o padrÃ£o de projeto MVC
atÃ© que vocÃª realmente comeÃ§ar a usar. Uma vez que vocÃª faz, porÃ©m,
vocÃª vai ver imediatamente o benefÃ­cio de ter tudo separado em fÃ¡ceis
de gerenciar conceitos com muito pouco, se algum, sobreposiÃ§Ã£o. Seu
controlador lida com a delegaÃ§Ã£o de pedidos, o modelo lida com a
lÃ³gica do negÃ³cio e sua visÃ£o determina como exibir a saÃ­da para o
usuÃ¡rio. De longe, este supera o padrÃ£o velhos tempos de colocar tudo
em um Ãºnico script com numerosos incluem declaraÃ§Ãµes.

### Os Componentes Db & Record

Os componentes Db e Record sÃ£o dois componentes que tÃªm o potencial de
ser usado um pouco em qualquer aplicaÃ§Ã£o. Obviamente, o componente Db
fornece acesso direto para consultar um banco de dados. Os adaptadores
suportados incluem MySQL nativa, MySQLi, Oracle, DOP, PostgreSQL, SQLite
e SQLServer. Eles servem para normalizar o acesso de dados em ambientes
diferentes de modo que vocÃª nÃ£o precisa se preocupar tanto com novos
equipamentos de um aplicativo para trabalhar com um tipo diferente de
banco de dados em um ambiente diferente.

O componente Record Ã© um componente poderoso que fornece acesso
padronizado aos dados em um banco de dados, especificamente as tabelas
de banco de dados e registros individuais dentro das tabelas. O
componente de registro Ã© realmente um hÃ­brido do Active Record e
padrÃµes de tabela de dados Gateway. Ele pode fornecer acesso a uma
Ãºnica linha ou registro como um padrÃ£o Active Record seria, ou vÃ¡rias
linhas de uma sÃ³ vez, como um gateway de dados Tabela faria. Com o
quadro PHP Pop, a abordagem mais comum Ã© escrever uma classe filha que
estende a classe Record que representa uma tabela no banco de dados. O
nome da classe crianÃ§a deve ser o nome da tabela. Simplesmente criando

    use Pop\Record\Record;

    class Users extends Record { }

vocÃª criar uma classe que tem todas as funcionalidades do componente
construÃ­do em Registro e da classe sabe o nome da tabela de banco de
dados para consulta a partir do nome da classe. Por exemplo, se traduz
'UsuÃ¡rios' em \`usuÃ¡rios\` ou 'traduz DbUsers' em \`db\_users\`
(CamelCase Ã© automaticamente convertido em lower\_case\_underscore.)
Analisar a documentaÃ§Ã£o Record para ver como vocÃª pode ajustar a
classe tabela filho.

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
