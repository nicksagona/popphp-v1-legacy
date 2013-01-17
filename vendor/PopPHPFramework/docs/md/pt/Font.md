Pop PHP Framework
=================

Documentation : Font
--------------------

O componente Font é um analisador font profundidade que extrai dados de fontes importantes e métricas para outros componentes e programas a serem usados. Os tipos de fonte suportados são:

* TrueType
* OpenType
* Type1

<pre>
use Pop\Font\TrueType;

$font = new TrueType('fonts/times.ttf');

// You then have access to all of the parsed font data and metrics.
echo $font->info->fullName;
echo $font->bBox->xMin;
echo $font->bBox->yMin;
echo $font->bBox->xMax;
echo $font->bBox->yMax;
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
