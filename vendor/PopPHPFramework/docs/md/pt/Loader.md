Pop PHP Framework
=================

Documentation : Loader
----------------------

O componente Loader é provavelmente o componente mais básico, mas mais importante do Quadro de PHP Pop. É o componente que impulsiona as capacidades Autoloading o quadro, e sua própria aplicação pode facilmente ser registrado com o autoloader para carregar suas próprias classes. Este sozinho substitui todas essas declarações antigas de inclusão que você usou para ter todo o lugar. Agora, tudo que você precisa é uma declaração de exigir o "bootstrap.php" na parte superior e você está pronto para ir. Por padrão, o arquivo de inicialização contém a referência necessária para a classe do quadro de Autoloader e carrega-lo. Dentro do arquivo de inicialização, você pode facilmente executar funções de carga, tais como registro de namespace do aplicativo com o carregador automático, ou carregar um arquivo ClassMap para diminuir o tempo de carga.

<pre>
// Instantiate the autoloader object
$autoloader = new Pop\Loader\Autoloader();
$autoloader->splAutoloadRegister();

$autoloader->register('YourLib', '../vendor/YourLib/src');
$autoloader->loadClassMap('../vendor/YourLib/classmap.php');
</pre>

E se você precisar de um arquivo ClassMap gerada, o componente Loader tem a funcionalidade de facilmente gerar um arquivo ClassMap para você também.

<pre>
// Generate a classmap file
Pop\Loader\Classmap::generate('your/src/folder', 'your/src/folder/classmap.php');
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
