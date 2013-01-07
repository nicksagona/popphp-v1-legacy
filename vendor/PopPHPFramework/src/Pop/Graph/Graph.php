<?php
/**
 * Pop PHP Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.TXT.
 * It is also available through the world-wide-web at this URL:
 * http://www.popphp.org/LICENSE.TXT
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@popphp.org so we can send you a copy immediately.
 *
 * @category   Pop
 * @package    Pop_Graph
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Graph;

use Pop\Color\ColorInterface,
    Pop\Color\Rgb,
    Pop\Image\Gd,
    Pop\Image\Imagick,
    Pop\Image\Svg,
    Pop\Pdf\Pdf;

/**
 * This is the Graph class for the Graph component.
 *
 * @category   Pop
 * @package    Pop_Graph
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.1.2
 */
class Graph
{

    /**
     * Constant to use the Gd_Gd component
     * @var int
     */
    const GD = 1;

    /**
     * Constant to use the Gd_Imagick component
     * @var int
     */
    const IMAGICK = 2;

    /**
     * Graph canvas width
     * @var int
     */
    protected $width = 0;

    /**
     * Graph canvas height
     * @var int
     */
    protected $height = 0;

    /**
     * Graph canvas padding
     * @var int
     */
    protected $padding = 50;

    /**
     * Graph graphic adapter interface
     * @var mixed
     */
    protected $adapter = null;

    /**
     * Available fonts
     * @var array
     */
    protected $fonts = array();

    /**
     * Current font to use
     * @var string
     */
    protected $font = null;

    /**
     * Font size
     * @var int
     */
    protected $fontSize = 12;

    /**
     * Font color
     * @var mixed
     */
    protected $fontColor = null;

    /**
     * Reverse font color
     * @var mixed
     */
    protected $reverseFontColor = null;

    /**
     * Fill color
     * @var mixed
     */
    protected $fillColor = null;

    /**
     * Stroke color
     * @var mixed
     */
    protected $strokeColor = null;

    /**
     * Stroke width
     * @var int
     */
    protected $strokeWidth = 1;

    /**
     * Axis color
     * @var mixed
     */
    protected $axisColor = null;

    /**
     * Axis width
     * @var int
     */
    protected $axisWidth = 2;

    /**
     * Bar width
     * @var int
     */
    protected $barWidth = 50;

    /**
     * Show data text flag
     * @var boolean
     */
    protected $showText = false;

    /**
     * Show X-axis increment lines flag
     * @var boolean
     */
    protected $showX = false;

    /**
     * Show X-axis color
     * @var mixed
     */
    protected $showXColor = null;

    /**
     * Show Y-axis increment lines flag
     * @var boolean
     */
    protected $showY = false;

    /**
     * Show X-axis color
     * @var mixed
     */
    protected $showYColor = null;

    /**
     * Constructor
     *
     * Instantiate the graph object.
     *
     * @param  string                    $filename
     * @param  int                       $w
     * @param  int                       $h
     * @param  int                       $type
     * @param  \Pop\Color\ColorInterface $bgcolor
     * @return \Pop\Graph\Graph
     */
    public function __construct($filename, $w, $h, $type = Graph::GD, ColorInterface $bgcolor = null)
    {
        $this->width = $w;
        $this->height = $h;
        $this->fontColor = new Rgb(0, 0, 0);
        $this->axisColor = new Rgb(0, 0, 0);
        $this->showXColor = new Rgb(200, 200, 200);
        $this->showYColor = new Rgb(200, 200, 200);

        if (stripos($filename, '.svg') !== false) {
            $this->adapter = new Svg($filename, $w, $h, $bgcolor);
        } else if (stripos($filename, '.pdf') !== false) {
            $this->adapter = new Pdf($filename, null, $w, $h);
        } else if ($type == self::IMAGICK) {
            $this->adapter = new Imagick($filename, $w, $h, $bgcolor);
        } else {
            $this->adapter = new Gd($filename, $w, $h, $bgcolor);
        }
    }

    /**
     * Get the graph graphic adapter
     *
     * @return mixed
     */
    public function adapter()
    {
        return $this->adapter;
    }

    /**
     * Set the axis options
     *
     * @param  ColorInterface $color
     * @param  int            $width
     * @return \Pop\Graph\Graph
     */
    public function setAxisOptions(ColorInterface $color = null, $width = 2)
    {
        $this->axisColor = (null === $color) ? new Rgb(0, 0, 0) : $color;
        $this->axisWidth = (int)$width;

        return $this;
    }

    /**
     * Add a font to available fonts
     *
     * @param  string $font
     * @return \Pop\Graph\Graph
     */
    public function addFont($font)
    {
        if ($this->adapter instanceof Pdf) {
            $this->adapter->addFont($font);
            $this->font = $this->adapter->getLastFontName();
            $this->fonts[$this->font] = $this->font;
        } else {
            $this->font = $font;
            if (strpos($this->font, DIRECTORY_SEPARATOR) !== false) {
                $this->font = substr($this->font, (strrpos($this->font, DIRECTORY_SEPARATOR) + 1));
            }
            if (strpos($this->font, '.') !== false) {
                $this->font = substr($this->font, 0, strrpos($this->font, '.'));
            }

            $this->fonts[$this->font] = $font;
        }

        return $this;
    }

    /**
     * Set the font to use from the available fonts
     *
     * @param  string $font
     * @throws Exception
     * @return \Pop\Graph\Graph
     */
    public function setFont($font = null)
    {
        if ((null !== $font) && !array_key_exists($font, $this->fonts)) {
            throw new Exception('That font is not available.');
        }

        $this->font = $font;

        return $this;
    }

