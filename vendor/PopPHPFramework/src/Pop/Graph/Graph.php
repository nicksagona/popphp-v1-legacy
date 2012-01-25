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
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Graph;

use Pop\Color\ColorInterface,
    Pop\Color\Rgb,
    Pop\File\File,
    Pop\Image\Gd,
    Pop\Image\Imagick,
    Pop\Image\Svg,
    Pop\Locale\Locale,
    Pop\Pdf\Pdf;

/**
 * @category   Pop
 * @package    Pop_Graph
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
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
    protected $_width = 0;

    /**
     * Graph canvas height
     * @var int
     */
    protected $_height = 0;

    /**
     * Graph canvas padding
     * @var int
     */
    protected $_padding = 50;

    /**
     * Graph graphic adapter interface
     * @var mixed
     */
    protected $_adapter = null;

    /**
     * Available fonts
     * @var array
     */
    protected $_fonts = array();

    /**
     * Current font to use
     * @var string
     */
    protected $_font = null;

    /**
     * Font size
     * @var int
     */
    protected $_fontSize = 12;

    /**
     * Font color
     * @var mixed
     */
    protected $_fontColor = null;

    /**
     * Reverse font color
     * @var mixed
     */
    protected $_reverseFontColor = null;

    /**
     * Fill color
     * @var mixed
     */
    protected $_fillColor = null;

    /**
     * Stroke color
     * @var mixed
     */
    protected $_strokeColor = null;

    /**
     * Stroke width
     * @var int
     */
    protected $_strokeWidth = 1;

    /**
     * Axis color
     * @var mixed
     */
    protected $_axisColor = null;

    /**
     * Axis width
     * @var int
     */
    protected $_axisWidth = 2;

    /**
     * Bar width
     * @var int
     */
    protected $_barWidth = 50;

    /**
     * Show data text flag
     * @var boolean
     */
    protected $_showText = false;

    /**
     * Show X-axis increment lines flag
     * @var boolean
     */
    protected $_showX = false;

    /**
     * Show X-axis color
     * @var mixed
     */
    protected $_showXColor = null;

    /**
     * Show Y-axis increment lines flag
     * @var boolean
     */
    protected $_showY = false;

    /**
     * Show X-axis color
     * @var mixed
     */
    protected $_showYColor = null;

    /**
     * Constructor
     *
     * Instantiate the graph object.
     *
     * @param  string $filename
     * @param  int    $w
     * @param  int    $h
     * @param  int    $type
     * @param  mixed  $bgcolor
     * @return void
     */
    public function __construct($filename, $w, $h, $type = Graph::GD, ColorInterface $bgcolor = null)
    {
        $this->_width = $w;
        $this->_height = $h;
        $this->_fontColor = new Rgb(0, 0, 0);
        $this->_axisColor = new Rgb(0, 0, 0);
        $this->_showXColor = new Rgb(200, 200, 200);
        $this->_showYColor = new Rgb(200, 200, 200);

        if (stripos($filename, '.svg') !== false) {
            $this->_adapter = new Svg($filename, $w, $h, $bgcolor);
        } else if (stripos($filename, '.pdf') !== false) {
            $this->_adapter = new Pdf($filename, null, $w, $h);
        } else if ($type == self::IMAGICK) {
            $this->_adapter = new Imagick($filename, $w, $h, $bgcolor);
        } else {
            $this->_adapter = new Gd($filename, $w, $h, $bgcolor);
        }
    }

    /**
     * Get the graph graphic adapter
     *
     * @return mixed
     */
    public function adapter()
    {
        return $this->_adapter;
    }

    /**
     * Set the font to use from the available fonts
     *
     * @param  mixed $color
     * @param  int   $width
     * @return Pop\Graph\Graph
     */
    public function setAxisOptions(ColorInterface $color = null, $width = 2)
    {
        $this->_axisColor = (null === $color) ? new Rgb(0, 0, 0) : $color;
        $this->_axisWidth = (int)$width;

        return $this;
    }

    /**
     * Add a font to available fonts
     *
     * @param  string $font
     * @return Pop\Graph\Graph
     */
    public function addFont($font)
    {
        if ($this->_adapter instanceof Pdf) {
            $this->_adapter->addFont($font);
            $this->_font = $this->_adapter->getLastFontName();
            $this->_fonts[$this->_font] = $this->_font;
        } else {
            $fontFile = new File($font);
            $this->_font = $fontFile->filename;
            $this->_fonts[$this->_font] = $font;
        }

        return $this;
    }

    /**
     * Set the font to use from the available fonts
     *
     * @param  string $font
     * @throws Exception
     * @return Pop\Graph\Graph
     */
    public function setFont($font = null)
    {
        if ((null !== $font) && !array_key_exists($font, $this->_fonts)) {
            throw new Exception($this->_lang->__('That font is not available.'));
        } else {
            $this->_font = $font;
        }

        return $this;
    }

    /**
     * Set the font size
     *
     * @param  int $size
     * @return Pop\Graph\Graph
     */
    public function setFontSize($size)
    {
        $this->_fontSize = (int)$size;
        return $this;
    }

    /**
     * Set the font color
     *
     * @param  mixed $color
     * @return Pop\Graph\Graph
     */
    public function setFontColor(ColorInterface $color)
    {
        $this->_fontColor = $color;
        return $this;
    }

    /**
     * Set the font color
     *
     * @param  mixed $color
     * @return Pop\Graph\Graph
     */
    public function setReverseFontColor(ColorInterface $color)
    {
        $this->_reverseFontColor = $color;
        return $this;
    }

    /**
     * Set the fill color
     *
     * @param  mixed $color
     * @return Pop\Graph\Graph
     */
    public function setFillColor(ColorInterface $color)
    {
        $this->_fillColor = $color;
        return $this;
    }

    /**
     * Set the stroke color
     *
     * @param  mixed $color
     * @return Pop\Graph\Graph
     */
    public function setStrokeColor(ColorInterface $color)
    {
        $this->_strokeColor = $color;
        return $this;
    }

    /**
     * Set the stroke width
     *
     * @param  int $width
     * @return Pop\Graph\Graph
     */
    public function setStrokeWidth($width = 1)
    {
        $this->_strokeWidth = $width;
        return $this;
    }

    /**
     * Set the graph canvas padding
     *
     * @param  int $pad
     * @return Pop\Graph\Graph
     */
    public function setPadding($pad)
    {
        $this->_padding = (int)$pad;
        return $this;
    }

    /**
     * Set the bar width
     *
     * @param  int $width
     * @return Pop\Graph\Graph
     */
    public function setBarWidth($width)
    {
        $this->_barWidth = (int)$width;
        return $this;
    }

    /**
     * Set the 'show data text' flag
     *
     * @param  boolean $showText
     * @return Pop\Graph\Graph
     */
    public function showText($showText)
    {
        $this->_showText = (boolean)$showText;
        return $this;
    }

    /**
     * Set the 'show X-axis increment lines' flag
     *
     * @param  boolean $showX
     * @param  mixed   $color
     * @return Pop\Graph\Graph
     */
    public function showX($showX, ColorInterface $color = null)
    {
        $this->_showX = (boolean)$showX;
        $this->_showXColor = (null === $color) ? new Rgb(200, 200, 200) : $color;
        return $this;
    }

    /**
     * Set the 'show Y-axis increment lines' flag
     *
     * @param  boolean $showY
     * @param  mixed   $color
     * @return Pop\Graph\Graph
     */
    public function showY($showY, ColorInterface $color = null)
    {
        $this->_showY = (boolean)$showY;
        $this->_showYColor = (null === $color) ? new Rgb(200, 200, 200) : $color;
        return $this;
    }

    /**
     * Add a line graph
     *
     * @param  array $dataPoints
     * @param  array $xAxis
     * @param  array $yAxis
     * @return Pop\Graph\Graph
     */
    public function addLineGraph(array $dataPoints, array $xAxis, array $yAxis)
    {
        // Calculate the points.
        $points = $this->_getPoints($xAxis, $yAxis);

        if ($this->_showX) {
            $this->_showXAxis($yAxis, $points);
        }
        if ($this->_showY) {
            $this->_showYAxis($xAxis, $points);
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
        if (null !== $this->_fillColor) {
            $this->_adapter->setFillColor($this->_fillColor);
            $this->_adapter->setStrokeColor((null !== $this->_strokeColor) ? $this->_strokeColor : $this->_fillColor);
            $this->_adapter->setStrokeWidth($this->_strokeWidth);
            $formattedPoints = array();
            for ($i = 0; $i < count($dataPoints); $i++) {
                $x = ((($dataPoints[$i][0] - $dataPoints[0][0]) / $points->xRange) * $points->xLength) + $points->zeroPoint['x'];
                $y = $points->yOffset - ((($dataPoints[$i][1] - $dataPoints[0][1]) / $points->yRange) * $points->yLength);
                $formattedPoints[] = array('x' => $x, 'y' => $y);
                $lastX = $x;
            }
            $formattedPoints[] = array('x' => $lastX, 'y' => $points->zeroPoint['y']);
            $this->_adapter->addPolygon($formattedPoints);
        } else {
            $this->_adapter->setStrokeWidth($this->_strokeWidth);
            $this->_adapter->setStrokeColor((null !== $this->_strokeColor) ? $this->_strokeColor : new Rgb(0, 0, 0));

            for ($i = 1; $i < count($dataPoints); $i++) {
                $x1 = ((($dataPoints[$i - 1][0] - $dataPoints[0][0]) / $points->xRange) * $points->xLength) + $points->zeroPoint['x'];
                $y1 = $points->yOffset - ((($dataPoints[$i - 1][1] - $dataPoints[0][1]) / $points->yRange) * $points->yLength);
                $x2 = ((($dataPoints[$i][0] - $dataPoints[0][0]) / $points->xRange) * $points->xLength) + $points->zeroPoint['x'];
                $y2 = $points->yOffset - ((($dataPoints[$i][1] - $dataPoints[0][1]) / $points->yRange) * $points->yLength);
                $this->_adapter->addLine($x1, $y1, $x2, $y2);
            }

        }

        // Draw data point text.
        if ($this->_showText) {
            $this->_drawDataText($dataPoints, $xAxis, $yAxis, 'line', $points, $skip);
        }

        // Draw graph axes.
        $this->_drawXAxis($xAxis, $points);
        $this->_drawYAxis($yAxis, $points);

        return $this;
    }

    /**
     * Add a vertical bar graph
     *
     * @param  array $dataPoints
     * @param  array $xAxis
     * @param  array $yAxis
     * @return Pop\Graph\Graph
     */
    public function addVBarGraph(array $dataPoints, array $xAxis, array $yAxis)
    {
        // Calculate the points.
        $points = $this->_getPoints($xAxis, $yAxis);

        if ($this->_showX) {
            $this->_showXAxis($yAxis, $points, $this->_barWidth);
        }
        if ($this->_showY) {
            $this->_showYAxis($xAxis, $points);
        }

        // Draw graph data.
        $realXDiv = ($points->xLength - ($this->_barWidth * 2)) / (count($xAxis) - 1);

        if ((null !== $this->_fillColor) || is_array($dataPoints[0])) {
            $this->_adapter->setStrokeWidth($this->_strokeWidth);
            for ($i = 0; $i < count($dataPoints); $i++) {
                if (is_array($dataPoints[$i])) {
                    $pt = $dataPoints[$i][0];
                    $this->_adapter->setStrokeColor((null !== $this->_strokeColor) ? $this->_strokeColor : $dataPoints[$i][1]);
                    $this->_adapter->setFillColor($dataPoints[$i][1]);
                } else {
                    $pt = $dataPoints[$i];
                    $this->_adapter->setStrokeColor((null !== $this->_strokeColor) ? $this->_strokeColor : $this->_fillColor);
                    $this->_adapter->setFillColor($this->_fillColor);
                }
                $x = ($realXDiv * ($i + 1)) - ($this->_barWidth / 1.75);
                $y = $points->yOffset - ((($pt) / $points->yRange) * $points->yLength);
                $w = $this->_barWidth;
                $h = $points->zeroPoint['y'] - $y;
                $this->_adapter->addRectangle($x, $y, $w, $h);
            }
        } else {
            $this->_adapter->setStrokeWidth($this->_strokeWidth);
            $this->_adapter->setStrokeColor((null !== $this->_strokeColor) ? $this->_strokeColor : new Rgb(0, 0, 0));
            for ($i = 0; $i < count($dataPoints); $i++) {
                $x = ($realXDiv * ($i + 1)) - ($this->_barWidth / 1.75);
                $y = $points->yOffset - ((($dataPoints[$i]) / $points->yRange) * $points->yLength);
                $w = $this->_barWidth;
                $h = $points->zeroPoint['y'] - $y;
                $this->_adapter->addLine($x, $y, $x, ($y + $h));
                $this->_adapter->addLine($x, $y, ($x + $w), $y);
                $this->_adapter->addLine(($x + $w), $y, ($x + $w), ($y + $h));
            }
        }

        // Draw data point text.
        if ($this->_showText) {
            if (is_array($dataPoints[0])) {
                $dPts = array();
                foreach ($dataPoints as $value) {
                    $dPts[] = $value[0];
                }
            } else {
                $dPts = $dataPoints;
            }
            $this->_drawDataText($dPts, $xAxis, $yAxis, 'vBar', $points);
        }

        // Draw graph axes.
        $this->_drawXAxis($xAxis, $points, $this->_barWidth);
        $this->_drawYAxis($yAxis, $points);

        return $this;
    }

    /**
     * Add a horizontal bar graph
     *
     * @param  array $dataPoints
     * @param  array $xAxis
     * @param  array $yAxis
     * @return Pop\Graph\Graph
     */
    public function addHBarGraph(array $dataPoints, array $xAxis, array $yAxis)
    {
        // Calculate the points.
        $points = $this->_getPoints($xAxis, $yAxis);

        if ($this->_showX) {
            $this->_showXAxis($yAxis, $points);
        }
        if ($this->_showY) {
            $this->_showYAxis($xAxis, $points, $this->_barWidth);
        }

        // Draw graph data.
        if ($this->_adapter instanceof Pdf) {
            $realYDiv = ($points->yLength + ($this->_barWidth * 2)) / (count($yAxis) - 1);
        } else {
            $realYDiv = ($points->yLength - ($this->_barWidth * 2)) / (count($yAxis) - 1);
        }

        if ((null !== $this->_fillColor) || is_array($dataPoints[0])) {
            $this->_adapter->setFillColor($this->_fillColor);
            $this->_adapter->setStrokeColor((null !== $this->_strokeColor) ? $this->_strokeColor : $this->_fillColor);
            $this->_adapter->setStrokeWidth($this->_strokeWidth);
            $len = count($dataPoints);
            for ($i = 0; $i < $len; $i++) {
                if (is_array($dataPoints[$i])) {
                    $pt = $dataPoints[$i][0];
                    $this->_adapter->setStrokeColor((null !== $this->_strokeColor) ? $this->_strokeColor : $dataPoints[$i][1]);
                    $this->_adapter->setFillColor($dataPoints[$i][1]);
                } else {
                    $pt = $dataPoints[$i];
                    $this->_adapter->setStrokeColor((null !== $this->_strokeColor) ? $this->_strokeColor : $this->_fillColor);
                    $this->_adapter->setFillColor($this->_fillColor);
                }
                if ($this->_adapter instanceof Pdf) {
                    $y = ($points->zeroPoint['y'] - ($realYDiv * $i)) + ($this->_barWidth / 5);
                } else {
                    $y = ($points->yLength - ($realYDiv * ($i + 1))) + ($this->_barWidth * 1.1);
                }
                $x = $points->zeroPoint['x'];
                $h = $this->_barWidth;
                $w = (($pt / $points->xRange) * $points->xLength);
                $this->_adapter->addRectangle($x, $y, $w, $h);
            }
        } else {
            $this->_adapter->setStrokeWidth($this->_strokeWidth);
            $this->_adapter->setStrokeColor((null !== $this->_strokeColor) ? $this->_strokeColor : new Rgb(0, 0, 0));
            for ($i = 0; $i < count($dataPoints); $i++) {
                if ($this->_adapter instanceof Pdf) {
                    $y = ($points->zeroPoint['y'] - ($realYDiv * $i)) + ($this->_barWidth / 5);
                } else {
                    $y = ($points->yLength - ($realYDiv * ($i + 1))) + ($this->_barWidth * 1.1);
                }
                $x = $points->zeroPoint['x'];
                $h = $this->_barWidth;
                $w = (($dataPoints[$i] / $points->xRange) * $points->xLength);
                $this->_adapter->addLine($x, $y, ($x + $w), $y);
                $this->_adapter->addLine(($x + $w), $y, ($x + $w), ($y + $h));
                $this->_adapter->addLine(($x + $w), ($y + $h), $x, ($y + $h));
            }
        }

        // Draw data point text.
        if ($this->_showText) {
            if (is_array($dataPoints[0])) {
                $dPts = array();
                foreach ($dataPoints as $value) {
                    $dPts[] = $value[0];
                }
            } else {
                $dPts = $dataPoints;
            }
            $this->_drawDataText($dPts, $xAxis, $yAxis, 'hBar', $points);
        }

        // Draw graph axes.
        $this->_drawXAxis($xAxis, $points);
        $this->_drawYAxis($yAxis, $points, $this->_barWidth);

        return $this;
    }

    /**
     * Add a pie chart
     *
     * @param  array $pie
     * @param  array $percents
     * @param  int   $explode
     * @throws Exception
     * @return Pop\Graph\Graph
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
            throw new Exception(Locale::factory()->__('The percentages are greater than 100.'));
        } else {
            $start = 0;
            $end = 0;
            foreach ($percents as $value) {
                $amt = round(($value[0] / 100) * 360);
                if ($start == 0) {
                    $end = $amt;
                } else {
                    $end = $start + $amt;
                }
                $this->_adapter->setFillColor($value[1]);

                if ($explode != 0) {
                    $center = array('x' => $pie['x'], 'y' => $pie['y']);
                    $mid = (($end - $start) / 2) + $start;
                    $midX = round($pie['x'] + ($pie['w'] * (cos($mid / 180 * pi()))));
                    $midY = round($pie['y'] + ($pie['h'] * (sin($mid / 180 * pi()))));
                    $midPt = array('x' => $midX, 'y' => $midY);

                    $quad = $this->_getQuadrant($midPt, $center);
                    $triangle = $this->_getTriangle($midPt, $center, $quad);

                    $newHypot = $triangle['hypot'] - $explode;
                    $newSide1 = round(sin(deg2rad($triangle['angle2'])) * $newHypot);
                    $newSide2 = round(sin(deg2rad($triangle['angle1'])) * $newHypot);

                    if ($this->_adapter instanceof Pdf) {
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
                $quad = $this->_getQuadrant($newMidPts, array('x' => $x, 'y' => $y));

                $textMidPts[] = $newMidPts;
                $textQuads[] = $quad;
                $textValues[] = $value;

                $this->_adapter->addArc($x, $y, $start, $end, $pie['w'], $pie['h']);
                $start = $end;
            }
        }

        // Draw data point text.
        if ($this->_showText) {
            $this->_drawDataText($textValues, $textMidPts, $textQuads, 'pie');
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
        $this->_adapter->output();
    }

    /**
     * Get points
     *
     * @param  array $xAxis
     * @param  array $yAxis
     * @return ArrayObject
     */
    protected function _getPoints($xAxis, $yAxis)
    {
        if ($this->_adapter instanceof Pdf) {
            $zeroPoint = array('x' => $this->_padding, 'y' => $this->_padding);
            $endX = array('x' => ($this->_width - $this->_padding), 'y' => $zeroPoint['y']);
            $endY = array('x' => $zeroPoint['x'], 'y' => ($this->_height - $this->_padding));
            $xOffset = $this->_padding;
            $yOffset = $this->_padding;
        } else {
            $zeroPoint = array('x' => $this->_padding, 'y' => ($this->_height- $this->_padding));
            $endX = array('x' => ($this->_width- $this->_padding), 'y' => $zeroPoint['y']);
            $endY = array('x' => $zeroPoint['x'], 'y' => $this->_padding);
            $xOffset = $this->_padding;
            $yOffset = $this->_height- $this->_padding;
        }

        $xLength = $endX['x'] - $zeroPoint['x'];
        $yLength = $zeroPoint['y'] - $endY['y'];
        $xRange = (float)$xAxis[count($xAxis) - 1] - (float)$xAxis[0];
        $yRange = (float)$yAxis[count($yAxis) - 1] - (float)$yAxis[0];

        $xDiv = $xLength / (count($xAxis) - 1);
        $yDiv = $yLength / (count($yAxis) - 1);

        $points = new \ArrayObject(
                                   array(
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
                                   ), \ArrayObject::ARRAY_AS_PROPS
                                   );

        return $points;
    }

    /**
     * Draw the X Axis increments
     *
     * @param  array       $xAxis
     * @param  ArrayObject $points
     * @param  int         $offset
     * @return void
     */
    protected function _showXAxis($xAxis, $points, $offset = 0)
    {
        $this->_adapter->setStrokeWidth(1);
        $this->_adapter->setStrokeColor($this->_showYColor);
        $this->_adapter->addLine($points->zeroPoint['x'], $points->zeroPoint['y'], $points->endX['x'], $points->endX['y']);
        $this->_adapter->setFillColor($this->_fontColor);

        $i = 0;

        if ($offset != 0) {
            $realXDiv = ($points->xLength - ($offset * 2)) / (count($xAxis) - 1);
            $realZeroX = $points->zeroPoint['x'] + ($realXDiv / 2);
        } else {
            $realXDiv = $points->xDiv;
            $realZeroX = $points->zeroPoint['x'];
        }

        foreach ($xAxis as $x) {
            if ($this->_adapter instanceof Pdf) {
                $this->_adapter->addLine($realZeroX + ($realXDiv * $i), $points->zeroPoint['y'], $realZeroX + ($realXDiv * $i), ($this->_height - $this->_padding));
            } else {
                $this->_adapter->addLine($realZeroX + ($realXDiv * $i), $points->zeroPoint['y'] - $points->yLength, $realZeroX + ($realXDiv * $i), $points->zeroPoint['y']);
            }
            $i++;
        }
    }

    /**
     * Draw the Y Axis increments
     *
     * @param  array       $yAxis
     * @param  ArrayObject $points
     * @param  int         $offset
     * @return void
     */
    protected function _showYAxis($yAxis, $points, $offset = 0)
    {
        $this->_adapter->setStrokeWidth(1);
        $this->_adapter->setStrokeColor($this->_showXColor);
        $this->_adapter->setFillColor($this->_fontColor);

        $i = 0;

        if ($offset != 0) {
            if ($this->_adapter instanceof Pdf) {
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
            $this->_adapter->addLine($points->zeroPoint['x'], $realZeroY - ($realYDiv * $i), ($this->_width - $this->_padding), $realZeroY - ($realYDiv * $i));
            $i++;
        }
    }

    /**
     * Draw the X Axis
     *
     * @param  array       $xAxis
     * @param  ArrayObject $points
     * @param  int         $offset
     * @return void
     */
    protected function _drawXAxis($xAxis, $points, $offset = 0)
    {
        $this->_adapter->setStrokeWidth($this->_axisWidth);
        $this->_adapter->setStrokeColor($this->_axisColor);
        $this->_adapter->addLine($points->zeroPoint['x'], $points->zeroPoint['y'], $points->endX['x'], $points->endX['y']);
        $this->_adapter->setFillColor($this->_fontColor);

        $i = 0;

        if ($offset != 0) {
            $realXDiv = ($points->xLength - ($offset * 2)) / (count($xAxis) - 1);
            $realZeroX = $points->zeroPoint['x'] + ($realXDiv / 2);
        } else {
            $realXDiv = $points->xDiv;
            $realZeroX = $points->zeroPoint['x'];
        }

        foreach ($xAxis as $x) {
            $xFontOffset = ($this->_fontSize * strlen($x)) / 3;
            $yFontOffset = $this->_fontSize + 10;
            if ($this->_adapter instanceof Pdf) {
                $this->_adapter->addLine($realZeroX + ($realXDiv * $i), $points->zeroPoint['y'], $realZeroX + ($realXDiv * $i), $points->zeroPoint['y'] - 5);
            } else {
                $this->_adapter->addLine($realZeroX + ($realXDiv * $i), $points->zeroPoint['y'], $realZeroX + ($realXDiv * $i), $points->zeroPoint['y'] + 5);
            }

            if (null !== $this->_font) {
                if ($this->_adapter instanceof Pdf) {
                    $this->_adapter->addText($realZeroX + ($realXDiv * $i) - $xFontOffset, $points->zeroPoint['y'] - $yFontOffset, $this->_fontSize, $x, $this->_fonts[$this->_font]);
                } else {
                    $this->_adapter->text($x, $this->_fontSize, $realZeroX + ($realXDiv * $i) - $xFontOffset, $points->zeroPoint['y'] + $yFontOffset, $this->_fonts[$this->_font]);
                }
            } else {
                if ($this->_adapter instanceof Pdf) {
                    $this->_adapter->addFont('Arial');
                    $this->_adapter->addText($realZeroX + ($realXDiv * $i) - $xFontOffset, $points->zeroPoint['y'] - $yFontOffset, $this->_fontSize, $x, 'Arial');
                } else {
                    $this->_adapter->text($x, $this->_fontSize, $realZeroX + ($realXDiv * $i) - $xFontOffset, $points->zeroPoint['y'] + $yFontOffset);
                }
            }
            $i++;
        }
    }

    /**
     * Draw the Y Axis
     *
     * @param  array       $yAxis
     * @param  ArrayObject $points
     * @param  int         $offset
     * @return void
     */
    protected function _drawYAxis($yAxis, $points, $offset = 0)
    {
        $this->_adapter->setStrokeWidth($this->_axisWidth);
        $this->_adapter->setStrokeColor($this->_axisColor);
        $this->_adapter->addLine($points->zeroPoint['x'], $points->zeroPoint['y'], $points->endY['x'], $points->endY['y']);
        $this->_adapter->setFillColor($this->_fontColor);

        $i = 0;

        if ($offset != 0) {
            if ($this->_adapter instanceof Pdf) {
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
            $xFontOffset = (($this->_fontSize * strlen($y)) / 1.5) + 15;
            $yFontOffset = $this->_fontSize / 2;
            $this->_adapter->addLine($points->zeroPoint['x'], $realZeroY - ($realYDiv * $i), $points->zeroPoint['x'] - 5, $realZeroY - ($realYDiv * $i));
            if (null !== $this->_font) {
                if ($this->_adapter instanceof Pdf) {
                    $this->_adapter->addText($points->zeroPoint['x'] - $xFontOffset, $realZeroY - ($realYDiv * $i) - $yFontOffset, $this->_fontSize, $y, $this->_fonts[$this->_font]);
                } else {
                    $this->_adapter->text($y, $this->_fontSize, $points->zeroPoint['x'] - $xFontOffset, $realZeroY - ($realYDiv * $i) + $yFontOffset, $this->_fonts[$this->_font]);
                }
            } else {
                if ($this->_adapter instanceof Pdf) {
                    $this->_adapter->addFont('Arial');
                    $this->_adapter->addText($points->zeroPoint['x'] - $xFontOffset, $realZeroY - ($realYDiv * $i) - $yFontOffset, $this->_fontSize, $y, 'Arial');
                } else {
                    $this->_adapter->text($y, $this->_fontSize, $points->zeroPoint['x'] - $xFontOffset, $realZeroY - ($realYDiv * $i) + $yFontOffset);
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
     * @return void
     */
    protected function _drawDataText($dataPoints, $xAxis, $yAxis, $type, $points = null, $skip = 1)
    {
        switch ($type) {
            // Draw data point text on a line graph.
            case 'line':
                $this->_adapter->setFillColor($this->_fontColor);
                $prevY = null;
                $nextY = null;
                $start = $skip;

                for ($i = $start; $i < count($dataPoints); $i++) {
                    $strSize = (strlen($dataPoints[$i][0]) * $this->_fontSize) / 8;
                    $x = ((($dataPoints[$i][0] - $dataPoints[0][0]) / $points->xRange) * $points->xLength) + $points->zeroPoint['x'] - $strSize;
                    $y = $points->yOffset - ((($dataPoints[$i][1] - $dataPoints[0][1]) / $points->yRange) * $points->yLength);
                    if ($i < (count($dataPoints) - 1)) {
                        if (null !== $prevY) {
                            $nextY = $points->yOffset - ((($dataPoints[$i + 1][1] - $dataPoints[0][1]) / $points->yRange) * $points->yLength);
                        }
                        if ($this->_adapter instanceof Pdf) {
                            if ((null !== $prevY) && ($y < $nextY) && ($y < $prevY)) {
                                $y -= $this->_fontSize * 2;
                                if (null !== $this->_fillColor) {
                                    $revColor = (null !== $this->_reverseFontColor) ? $this->_reverseFontColor : new Rgb(255, 255, 255);
                                    $this->_adapter->setFillColor($revColor);
                                }
                            } else if (((null !== $prevY) && ($y < $nextY) && ($y > $prevY)) || ((null === $prevY) && ($y > $nextY))) {
                                $x -= $strSize * 2;
                            } else if (((null !== $prevY) && ($y > $nextY) && ($y < $prevY)) || ((null === $prevY) && ($y < $nextY))) {
                                $x += $strSize * 2;
                            }
                        } else {
                            if ((null !== $prevY) && ($y > $nextY) && ($y > $prevY)) {
                                $y += $this->_fontSize * 2;
                                if (null !== $this->_fillColor) {
                                    $revColor = (null !== $this->_reverseFontColor) ? $this->_reverseFontColor : new Rgb(255, 255, 255);
                                    $this->_adapter->setFillColor($revColor);
                                }
                            } else if (((null !== $prevY) && ($y > $nextY) && ($y < $prevY)) || ((null === $prevY) && ($y > $nextY))) {
                                $x -= $strSize * 2;
                            } else if (((null !== $prevY) && ($y < $nextY) && ($y > $prevY)) || ((null === $prevY) && ($y < $nextY))) {
                                $x += $strSize * 2;
                            }
                        }
                    }

                    if (null !== $this->_font) {
                        if ($this->_adapter instanceof Pdf) {
                            $this->_adapter->addText($x, ($y + ($this->_fontSize / 2)), $this->_fontSize, $dataPoints[$i][1], $this->_fonts[$this->_font]);
                        } else {
                            $this->_adapter->text($dataPoints[$i][1], $this->_fontSize, $x, ($y - ($this->_fontSize / 2)), $this->_fonts[$this->_font]);
                        }
                    } else {
                        if ($this->_adapter instanceof Pdf) {
                            $this->_adapter->addFont('Arial');
                            $this->_adapter->addText($x, ($y + ($this->_fontSize / 2)), $this->_fontSize, $dataPoints[$i][1], 'Arial');
                        } else {
                            $this->_adapter->text($dataPoints[$i][1], $this->_fontSize, $x, ($y - ($this->_fontSize / 2)));
                        }
                    }
                    $prevY = $y;
                    $this->_adapter->setFillColor($this->_fontColor);
                }
                break;

            // Draw data point text on a vertical bar graph.
            case 'vBar':
                $this->_adapter->setFillColor($this->_fontColor);
                $realXDiv = ($points->xLength - ($this->_barWidth * 2)) / (count($xAxis) - 1);
                for ($i = 0; $i < count($dataPoints); $i++) {
                    $strSize = (strlen($dataPoints[$i]) * $this->_fontSize) / 4;
                    $x = ($realXDiv * ($i + 1)) - ($this->_barWidth / 1.75) + ($this->_barWidth / 2) - $strSize;
                    $y = $points->yOffset - ((($dataPoints[$i]) / $points->yRange) * $points->yLength);
                    if (null !== $this->_font) {
                        if ($this->_adapter instanceof Pdf) {
                            $this->_adapter->addText($x, ($y + ($this->_fontSize / 2)), $this->_fontSize, $dataPoints[$i], $this->_fonts[$this->_font], $this->_fontSize);
                        } else {
                            $this->_adapter->text($dataPoints[$i], $this->_fontSize, $x, ($y - ($this->_fontSize / 2)), $this->_fonts[$this->_font]);
                        }
                    } else {
                        if ($this->_adapter instanceof Pdf) {
                            $this->_adapter->addFont('Arial');
                            $this->_adapter->addText($x, ($y + ($this->_fontSize / 2)), $this->_fontSize, $dataPoints[$i], 'Arial');
                        } else {
                            $this->_adapter->text($dataPoints[$i], $this->_fontSize, $x, ($y - ($this->_fontSize / 2)));
                        }
                    }
                }
                break;

            // Draw data point text on a horizontal bar graph.
            case 'hBar':
                $this->_adapter->setFillColor($this->_fontColor);
                if ($this->_adapter instanceof Pdf) {
                    $realYDiv = ($points->yLength + ($this->_barWidth * 2)) / (count($yAxis) - 1);
                } else {
                    $realYDiv = ($points->yLength - ($this->_barWidth * 2)) / (count($yAxis) - 1);
                }

                $len = count($dataPoints);
                for ($i = 0; $i < $len; $i++) {
                    if ($this->_adapter instanceof Pdf) {
                        $y = ($points->zeroPoint['y'] - ($realYDiv * $i)) + ($this->_barWidth / 5) + ($this->_barWidth / 2) - ($this->_fontSize / 2);
                    } else {
                        $y = ($points->yLength - ($realYDiv * ($i + 1))) + ($this->_barWidth * 1.1) + ($this->_barWidth / 2) + ($this->_fontSize / 2);
                    }
                    $x = (($dataPoints[$i] / $points->xRange) * $points->xLength) + $points->zeroPoint['x'] +  ($this->_fontSize / 2);
                    if (null !== $this->_font) {
                        if ($this->_adapter instanceof Pdf) {
                            $this->_adapter->addText($x, ($y + ($this->_fontSize / 2)), $this->_fontSize, $dataPoints[$i], $this->_fonts[$this->_font]);
                        } else {
                            $this->_adapter->text($dataPoints[$i], $this->_fontSize, $x, ($y - ($this->_fontSize / 2)), $this->_fonts[$this->_font]);
                        }
                    } else {
                        if ($this->_adapter instanceof Pdf) {
                            $this->_adapter->addFont('Arial');
                            $this->_adapter->addText($x, ($y + ($this->_fontSize / 2)), $this->_fontSize, $dataPoints[$i], 'Arial');
                        } else {
                            $this->_adapter->text($dataPoints[$i], $this->_fontSize, $x, ($y - ($this->_fontSize / 2)));
                        }
                    }
                }
                break;

            // Draw data point text on a pie chart.
            case 'pie':

                for ($i = 0; $i < count($dataPoints); $i++) {
                    $newMidX = $xAxis[$i]['x'];
                    $newMidY = $xAxis[$i]['y'];
                    $this->_adapter->setFillColor($this->_fontColor);
                    if ($this->_adapter instanceof Pdf) {
                        // Text not supported on PDF pie charts yet due to clipping path issues.
                    } else {
                        switch ($yAxis[$i]) {
                            case 1:
                                $textX = $newMidX + ($this->_fontSize * 1.5);
                                $textY = $newMidY + ($this->_fontSize * 1.5);
                                break;
                            case 2:
                                $textX = $newMidX - ($this->_fontSize * 1.5);
                                $textY = $newMidY + ($this->_fontSize * 1.5);
                                break;
                            case 3:
                                $textX = $newMidX - ($this->_fontSize * 1.5);
                                $textY = $newMidY - ($this->_fontSize * 1.5);
                                break;
                            case 4:
                                $textX = $newMidX + ($this->_fontSize * 1.5);
                                $textY = $newMidY - ($this->_fontSize * 1.5);
                                break;
                        }
                        $this->_adapter->text($dataPoints[$i][0] . '%', $this->_fontSize, $textX, $textY, $this->_fonts[$this->_font]);
                    }
                    $this->_adapter->setFillColor($dataPoints[$i][1]);
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
    protected function _getQuadrant($point, $center)
    {
        $quad = 0;

        if ($this->_adapter instanceof Pdf) {
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
    protected function _getTriangle($point, $center, $quad)
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
