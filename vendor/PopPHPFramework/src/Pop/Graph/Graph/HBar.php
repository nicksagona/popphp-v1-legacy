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
namespace Pop\Graph\Graph;

/**
 * This is the horizontal bar class for the Graph component.
 *
 * @category   Pop
 * @package    Pop_Graph
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.1.2
 */
class HBar extends AbstractGraph
{

    /**
     * Create a horizontal bar graph
     *
     * @param  array $dataPoints
     * @param  array $xAxis
     * @param  array $yAxis
     * @return \Pop\Graph\Graph\HBar
     */
    public function create(array $dataPoints, array $xAxis, array $yAxis)
    {
        // Calculate the points.
        $points = $this->getPoints($xAxis, $yAxis);

        if ($this->graph->getShowX()) {
            $this->showXAxis($yAxis, $points);
        }
        if ($this->graph->getShowX()) {
            $this->showYAxis($xAxis, $points, $this->graph->getBarWidth());
        }

        // Draw graph data.
        if ($this->graph->adapter() instanceof \Pop\Pdf\Pdf) {
            $realYDiv = ($points->yLength + ($this->graph->getBarWidth() * 2)) / (count($yAxis) - 1);
        } else {
            $realYDiv = ($points->yLength - ($this->graph->getBarWidth() * 2)) / (count($yAxis) - 1);
        }

        if ((null !== $this->graph->getFillColor()) || is_array($dataPoints[0])) {
            $this->graph->adapter()->setFillColor($this->graph->getFillColor());
            $this->graph->adapter()->setStrokeColor((null !== $this->graph->getStrokeColor()) ? $this->graph->getStrokeColor() : $this->graph->getFillColor());
            $this->graph->adapter()->setStrokeWidth($this->graph->getStrokeWidth());
            $len = count($dataPoints);
            for ($i = 0; $i < $len; $i++) {
                if (is_array($dataPoints[$i])) {
                    $pt = $dataPoints[$i][0];
                    $this->graph->adapter()->setStrokeColor((null !== $this->graph->getStrokeColor()) ? $this->graph->getStrokeColor() : $dataPoints[$i][1]);
                    $this->graph->adapter()->setFillColor($dataPoints[$i][1]);
                } else {
                    $pt = $dataPoints[$i];
                    $this->graph->adapter()->setStrokeColor((null !== $this->graph->getStrokeColor()) ? $this->graph->getStrokeColor() : $this->graph->getFillColor());
                    $this->graph->adapter()->setFillColor($this->graph->getFillColor());
                }
                if ($this->graph->adapter() instanceof \Pop\Pdf\Pdf) {
                    $y = ($points->zeroPoint['y'] - ($realYDiv * $i)) + ($this->graph->getBarWidth() / 5);
                } else {
                    $y = ($points->yLength - ($realYDiv * ($i + 1))) + ($this->graph->getBarWidth() * 1.1);
                }
                $x = $points->zeroPoint['x'];
                $h = $this->graph->getBarWidth();
                $w = (($pt / $points->xRange) * $points->xLength);
                $this->graph->adapter()->addRectangle($x, $y, $w, $h);
            }
        } else {
            $this->graph->adapter()->setStrokeWidth($this->graph->getStrokeWidth());
            $this->graph->adapter()->setStrokeColor((null !== $this->graph->getStrokeColor()) ? $this->graph->getStrokeColor() : new Rgb(0, 0, 0));
            for ($i = 0; $i < count($dataPoints); $i++) {
                if ($this->graph->adapter() instanceof \Pop\Pdf\Pdf) {
                    $y = ($points->zeroPoint['y'] - ($realYDiv * $i)) + ($this->graph->getBarWidth() / 5);
                } else {
                    $y = ($points->yLength - ($realYDiv * ($i + 1))) + ($this->graph->getBarWidth() * 1.1);
                }
                $x = $points->zeroPoint['x'];
                $h = $this->graph->getBarWidth();
                $w = (($dataPoints[$i] / $points->xRange) * $points->xLength);
                $this->graph->adapter()->addLine($x, $y, ($x + $w), $y);
                $this->graph->adapter()->addLine(($x + $w), $y, ($x + $w), ($y + $h));
                $this->graph->adapter()->addLine(($x + $w), ($y + $h), $x, ($y + $h));
            }
        }

        // Draw data point text.
        if ($this->graph->getShowText()) {
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
        $this->drawYAxis($yAxis, $points, $this->graph->getBarWidth());

        return $this;
    }

}