    /**
     * Set the font size
     *
     * @param  int $size
     * @return \Pop\Graph\Graph
     */
    public function setFontSize($size)
    {
        $this->fontSize = (int)$size;
        return $this;
    }

    /**
     * Set the font color
     *
     * @param  ColorInterface $color
     * @return \Pop\Graph\Graph
     */
    public function setFontColor(ColorInterface $color)
    {
        $this->fontColor = $color;
        return $this;
    }

    /**
     * Set the reverse font color
     *
     * @param  ColorInterface $color
     * @return \Pop\Graph\Graph
     */
    public function setReverseFontColor(ColorInterface $color)
    {
        $this->reverseFontColor = $color;
        return $this;
    }

    /**
     * Set the fill color
     *
     * @param  ColorInterface $color
     * @return \Pop\Graph\Graph
     */
    public function setFillColor(ColorInterface $color)
    {
        $this->fillColor = $color;
        return $this;
    }

    /**
     * Set the stroke color
     *
     * @param  ColorInterface $color
     * @return \Pop\Graph\Graph
     */
    public function setStrokeColor(ColorInterface $color)
    {
        $this->strokeColor = $color;
        return $this;
    }

    /**
     * Set the stroke width
     *
     * @param  int $width
     * @return \Pop\Graph\Graph
     */
    public function setStrokeWidth($width = 1)
    {
        $this->strokeWidth = $width;
        return $this;
    }

    /**
     * Set the graph canvas padding
     *
     * @param  int $pad
     * @return \Pop\Graph\Graph
     */
    public function setPadding($pad)
    {
        $this->padding = (int)$pad;
        return $this;
    }

    /**
     * Set the bar width
     *
     * @param  int $width
     * @return \Pop\Graph\Graph
     */
    public function setBarWidth($width)
    {
        $this->barWidth = (int)$width;
        return $this;
    }

    /**
     * Set the 'show data text' flag
     *
     * @param  boolean $showText
     * @return \Pop\Graph\Graph
     */
    public function showText($showText)
    {
        $this->showText = (boolean)$showText;
        return $this;
    }

    /**
     * Set the 'show X-axis increment lines' flag
     *
     * @param  boolean        $showX
     * @param  ColorInterface $color
     * @return \Pop\Graph\Graph
     */
    public function showX($showX, ColorInterface $color = null)
    {
        $this->showX = (boolean)$showX;
        $this->showXColor = (null === $color) ? new Rgb(200, 200, 200) : $color;
        return $this;
    }

    /**
     * Set the 'show Y-axis increment lines' flag
     *
     * @param  boolean        $showY
     * @param  ColorInterface $color
     * @return \Pop\Graph\Graph
     */
    public function showY($showY, ColorInterface $color = null)
    {
        $this->showY = (boolean)$showY;
        $this->showYColor = (null === $color) ? new Rgb(200, 200, 200) : $color;
        return $this;
    }

    /**
     * Get the axis color
     *
     * @return \Pop\Color\ColorInterface
     */
    public function getAxisColor()
    {
        return $this->axisColor;
    }

    /**
     * Get the axis width
     *
     * @return int
     */
    public function getAxisWidth()
    {
        return $this->axisWidth;
    }

    /**
     * Get the font size
     *
     * @return int
     */
    public function getFontSize()
    {
        return $this->fontSize;
    }

    /**
     * Get the font color
     *
     * @return mixed
     */
    public function getFontColor()
    {
        return $this->fontColor;
    }

    /**
     * Get the reverse font color
     *
     * @return mixed
     */
    public function getReverseFontColor()
    {
        return $this->reverseFontColor;
    }

    /**
     * Get the fill color
     *
     * @return mixed
     */
    public function getFillColor()
    {
        return $this->fillColor;
    }

    /**
     * Get the stroke color
     *
     * @return mixed
     */
    public function getStrokeColor()
    {
        return $this->strokeColor;
    }

    /**
     * Get the stroke width
     *
     * @return int
     */
    public function getStrokeWidth()
    {
        return $this->strokeWidth;
    }

    /**
     * Get the graph canvas padding
     *
     * @return int
     */
    public function getPadding()
    {
        return $this->padding;
    }

    /**
     * Get the bar width
     *
     * @return int
     */
    public function getBarWidth()
    {
        return $this->barWidth;
    }

