Pop PHP Framework
=================

Documentation : Loader
----------------------

Home

O componente Loader é provavelmente o componente mais básico, ainda mais
importante do Quadro de PHP pop. É o componente que dirige capacidades
autoloading o quadro, e sua própria aplicação pode facilmente ser
registrado com o autoloader para carregar suas próprias classes. Este
sozinho substitui todas essas declarações antigas incluir você costumava
ter em todo o lugar. Agora, tudo que você precisa é de um exigir
declaração do 'bootstrap.php' no topo e você é bom para ir. Por padrão,
o arquivo de inicialização contém a referência exigido para a classe do
framework Autoloader e carrega-lo. Dentro do arquivo de inicialização,
você pode facilmente executar funções de carregamento, tais como
registro de namespace de sua aplicação com o autoloader, ou carregar um
arquivo ClassMap para diminuir o tempo de carga.

    // Instantiate the autoloader object
    $autoloader = new Pop\Loader\Autoloader();
    $autoloader->splAutoloadRegister();

    $autoloader->register('YourLib', '../vendor/YourLib/src');
    $autoloader->loadClassMap('../vendor/YourLib/classmap.php');

E se você precisa de um arquivo gerado ClassMap, o componente Loader tem
a funcionalidade de facilmente gerar um arquivo ClassMap para você
também.

    // Generate a classmap file
    Pop\Loader\Classmap::generate('your/src/folder', 'your/src/folder/classmap.php');

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
