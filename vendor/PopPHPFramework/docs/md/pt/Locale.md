Pop PHP Framework
=================

Documentation : Locale
----------------------

O componente localidade fornece apoio linguístico e funcionalidade de tradução para a sua aplicação. Você pode simplesmente criar e carregar seus próprios arquivos XML das traduções linguísticas necessárias no formato que é próprias descritas no Pop de arquivos XML de idioma.

Você pode carregar seus próprios arquivos de tradução de idiomas, enquanto a aderir ao padrão XML criado na pasta Pop Locale / / Data.

<pre>
use Pop\Locale\Locale;

// Create a Locale object to translate to French, using your own language file.
$lang = Locale::factory('fr')->loadFile('folder/mylangfile.xml);

// Will output 'Ce champ est obligatoire.'
$lang->_e('This field is required.');

// Will return and output 'Ce champ est obligatoire.'
echo $lang->__('This field is required.');
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