    /**
     * Add a line graph
     *
     * @param  array $dataPoints
     * @param  array $xAxis
     * @param  array $yAxis
     * @return \Pop\Graph\Graph
     */
    public function addLineGraph(array $dataPoints, array $xAxis, array $yAxis)
    {
        // Calculate the points.
        $points = $this->getPoints($xAxis, $yAxis);

        if ($this->showX) {
            $this->showXAxis($yAxis, $points);
        }
        if ($this->showY) {
            $this->showYAxis($xAxis, $points);
        }

        $skip = 1;

        // If the first data point does not equal the graph origin point.
        if (((float)$dataPoints[0][0] != (float)$xAxis[0]) && ((float)$dataPoints[0][1] != (float)$yAxis[0])) {
            $newData = array_merge(array(array((float)$xAxis[0], (float)$yAxis[0])), array(array((float)$dataPoints[0][0], (float)$yAxis[0])), $dataPoints);
            $dataPoints = $newData;
            $skip = 2;
        // Else, if the first data point X equals the graph origin point X.
        } else if (((float)$dataPoints[0][0] != (float)$xAxis[0])) {
            $newData = array_merge(array(array((float)$xAxis[0], (float)$yAxis[0])), array(array((float)$dataPoints[0][0], (float)$yAxis[0])), $dataPoints);
            $dataPoints = $newData;
            $skip = 3;
        // Else, if the first data point Y equals the graph origin point Y.
        } else if (((float)$dataPoints[0][1] != (float)$yAxis[0])) {
            $newData = array_merge(array(array((float)$xAxis[0], (float)$yAxis[0])), array(array((float)$xAxis[0], (float)$dataPoints[0][1])), $dataPoints);
            $dataPoints = $newData;
            $skip = 3;
        }

        // Draw graph data.
        if (null !== $this->fillColor) {
            $this->adapter->setFillColor($this->fillColor);
            $this->adapter->setStrokeColor((null !== $this->strokeColor) ? $this->strokeColor : $this->fillColor);
            $this->adapter->setStrokeWidth($this->strokeWidth);
            $formattedPoints = array();
            for ($i = 0; $i < count($dataPoints); $i++) {
                $x = ((($dataPoints[$i][0] - $dataPoints[0][0]) / $points->xRange) * $points->xLength) + $points->zeroPoint['x'];
                $y = $points->yOffset - ((($dataPoints[$i][1] - $dataPoints[0][1]) / $points->yRange) * $points->yLength);
                $formattedPoints[] = array('x' => $x, 'y' => $y);
                $lastX = $x;
            }
            $formattedPoints[] = array('x' => $lastX, 'y' => $points->zeroPoint['y']);
            $this->adapter->addPolygon($formattedPoints);
        } else {
            $this->adapter->setStrokeWidth($this->strokeWidth);
            $this->adapter->setStrokeColor((null !== $this->strokeColor) ? $this->strokeColor : new Rgb(0, 0, 0));

            for ($i = 1; $i < count($dataPoints); $i++) {
                $x1 = ((($dataPoints[$i - 1][0] - $dataPoints[0][0]) / $points->xRange) * $points->xLength) + $points->zeroPoint['x'];
                $y1 = $points->yOffset - ((($dataPoints[$i - 1][1] - $dataPoints[0][1]) / $points->yRange) * $points->yLength);
                $x2 = ((($dataPoints[$i][0] - $dataPoints[0][0]) / $points->xRange) * $points->xLength) + $points->zeroPoint['x'];
                $y2 = $points->yOffset - ((($dataPoints[$i][1] - $dataPoints[0][1]) / $points->yRange) * $points->yLength);
                $this->adapter->addLine($x1, $y1, $x2, $y2);
            }

        }

        // Draw data point text.
        if ($this->showText) {
            $this->drawDataText($dataPoints, $xAxis, $yAxis, 'line', $points, $skip);
        }

        // Draw graph axes.
        $this->drawXAxis($xAxis, $points);
        $this->drawYAxis($yAxis, $points);

        return $this;
    }

    /**
     * Add a vertical bar graph
     *
     * @param  array $dataPoints
     * @param  array $xAxis
     * @param  array $yAxis
     * @return \Pop\Graph\Graph
     */
    public function addVBarGraph(array $dataPoints, array $xAxis, array $yAxis)
    {
        // Calculate the points.
        $points = $this->getPoints($xAxis, $yAxis);

        if ($this->showX) {
            $this->showXAxis($yAxis, $points, $this->barWidth);
        }
        if ($this->showY) {
            $this->showYAxis($xAxis, $points);
        }

        // Draw graph data.
        $realXDiv = ($points->xLength - ($this->barWidth * 2)) / (count($xAxis) - 1);

        if ((null !== $this->fillColor) || is_array($dataPoints[0])) {
            $this->adapter->setStrokeWidth($this->strokeWidth);
            for ($i = 0; $i < count($dataPoints); $i++) {
                if (is_array($dataPoints[$i])) {
                    $pt = $dataPoints[$i][0];
                    $this->adapter->setStrokeColor((null !== $this->strokeColor) ? $this->strokeColor : $dataPoints[$i][1]);
                    $this->adapter->setFillColor($dataPoints[$i][1]);
                } else {
                    $pt = $dataPoints[$i];
                    $this->adapter->setStrokeColor((null !== $this->strokeColor) ? $this->strokeColor : $this->fillColor);
                    $this->adapter->setFillColor($this->fillColor);
                }
                $x = ($realXDiv * ($i + 1)) - ($this->barWidth / 1.75);
                $y = $points->yOffset - ((($pt) / $points->yRange) * $points->yLength);
                $w = $this->barWidth;
                $h = $points->zeroPoint['y'] - $y;
                $this->adapter->addRectangle($x, $y, $w, $h);
            }
        } else {
            $this->adapter->setStrokeWidth($this->strokeWidth);
            $this->adapter->setStrokeColor((null !== $this->strokeColor) ? $this->strokeColor : new Rgb(0, 0, 0));
            for ($i = 0; $i < count($dataPoints); $i++) {
                $x = ($realXDiv * ($i + 1)) - ($this->barWidth / 1.75);
                $y = $points->yOffset - ((($dataPoints[$i]) / $points->yRange) * $points->yLength);
                $w = $this->barWidth;
                $h = $points->zeroPoint['y'] - $y;
                $this->adapter->addLine($x, $y, $x, ($y + $h));
                $this->adapter->addLine($x, $y, ($x + $w), $y);
                $this->adapter->addLine(($x + $w), $y, ($x + $w), ($y + $h));
            }
        }

        // Draw data point text.
        if ($this->showText) {
            if (is_array($dataPoints[0])) {
                $dPts = array();
                foreach ($dataPoints as $value) {
                    $dPts[] = $value[0];
                }
            } else {
                $dPts = $dataPoints;
            }
            $this->drawDataText($dPts, $xAxis, $yAxis, 'vBar', $points);
        }

        // Draw graph axes.
        $this->drawXAxis($xAxis, $points, $this->barWidth);
        $this->drawYAxis($yAxis, $points);

        return $this;
    }

