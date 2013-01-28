Pop PHP Framework
=================

Documentation : Locale
----------------------

Home

O componente localidade fornece suporte ao idioma e funcionalidade de
tradução para sua aplicação. Você pode simplesmente criar e carregar
seus próprios arquivos XML das traduções de idiomas necessários no
formato que está descritos no próprio pop arquivos XML de idioma.

Você pode carregar seus próprios arquivos de tradução de idiomas,
enquanto a aderir ao padrão XML estabelecido na pasta Locale Pop / /
Dados.

    use Pop\Locale\Locale;

    // Create a Locale object to translate to French, using your own language file.
    $lang = Locale::factory('fr')->loadFile('folder/mylangfile.xml);

    // Will output 'Ce champ est obligatoire.'
    $lang->_e('This field is required.');

    // Will return and output 'Ce champ est obligatoire.'
    echo $lang->__('This field is required.');

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
