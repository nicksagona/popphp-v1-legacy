Pop PHP Framework
=================

Documentation : Font
--------------------

El componente de fuente es un analizador de la fuente de profundidad que extrae los datos importantes de la fuente y métricas para los demás componentes y programas a utilizar. Los tipos de fuentes compatibles son los siguientes:

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