    /**
     * Add a horizontal bar graph
     *
     * @param  array $dataPoints
     * @param  array $xAxis
     * @param  array $yAxis
     * @return \Pop\Graph\Graph
     */
    public function addHBarGraph(array $dataPoints, array $xAxis, array $yAxis)
    {
        // Calculate the points.
        $points = $this->getPoints($xAxis, $yAxis);

        if ($this->showX) {
            $this->showXAxis($yAxis, $points);
        }
        if ($this->showY) {
            $this->showYAxis($xAxis, $points, $this->barWidth);
        }

        // Draw graph data.
        if ($this->adapter instanceof Pdf) {
            $realYDiv = ($points->yLength + ($this->barWidth * 2)) / (count($yAxis) - 1);
        } else {
            $realYDiv = ($points->yLength - ($this->barWidth * 2)) / (count($yAxis) - 1);
        }

        if ((null !== $this->fillColor) || is_array($dataPoints[0])) {
            $this->adapter->setFillColor($this->fillColor);
            $this->adapter->setStrokeColor((null !== $this->strokeColor) ? $this->strokeColor : $this->fillColor);
            $this->adapter->setStrokeWidth($this->strokeWidth);
            $len = count($dataPoints);
            for ($i = 0; $i < $len; $i++) {
                if (is_array($dataPoints[$i])) {
                    $pt = $dataPoints[$i][0];
                    $this->adapter->setStrokeColor((null !== $this->strokeColor) ? $this->strokeColor : $dataPoints[$i][1]);
                    $this->adapter->setFillColor($dataPoints[$i][1]);
                } else {
                    $pt = $dataPoints[$i];
                    $this->adapter->setStrokeColor((null !== $this->strokeColor) ? $this->strokeColor : $this->fillColor);
                    $this->adapter->setFillColor($this->fillColor);
                }
                if ($this->adapter instanceof Pdf) {
                    $y = ($points->zeroPoint['y'] - ($realYDiv * $i)) + ($this->barWidth / 5);
                } else {
                    $y = ($points->yLength - ($realYDiv * ($i + 1))) + ($this->barWidth * 1.1);
                }
                $x = $points->zeroPoint['x'];
                $h = $this->barWidth;
                $w = (($pt / $points->xRange) * $points->xLength);
                $this->adapter->addRectangle($x, $y, $w, $h);
            }
        } else {
            $this->adapter->setStrokeWidth($this->strokeWidth);
            $this->adapter->setStrokeColor((null !== $this->strokeColor) ? $this->strokeColor : new Rgb(0, 0, 0));
            for ($i = 0; $i < count($dataPoints); $i++) {
                if ($this->adapter instanceof Pdf) {
                    $y = ($points->zeroPoint['y'] - ($realYDiv * $i)) + ($this->barWidth / 5);
                } else {
                    $y = ($points->yLength - ($realYDiv * ($i + 1))) + ($this->barWidth * 1.1);
                }
                $x = $points->zeroPoint['x'];
                $h = $this->barWidth;
                $w = (($dataPoints[$i] / $points->xRange) * $points->xLength);
                $this->adapter->addLine($x, $y, ($x + $w), $y);
                $this->adapter->addLine(($x + $w), $y, ($x + $w), ($y + $h));
                $this->adapter->addLine(($x + $w), ($y + $h), $x, ($y + $h));
            }
        }

        // Draw data point text.
        if ($this->showText) {
            if (is_array($dataPoints[0])) {
                $dPts = array();
                foreach ($dataPoints as $value) {
                    $dPts[] = $value[0];
                }
            } else {
                $dPts = $dataPoints;
            }
            $this->drawDataText($dPts, $xAxis, $yAxis, 'hBar', $points);
        }

        // Draw graph axes.
        $this->drawXAxis($xAxis, $points);
        $this->drawYAxis($yAxis, $points, $this->barWidth);

        return $this;
    }

