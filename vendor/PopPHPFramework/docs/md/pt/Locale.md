Pop PHP Framework
=================

Documentation : Locale
----------------------

Home

O componente localidade fornece suporte ao idioma e funcionalidade de
traduÃ§Ã£o para sua aplicaÃ§Ã£o. VocÃª pode simplesmente criar e
carregar seus prÃ³prios arquivos XML das traduÃ§Ãµes de idiomas
necessÃ¡rios no formato que estÃ¡ descritos no prÃ³prio pop arquivos XML
de idioma.

VocÃª pode carregar seus prÃ³prios arquivos de traduÃ§Ã£o de idiomas,
enquanto a aderir ao padrÃ£o XML estabelecido na pasta Locale Pop / /
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
