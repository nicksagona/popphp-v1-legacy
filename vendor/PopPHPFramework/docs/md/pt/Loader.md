Pop PHP Framework
=================

Documentation : Loader
----------------------

Home

O componente Loader Ã© provavelmente o componente mais bÃ¡sico, ainda
mais importante do Quadro de PHP pop. Ã‰ o componente que dirige
capacidades autoloading o quadro, e sua prÃ³pria aplicaÃ§Ã£o pode
facilmente ser registrado com o autoloader para carregar suas prÃ³prias
classes. Este sozinho substitui todas essas declaraÃ§Ãµes antigas
incluir vocÃª costumava ter em todo o lugar. Agora, tudo que vocÃª
precisa Ã© de um exigir declaraÃ§Ã£o do 'bootstrap.php' no topo e vocÃª
Ã© bom para ir. Por padrÃ£o, o arquivo de inicializaÃ§Ã£o contÃ©m a
referÃªncia exigido para a classe do framework Autoloader e carrega-lo.
Dentro do arquivo de inicializaÃ§Ã£o, vocÃª pode facilmente executar
funÃ§Ãµes de carregamento, tais como registro de namespace de sua
aplicaÃ§Ã£o com o autoloader, ou carregar um arquivo ClassMap para
diminuir o tempo de carga.

    // Instantiate the autoloader object
    $autoloader = new Pop\Loader\Autoloader();
    $autoloader->splAutoloadRegister();

    $autoloader->register('YourLib', '../vendor/YourLib/src');
    $autoloader->loadClassMap('../vendor/YourLib/classmap.php');

E se vocÃª precisa de um arquivo gerado ClassMap, o componente Loader
tem a funcionalidade de facilmente gerar um arquivo ClassMap para vocÃª
tambÃ©m.

    // Generate a classmap file
    Pop\Loader\Classmap::generate('your/src/folder', 'your/src/folder/classmap.php');

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