    /**
     * Add a pie chart
     *
     * @param  array $pie
     * @param  array $percents
     * @param  int   $explode
     * @throws Exception
     * @return \Pop\Graph\Graph
     */
    public function addPieChart(array $pie, array $percents, $explode = 0)
    {
        $total = 0;
        $textMidPts = array();
        $textQuads = array();
        $textValues = array();

        foreach ($percents as $value) {
            $total += (int)$value[0];
        }

        if ($total > 100) {
            throw new Exception('The percentages are greater than 100.');
        }

        $start = 0;
        $end = 0;
        foreach ($percents as $value) {
            $amt = round(($value[0] / 100) * 360);
            if ($start == 0) {
                $end = $amt;
            } else {
                $end = $start + $amt;
            }
            $this->adapter->setFillColor($value[1]);

            if ($explode != 0) {
                $center = array('x' => $pie['x'], 'y' => $pie['y']);
                $mid = (($end - $start) / 2) + $start;
                $midX = round($pie['x'] + ($pie['w'] * (cos($mid / 180 * pi()))));
                $midY = round($pie['y'] + ($pie['h'] * (sin($mid / 180 * pi()))));
                $midPt = array('x' => $midX, 'y' => $midY);

                $quad = $this->getQuadrant($midPt, $center);
                $triangle = $this->getTriangle($midPt, $center, $quad);

                $newHypot = $triangle['hypot'] - $explode;
                $newSide1 = round(sin(deg2rad($triangle['angle2'])) * $newHypot);
                $newSide2 = round(sin(deg2rad($triangle['angle1'])) * $newHypot);

                if ($this->adapter instanceof Pdf) {
                    switch ($quad) {
                        case 1:
                            $x = $midX - $newSide1;
                            $y = $midY + $newSide2;
                            break;

                        case 2:
                            $x = $newSide1 + $midX;
                            $y = $midY + $newSide2;
                            break;

                        case 3:
                            $x = $newSide1 + $midX;
                            $y = $midY - $newSide2;
                            break;

                        case 4:
                            $x = $midX - $newSide1;
                            $y = $midY - $newSide2;
                            break;
                    }
                    $y = $pie['y'] + ($pie['y'] - $y);
                } else {
                    switch ($quad) {
                        case 1:
                            $x = $midX - $newSide1;
                            $y = $midY - $newSide2;
                            break;

                        case 2:
                            $x = $newSide1 + $midX;
                            $y = $midY - $newSide2;
                            break;

                        case 3:
                            $x = $newSide1 + $midX;
                            $y = $midY + $newSide2;
                            break;

                        case 4:
                            $x = $midX - $newSide1;
                            $y = $midY + $newSide2;
                            break;
                    }
                }
            } else {
                $x = $pie['x'];
                $y = $pie['y'];
            }

            $newMidX = round($x + ($pie['w'] * (cos($mid / 180 * pi()))));
            $newMidY = round($y + ($pie['h'] * (sin($mid / 180 * pi()))));
            $newMidPts = array('x' => $newMidX, 'y' => $newMidY);
            $quad = $this->getQuadrant($newMidPts, array('x' => $x, 'y' => $y));

            $textMidPts[] = $newMidPts;
            $textQuads[] = $quad;
            $textValues[] = $value;

            $this->adapter->addArc($x, $y, $start, $end, $pie['w'], $pie['h']);
            $start = $end;
        }

        // Draw data point text.
        if ($this->showText) {
            $this->drawDataText($textValues, $textMidPts, $textQuads, 'pie');
        }

        return $this;
    }

    /**
     * Output the graph
     *
     * @return void
     */
    public function output()
    {
        $this->adapter->output();
    }

    /**
     * Get points
     *
     * @param  array $xAxis
     * @param  array $yAxis
     * @return \ArrayObject
     */
    protected function getPoints($xAxis, $yAxis)
    {
        if ($this->adapter instanceof Pdf) {
            $zeroPoint = array('x' => $this->padding, 'y' => $this->padding);
            $endX = array('x' => ($this->width - $this->padding), 'y' => $zeroPoint['y']);
            $endY = array('x' => $zeroPoint['x'], 'y' => ($this->height - $this->padding));
            $xOffset = $this->padding;
            $yOffset = $this->padding;
        } else {
            $zeroPoint = array('x' => $this->padding, 'y' => ($this->height- $this->padding));
            $endX = array('x' => ($this->width- $this->padding), 'y' => $zeroPoint['y']);
            $endY = array('x' => $zeroPoint['x'], 'y' => $this->padding);
            $xOffset = $this->padding;
            $yOffset = $this->height- $this->padding;
        }

        $xLength = $endX['x'] - $zeroPoint['x'];
        $yLength = $zeroPoint['y'] - $endY['y'];
        $xRange = (float)$xAxis[count($xAxis) - 1] - (float)$xAxis[0];
        $yRange = (float)$yAxis[count($yAxis) - 1] - (float)$yAxis[0];

        $xDiv = $xLength / (count($xAxis) - 1);
        $yDiv = $yLength / (count($yAxis) - 1);

        $points = new \ArrayObject(array(
            'zeroPoint' => $zeroPoint,
            'endX'      => $endX,
            'endY'      => $endY,
            'xOffset'   => $xOffset,
            'yOffset'   => $yOffset,
            'xLength'   => $xLength,
            'yLength'   => $yLength,
            'xRange'    => $xRange,
            'yRange'    => $yRange,
            'xDiv'      => $xDiv,
            'yDiv'      => $yDiv
        ), \ArrayObject::ARRAY_AS_PROPS);

        return $points;
    }

    /**
     * Draw the X Axis increments
     *
     * @param  array        $xAxis
     * @param  \ArrayObject $points
     * @param  int          $offset
     * @return void
     */
    protected function showXAxis($xAxis, $points, $offset = 0)
    {
        $this->adapter->setStrokeWidth(1);
        $this->adapter->setStrokeColor($this->showYColor);
        $this->adapter->addLine($points->zeroPoint['x'], $points->zeroPoint['y'], $points->endX['x'], $points->endX['y']);
        $this->adapter->setFillColor($this->fontColor);

        $i = 0;

        if ($offset != 0) {
            $realXDiv = ($points->xLength - ($offset * 2)) / (count($xAxis) - 1);
            $realZeroX = $points->zeroPoint['x'] + ($realXDiv / 2);
        } else {
            $realXDiv = $points->xDiv;
            $realZeroX = $points->zeroPoint['x'];
        }

        foreach ($xAxis as $x) {
            if ($this->adapter instanceof Pdf) {
                $this->adapter->addLine($realZeroX + ($realXDiv * $i), $points->zeroPoint['y'], $realZeroX + ($realXDiv * $i), ($this->height - $this->padding));
            } else {
                $this->adapter->addLine($realZeroX + ($realXDiv * $i), $points->zeroPoint['y'] - $points->yLength, $realZeroX + ($realXDiv * $i), $points->zeroPoint['y']);
            }
            $i++;
        }
    }

    /**
     * Draw the Y Axis increments
     *
     * @param  array        $yAxis
     * @param  \ArrayObject $points
     * @param  int          $offset
     * @return void
     */
    protected function showYAxis($yAxis, $points, $offset = 0)
    {
        $this->adapter->setStrokeWidth(1);
        $this->adapter->setStrokeColor($this->showXColor);
        $this->adapter->setFillColor($this->fontColor);

        $i = 0;

        if ($offset != 0) {
            if ($this->adapter instanceof Pdf) {
                $realYDiv = ($points->yLength + ($offset * 2)) / (count($yAxis) - 1);
                $realZeroY = $points->zeroPoint['y'] - ($realYDiv / 2);
            } else {
                $realYDiv = ($points->yLength - ($offset * 2)) / (count($yAxis) - 1);
                $realZeroY = $points->zeroPoint['y'] - ($realYDiv / 2);
            }
        } else {
            $realYDiv = $points->yDiv;
            $realZeroY = $points->zeroPoint['y'];
        }

        foreach ($yAxis as $y) {
            $this->adapter->addLine($points->zeroPoint['x'], $realZeroY - ($realYDiv * $i), ($this->width - $this->padding), $realZeroY - ($realYDiv * $i));
            $i++;
        }
    }

    /**
     * Draw the X Axis
     *
     * @param  array        $xAxis
     * @param  \ArrayObject $points
     * @param  int          $offset
     * @return void
     */
    protected function drawXAxis($xAxis, $points, $offset = 0)
    {
        $this->adapter->setStrokeWidth($this->axisWidth);
        $this->adapter->setStrokeColor($this->axisColor);
        $this->adapter->addLine($points->zeroPoint['x'], $points->zeroPoint['y'], $points->endX['x'], $points->endX['y']);
        $this->adapter->setFillColor($this->fontColor);

        $i = 0;

        if ($offset != 0) {
            $realXDiv = ($points->xLength - ($offset * 2)) / (count($xAxis) - 1);
            $realZeroX = $points->zeroPoint['x'] + ($realXDiv / 2);
        } else {
            $realXDiv = $points->xDiv;
            $realZeroX = $points->zeroPoint['x'];
        }

        foreach ($xAxis as $x) {
            $xFontOffset = ($this->fontSize * strlen($x)) / 3;
            $yFontOffset = $this->fontSize + 10;
            if ($this->adapter instanceof Pdf) {
                $this->adapter->addLine($realZeroX + ($realXDiv * $i), $points->zeroPoint['y'], $realZeroX + ($realXDiv * $i), $points->zeroPoint['y'] - 5);
            } else {
                $this->adapter->addLine($realZeroX + ($realXDiv * $i), $points->zeroPoint['y'], $realZeroX + ($realXDiv * $i), $points->zeroPoint['y'] + 5);
            }

            if (null !== $this->font) {
                if ($this->adapter instanceof Pdf) {
                    $this->adapter->addText($realZeroX + ($realXDiv * $i) - $xFontOffset, $points->zeroPoint['y'] - $yFontOffset, $this->fontSize, $x, $this->fonts[$this->font]);
                } else {
                    $this->adapter->text($x, $this->fontSize, $realZeroX + ($realXDiv * $i) - $xFontOffset, $points->zeroPoint['y'] + $yFontOffset, $this->fonts[$this->font]);
                }
            } else {
                if ($this->adapter instanceof Pdf) {
                    $this->adapter->addFont('Arial');
                    $this->adapter->addText($realZeroX + ($realXDiv * $i) - $xFontOffset, $points->zeroPoint['y'] - $yFontOffset, $this->fontSize, $x, 'Arial');
                } else {
                    $this->adapter->text($x, $this->fontSize, $realZeroX + ($realXDiv * $i) - $xFontOffset, $points->zeroPoint['y'] + $yFontOffset);
                }
            }
            $i++;
        }
    }

    /**
     * Draw the Y Axis
     *
     * @param  array        $yAxis
     * @param  \ArrayObject $points
     * @param  int          $offset
     * @return void
     */
    protected function drawYAxis($yAxis, $points, $offset = 0)
    {
        $this->adapter->setStrokeWidth($this->axisWidth);
        $this->adapter->setStrokeColor($this->axisColor);
        $this->adapter->addLine($points->zeroPoint['x'], $points->zeroPoint['y'], $points->endY['x'], $points->endY['y']);
        $this->adapter->setFillColor($this->fontColor);

        $i = 0;

        if ($offset != 0) {
            if ($this->adapter instanceof Pdf) {
                $realYDiv = ($points->yLength + ($offset * 2)) / (count($yAxis) - 1);
                $realZeroY = $points->zeroPoint['y'] - ($realYDiv / 2);
            } else {
                $realYDiv = ($points->yLength - ($offset * 2)) / (count($yAxis) - 1);
                $realZeroY = $points->zeroPoint['y'] - ($realYDiv / 2);
            }
        } else {
            $realYDiv = $points->yDiv;
            $realZeroY = $points->zeroPoint['y'];
        }

        foreach ($yAxis as $y) {
            $xFontOffset = (($this->fontSize * strlen($y)) / 1.5) + 15;
            $yFontOffset = $this->fontSize / 2;
            $this->adapter->addLine($points->zeroPoint['x'], $realZeroY - ($realYDiv * $i), $points->zeroPoint['x'] - 5, $realZeroY - ($realYDiv * $i));
            if (null !== $this->font) {
                if ($this->adapter instanceof Pdf) {
                    $this->adapter->addText($points->zeroPoint['x'] - $xFontOffset, $realZeroY - ($realYDiv * $i) - $yFontOffset, $this->fontSize, $y, $this->fonts[$this->font]);
                } else {
                    $this->adapter->text($y, $this->fontSize, $points->zeroPoint['x'] - $xFontOffset, $realZeroY - ($realYDiv * $i) + $yFontOffset, $this->fonts[$this->font]);
                }
            } else {
                if ($this->adapter instanceof Pdf) {
                    $this->adapter->addFont('Arial');
                    $this->adapter->addText($points->zeroPoint['x'] - $xFontOffset, $realZeroY - ($realYDiv * $i) - $yFontOffset, $this->fontSize, $y, 'Arial');
                } else {
                    $this->adapter->text($y, $this->fontSize, $points->zeroPoint['x'] - $xFontOffset, $realZeroY - ($realYDiv * $i) + $yFontOffset);
                }
            }
            $i++;
        }
    }

    /**
     * Draw the data point text on the graph
     *
     * @param  array  $dataPoints
     * @param  array  $xAxis
     * @param  array  $yAxis
     * @param  string $type
     * @param  array  $points
     * @param  int    $skip
     * @return void
     */
    protected function drawDataText($dataPoints, $xAxis, $yAxis, $type, $points = null, $skip = 1)
    {
        switch ($type) {
            // Draw data point text on a line graph.
            case 'line':
                $this->adapter->setFillColor($this->fontColor);
                $prevY = null;
                $nextY = null;
                $start = $skip;

                for ($i = $start; $i < count($dataPoints); $i++) {
                    $strSize = (strlen($dataPoints[$i][0]) * $this->fontSize) / 8;
                    $x = ((($dataPoints[$i][0] - $dataPoints[0][0]) / $points->xRange) * $points->xLength) + $points->zeroPoint['x'] - $strSize;
                    $y = $points->yOffset - ((($dataPoints[$i][1] - $dataPoints[0][1]) / $points->yRange) * $points->yLength);
                    if ($i < (count($dataPoints) - 1)) {
                        if (null !== $prevY) {
                            $nextY = $points->yOffset - ((($dataPoints[$i + 1][1] - $dataPoints[0][1]) / $points->yRange) * $points->yLength);
                        }
                        if ($this->adapter instanceof Pdf) {
                            if ((null !== $prevY) && ($y < $nextY) && ($y < $prevY)) {
                                $y -= $this->fontSize * 2;
                                if (null !== $this->fillColor) {
                                    $revColor = (null !== $this->reverseFontColor) ? $this->reverseFontColor : new Rgb(255, 255, 255);
                                    $this->adapter->setFillColor($revColor);
                                }
                            } else if (((null !== $prevY) && ($y < $nextY) && ($y > $prevY)) || ((null === $prevY) && ($y > $nextY))) {
                                $x -= $strSize * 2;
                            } else if (((null !== $prevY) && ($y > $nextY) && ($y < $prevY)) || ((null === $prevY) && ($y < $nextY))) {
                                $x += $strSize * 2;
                            }
                        } else {
                            if ((null !== $prevY) && ($y > $nextY) && ($y > $prevY)) {
                                $y += $this->fontSize * 2;
                                if (null !== $this->fillColor) {
                                    $revColor = (null !== $this->reverseFontColor) ? $this->reverseFontColor : new Rgb(255, 255, 255);
                                    $this->adapter->setFillColor($revColor);
                                }
                            } else if (((null !== $prevY) && ($y > $nextY) && ($y < $prevY)) || ((null === $prevY) && ($y > $nextY))) {
                                $x -= $strSize * 2;
                            } else if (((null !== $prevY) && ($y < $nextY) && ($y > $prevY)) || ((null === $prevY) && ($y < $nextY))) {
                                $x += $strSize * 2;
                            }
                        }
                    }

                    if (null !== $this->font) {
                        if ($this->adapter instanceof Pdf) {
                            $this->adapter->addText($x, ($y + ($this->fontSize / 2)), $this->fontSize, $dataPoints[$i][1], $this->fonts[$this->font]);
                        } else {
                            $this->adapter->text($dataPoints[$i][1], $this->fontSize, $x, ($y - ($this->fontSize / 2)), $this->fonts[$this->font]);
                        }
                    } else {
                        if ($this->adapter instanceof Pdf) {
                            $this->adapter->addFont('Arial');
                            $this->adapter->addText($x, ($y + ($this->fontSize / 2)), $this->fontSize, $dataPoints[$i][1], 'Arial');
                        } else {
                            $this->adapter->text($dataPoints[$i][1], $this->fontSize, $x, ($y - ($this->fontSize / 2)));
                        }
                    }
                    $prevY = $y;
                    $this->adapter->setFillColor($this->fontColor);
                }
                break;

            // Draw data point text on a vertical bar graph.
            case 'vBar':
                $this->adapter->setFillColor($this->fontColor);
                $realXDiv = ($points->xLength - ($this->barWidth * 2)) / (count($xAxis) - 1);
                for ($i = 0; $i < count($dataPoints); $i++) {
                    $strSize = (strlen($dataPoints[$i]) * $this->fontSize) / 4;
                    $x = ($realXDiv * ($i + 1)) - ($this->barWidth / 1.75) + ($this->barWidth / 2) - $strSize;
                    $y = $points->yOffset - ((($dataPoints[$i]) / $points->yRange) * $points->yLength);
                    if (null !== $this->font) {
                        if ($this->adapter instanceof Pdf) {
                            $this->adapter->addText($x, ($y + ($this->fontSize / 2)), $this->fontSize, $dataPoints[$i], $this->fonts[$this->font], $this->fontSize);
                        } else {
                            $this->adapter->text($dataPoints[$i], $this->fontSize, $x, ($y - ($this->fontSize / 2)), $this->fonts[$this->font]);
                        }
                    } else {
                        if ($this->adapter instanceof Pdf) {
                            $this->adapter->addFont('Arial');
                            $this->adapter->addText($x, ($y + ($this->fontSize / 2)), $this->fontSize, $dataPoints[$i], 'Arial');
                        } else {
                            $this->adapter->text($dataPoints[$i], $this->fontSize, $x, ($y - ($this->fontSize / 2)));
                        }
                    }
                }
                break;

            // Draw data point text on a horizontal bar graph.
            case 'hBar':
                $this->adapter->setFillColor($this->fontColor);
                if ($this->adapter instanceof Pdf) {
                    $realYDiv = ($points->yLength + ($this->barWidth * 2)) / (count($yAxis) - 1);
                } else {
                    $realYDiv = ($points->yLength - ($this->barWidth * 2)) / (count($yAxis) - 1);
                }

                $len = count($dataPoints);
                for ($i = 0; $i < $len; $i++) {
                    if ($this->adapter instanceof Pdf) {
                        $y = ($points->zeroPoint['y'] - ($realYDiv * $i)) + ($this->barWidth / 5) + ($this->barWidth / 2) - ($this->fontSize / 2);
                    } else {
                        $y = ($points->yLength - ($realYDiv * ($i + 1))) + ($this->barWidth * 1.1) + ($this->barWidth / 2) + ($this->fontSize / 2);
                    }
                    $x = (($dataPoints[$i] / $points->xRange) * $points->xLength) + $points->zeroPoint['x'] +  ($this->fontSize / 2);
                    if (null !== $this->font) {
                        if ($this->adapter instanceof Pdf) {
                            $this->adapter->addText($x, ($y + ($this->fontSize / 2)), $this->fontSize, $dataPoints[$i], $this->fonts[$this->font]);
                        } else {
                            $this->adapter->text($dataPoints[$i], $this->fontSize, $x, ($y - ($this->fontSize / 2)), $this->fonts[$this->font]);
                        }
                    } else {
                        if ($this->adapter instanceof Pdf) {
                            $this->adapter->addFont('Arial');
                            $this->adapter->addText($x, ($y + ($this->fontSize / 2)), $this->fontSize, $dataPoints[$i], 'Arial');
                        } else {
                            $this->adapter->text($dataPoints[$i], $this->fontSize, $x, ($y - ($this->fontSize / 2)));
                        }
                    }
                }
                break;

            // Draw data point text on a pie chart.
            case 'pie':

                for ($i = 0; $i < count($dataPoints); $i++) {
                    $newMidX = $xAxis[$i]['x'];
                    $newMidY = $xAxis[$i]['y'];
                    $this->adapter->setFillColor($this->fontColor);
                    if ($this->adapter instanceof Pdf) {
                        // Text not supported on PDF pie charts yet due to clipping path issues.
                    } else {
                        switch ($yAxis[$i]) {
                            case 1:
                                $textX = $newMidX + ($this->fontSize * 1.5);
                                $textY = $newMidY + ($this->fontSize * 1.5);
                                break;
                            case 2:
                                $textX = $newMidX - ($this->fontSize * 1.5);
                                $textY = $newMidY + ($this->fontSize * 1.5);
                                break;
                            case 3:
                                $textX = $newMidX - ($this->fontSize * 1.5);
                                $textY = $newMidY - ($this->fontSize * 1.5);
                                break;
                            case 4:
                                $textX = $newMidX + ($this->fontSize * 1.5);
                                $textY = $newMidY - ($this->fontSize * 1.5);
                                break;
                        }
                        $this->adapter->text($dataPoints[$i][0] . '%', $this->fontSize, $textX, $textY, $this->fonts[$this->font]);
                    }
                    $this->adapter->setFillColor($dataPoints[$i][1]);
                }
                break;
        }
    }

    /**
     * Method to calculate which quadrant a point is in.
     *
     * @param  array $point
     * @param  array $center
     * @return int
     */
    protected function getQuadrant($point, $center)
    {
        $quad = 0;

        if ($this->adapter instanceof Pdf) {
            if ($point['x'] >= $center['x']) {
                $quad = ($point['y'] >= $center['y']) ? 4 : 1;
            } else {
                $quad = ($point['y'] >= $center['y']) ? 3 : 2;
            }
        } else {
            if ($point['x'] >= $center['x']) {
                $quad = ($point['y'] <= $center['y']) ? 4 : 1;
            } else {
                $quad = ($point['y'] <= $center['y']) ? 3 : 2;
            }
        }

        return $quad;
    }

    /**
     * Method to calculate the points and data of a triangle.
     *
     * @param  array $point
     * @param  array $center
     * @param  int   $quad
     * @return array
     */
    protected function getTriangle($point, $center, $quad)
    {
        $tri = array();

        switch ($quad) {

            case 1:
                $tri['side1'] = $point['x'] - $center['x'];
                $tri['side2'] = abs($point['y'] - $center['y']);
                break;

            case 2:
                $tri['side1'] = $center['x'] - $point['x'];
                $tri['side2'] = abs($point['y'] - $center['y']);
                break;

            case 3:
                $tri['side1'] = $center['x'] - $point['x'];
                $tri['side2'] = abs($center['y'] - $point['y']);
                break;

            case 4:
                $tri['side1'] = $point['x'] - $center['x'];
                $tri['side2'] = abs($center['y'] - $point['y']);
                break;

        }

        $tri['hypot'] = round(hypot($tri['side1'], $tri['side2']));
        $tri['angle1'] = round(rad2deg(asin($tri['side2'] / $tri['hypot'])));
        $tri['angle2'] = round(rad2deg(asin($tri['side1'] / $tri['hypot'])));

        return $tri;
    }

}
