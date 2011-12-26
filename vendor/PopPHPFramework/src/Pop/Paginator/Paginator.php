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
 * @package    Pop_Paginator
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Paginator;

use Pop\Filter\String;

/**
 * @category   Pop
 * @package    Pop_Paginator
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Paginator
{

    /**
     * Constant for using the single arrows bookends
     * @var int
     */
    const SINGLE_ARROWS = 0;

    /**
     * Constant for using the double arrows bookends
     * @var int
     */
    const DOUBLE_ARROWS = 1;

    /**
     * Constant for using the prev|next bookends
     * @var int
     */
    const PREV_NEXT = 2;

    /**
     * Constant for using the ellipsis bookends
     * @var int
     */
    const ELLIPSIS = 3;

    /**
     * Header template
     * @var string
     */
    protected $_header = null;

    /**
     * Row template
     * @var string
     */
    protected $_rowTemplate = null;

    /**
     * Footer template
     * @var string
     */
    protected $_footer = null;

    /**
     * Page links property
     * @var array
     */
    protected $_links = array();

    /**
     * Content items
     * @var array
     */
    protected $_items = array();

    /**
     * Items per page property
     * @var int
     */
    protected $_perPage = 10;

    /**
     * Page range property
     * @var int
     */
    protected $_range = 10;

    /**
     * Total item count property
     * @var int
     */
    protected $_total = null;

    /**
     * Page bookends
     * @var array
     */
    protected $_bookends = array(
        array('prev' => '&lt;', 'next' => '&gt;'),
        array('prev' => '&lt;&lt;', 'next' => '&gt;&gt;'),
        array('prev' => 'Prev', 'next' => 'Next'),
        array('prev' => '...', 'next' => '...')
    );

    /**
     * Page bookend key
     * @var int
     */
    protected $_bookendKey = 0;

    /**
     * Bookend separator
     * @var string
     */
    protected $_separator = ' | ';

    /**
     * Date format for handle date strings
     * @var string
     */
    protected $_dateFormat = 'D, M j Y';

    /**
     * Class 'on' name for page link <a> tags
     * @var string
     */
    protected $_classOn = null;

    /**
     * Class 'off' name for page link <a> tags
     * @var string
     */
    protected $_classOff = null;

    /**
     * Number of pages property
     * @var int
     */
    protected $_numPages = null;

    /**
     * Current page start index property
     * @var int
     */
    protected $_start = null;

    /**
     * Current page end index property
     * @var int
     */
    protected $_end = null;

    /**
     * Remainder property
     * @var int
     */
    protected $_rem = 0;

    /**
     * Page ouput
     * @var string
     */
    protected $_output = null;

    /**
     * Constructor
     *
     * Instantiate the paginator object.
     *
     * @param  array $content
     * @param  int $perPage
     * @param  int $range
     * @param  int $total
     * @return void
     */
    public function __construct(array $items, $perPage = 10, $range = 10, $total = null)
    {
        $this->_items = $items;
        $this->_perPage = (int)$perPage;
        $this->_range = ($range > 0) ? (int)$range : 10;
        $this->_total = (null !== $total) ? (int)$total : null;
    }

    /**
     * Method to set the content items.
     *
     * @param  array $items
     * @return Pop\Paginator\Paginator
     */
    public function setItems($items)
    {
        $this->_items = $items;
        return $this;
    }

    /**
     * Method to set the page range.
     *
     * @param  int $range
     * @return Pop\Paginator\Paginator
     */
    public function setPerPage($perPage = 10)
    {
        $this->_perPage = (int)$perPage;
        return $this;
    }

    /**
     * Method to set the page range.
     *
     * @param  int $range
     * @return Pop\Paginator\Paginator
     */
    public function setRange($range = 10)
    {
        $this->_range = ($range > 0) ? (int)$range : 10;
        return $this;
    }

    /**
     * Method to set the content items total
     *
     * @param  int $total
     * @return Pop\Paginator\Paginator
     */
    public function setTotal($total = null)
    {
        $this->_total = (null !== $total) ? (int)$total : null;
        return $this;
    }

    /**
     * Method to set the bookend key.
     *
     * @param  int $key
     * @return Pop\Paginator\Paginator
     */
    public function setBookend($key = Paginator::SINGLE_ARROWS)
    {
        $this->_bookendKey = (int)$key;
        return $this;
    }

    /**
     * Method to set the bookend separator.
     *
     * @param  string $sep
     * @return Pop\Paginator\Paginator
     */
    public function setSeparator($sep = ' | ')
    {
        $this->_separator = $sep;
        return $this;
    }

    /**
     * Method to set the date format.
     *
     * @param  string $date
     * @return Pop\Paginator\Paginator
     */
    public function setDateformat($date = 'D, M j Y')
    {
        $this->_dateFormat = $date;
        return $this;
    }

    /**
     * Method to set the class 'on' name.
     *
     * @param  string $cls
     * @return Pop\Paginator\Paginator
     */
    public function setClassOn($cls)
    {
        $this->_classOn = $cls;
        return $this;
    }

    /**
     * Method to set the class 'off' name.
     *
     * @param  string $cls
     * @return Pop\Paginator\Paginator
     */
    public function setClassOff($cls)
    {
        $this->_classOff = $cls;
        return $this;
    }

    /**
     * Method to set the header template.
     *
     * @param  string $hdr
     * @return Pop\Paginator\Paginator
     */
    public function setHeader($hdr)
    {
        $this->_header = $hdr;
        return $this;
    }

    /**
     * Method to set the row template.
     *
     * @param  string $tmpl
     * @return Pop\Paginator\Paginator
     */
    public function setRowTemplate($tmpl)
    {
        $this->_rowTemplate = $tmpl;
        return $this;
    }

    /**
     * Method to set the footer template.
     *
     * @param  string $ftr
     * @return Pop\Paginator\Paginator
     */
    public function setFooter($ftr)
    {
        $this->_footer = $ftr;
        return $this;
    }

    /**
     * Method to get the content items.
     *
     * @return array
     */
    public function getItems()
    {
        return $this->_items;
    }

    /**
     * Method to get the number of content items.
     *
     * @return int
     */
    public function getItemCount()
    {
        return count($this->_items);
    }

    /**
     * Method to get the page range.
     *
     * @return int
     */
    public function getPerPage()
    {
        return $this->_perPage;
    }

    /**
     * Method to get the page range.
     *
     * @return int
     */
    public function getRange()
    {
        return $this->_range;
    }

    /**
     * Method to get the content items total
     *
     * @return int
     */
    public function getTotal()
    {
        return $this->_total;
    }

    /**
     * Method to get the bookend separator.
     *
     * @return string
     */
    public function getSeparator()
    {
        return $this->_separator;
    }

    /**
     * Method to get the date format.
     *
     * @return string
     */
    public function getDateFormat()
    {
        return $this->_dateFormat;
    }

    /**
     * Method to get the class 'on' name.
     *
     * @return string
     */
    public function getClassOn()
    {
        return $this->_classOn;
    }

    /**
     * Method to get the class 'off' name.
     *
     * @return string
     */
    public function getClassOff()
    {
        return $this->_classOff;
    }

    /**
     * Method to get the header template.
     *
     * @return string
     */
    public function getHeader()
    {
        return $this->_header;
    }

    /**
     * Method to get the row template.
     *
     * @return string
     */
    public function getRowTemplate()
    {
        return $this->_rowTemplate;
    }

    /**
     * Method to get the footer template.
     *
     * @return string
     */
    public function getFooter()
    {
        return $this->_footer;
    }

    /**
     * Method to render the current page.
     *
     * @param  int|string $pg
     * @param  boolean $ret
     * @return mixed
     */
    public function render($pg, $ret = false)
    {
        // Initialize the output.
        $this->_output = null;

        // Calculate the necessary properties.
        $this->_calcItems($pg);

        // Generate the page links.
        $this->_links = array();

        // Preserve any passed GET parameters.
        $query = null;

        if (count($_GET) > 0) {
            foreach ($_GET as $key => $value) {
                if ($key != 'page') {
                    $query .= '&' . $key . '=' . $value;
                }
            }
        }

        // Calculate page range links.
        $pageRange = $this->_calcRange($pg);

        for ($i = $pageRange['start']; $i <= $pageRange['end']; $i++) {
            $newLink = null;
            $prevLink = null;
            $nextLink = null;
            $classOff = (null !== $this->_classOff) ? " class=\"{$this->_classOff}\"" : null;
            $classOn = (null !== $this->_classOn) ? " class=\"{$this->_classOn}\"" : null;

            $newLink = ($i == $pg) ? "<span{$classOff}>{$i}</span>" : "<a{$classOn} href=\"" . $_SERVER['PHP_SELF'] . "?page={$i}{$query}\">{$i}</a>";

            if (($i == $pageRange['start']) && ($pageRange['prev'])) {
                $prevLink = "<a{$classOn} href=\"" . $_SERVER['PHP_SELF'] . "?page=" . ($i - 1) . "{$query}\">" . $this->_bookends[$this->_bookendKey]['prev'] . "</a>";
                $this->_links[] = $prevLink;
            }
            $this->_links[] = $newLink;
            if (($i == $pageRange['end']) && ($pageRange['next'])) {
                $nextLink = "<a{$classOn} href=\"" . $_SERVER['PHP_SELF'] . "?page=" . ($i + 1) . "{$query}\">" . $this->_bookends[$this->_bookendKey]['next'] . "</a>";
                $this->_links[] = $nextLink;
            }
        }

        // Format and output the header.
        if (null === $this->_header) {
            if (count($this->_links) > 1) {
                $this->_output .= implode($this->_separator, $this->_links) . PHP_EOL;
            }
            $this->_output .= '<table class="paged-table" cellpadding="0" cellspacing="0">' . PHP_EOL;
        } else {
            $hdr = new String($this->_header);
            if (count($this->_links) > 1) {
                $hdr->replace('[{page_links}]', implode($this->_separator, $this->_links));
            } else {
                $hdr->replace('[{page_links}]', '');
            }
            $this->_output .= $hdr;
        }

        // Format and output the rows.
        for ($i = $this->_start; $i < $this->_end; $i++) {
            if (null === $this->_rowTemplate) {
                $this->_output .= "    <tr>";
                if (isset($this->_items[$i])) {
                    foreach ($this->_items[$i] as $value) {
                        if (null !== $this->_dateFormat) {
                            $val = (strtotime($value) !== false) ? date($this->_dateFormat, strtotime($value)) : $value;
                        } else {
                            $val = $value;
                        }
                        $this->_output .= "<td>{$val}</td>";
                    }
                    $this->_output .= "</tr>" . PHP_EOL;
                }
            } else {
                $tmpl = new String($this->_rowTemplate);
                if (isset($this->_items[$i])) {
                    foreach ($this->_items[$i] as $key => $value) {
                        if (null !== $this->_dateFormat) {
                            $val = ((strtotime($value) !== false) || (stripos($key, 'date') !== false)) ? date($this->_dateFormat, strtotime($value)) : $value;
                        } else {
                            $val = $value;
                        }
                        $tmpl->replace('[{' . $key . '}]', $val);
                    }
                    $this->_output .= $tmpl;
                }
            }
        }

        // Format and output the footer.
        if (null === $this->_footer) {
            $this->_output .= "</table>" . PHP_EOL;
            if (count($this->_links) > 1) {
                $this->_output .= implode($this->_separator, $this->_links) . PHP_EOL;
            }
        } else {
            $ftr = new String($this->_footer);
            if (count($this->_links) > 1) {
                $ftr->replace('[{page_links}]', implode($this->_separator, $this->_links));
            } else {
                $ftr->replace('[{page_links}]', '');
            }
            $this->_output .= $ftr;
        }

        if ($ret) {
            return $this->_output;
        } else {
            echo $this->_output;
        }
    }

    /**
     * Method to calculate the page items.
     *
     * @param  int|string $p
     * @return void
     */
    protected function _calcItems($p)
    {
        // Calculate the number of pages based on the remainder.
        if ((null !== $this->_total) && ((int)$this->_total > 0)) {
            $this->_rem = $this->_total % $this->_perPage;
            $this->_numPages = ($this->_rem != 0) ? (floor(($this->_total / $this->_perPage)) + 1) : floor(($this->_total / $this->_perPage));
        } else {
            $this->_rem = (count($this->_items)) % $this->_perPage;
            $this->_numPages = ($this->_rem != 0) ? (floor((count($this->_items) / $this->_perPage)) + 1) : floor((count($this->_items) / $this->_perPage));
        }

        // Calculate the start index.
        $this->_start = ($p * $this->_perPage) - $this->_perPage;

        // Calculate the end index.
        if (($p == $this->_numPages) && ($this->_rem == 0)) {
            $this->_end = $this->_start + $this->_perPage;
        } else if ($p == $this->_numPages) {
            $this->_end = (($p * $this->_perPage) - ($this->_perPage - $this->_rem));
        } else {
            $this->_end = ($p * $this->_perPage);
        }

        // Calculate if out of range.
        if ($this->_start >= count($this->_items)) {
            $this->_start = 0;
            $this->_end = $this->_perPage;
        }
    }

    /**
     * Method to calculate the page range.
     *
     * @param  int|string $pg
     * @return array
     */
    protected function _calcRange($pg)
    {
        $range = array();

        // Check and calculate for any page ranges.
        if (((null === $this->_range) || ($this->_range > $this->_numPages)) && (null === $this->_total)) {
            $range = array(
                'start' => 1,
                'end'   => $this->_numPages,
                'prev'  => false,
                'next'  => false
            );
        } else {
            // If page is within the first range block.
            if (($pg <= $this->_range) && ($this->_numPages <= $this->_range)) {
                $range = array(
                    'start' => 1,
                    'end'   => $this->_numPages,
                    'prev'  => false,
                    'next'  => false
                );
            // If page is within the first range block, with a next range.
            } else if (($pg <= $this->_range) && ($this->_numPages > $this->_range)) {
                $range = array(
                    'start' => 1,
                    'end'   => $this->_range,
                    'prev'  => false,
                    'next'  => true
                );
            // Else, if page is within the last range block, with an uneven remainder.
            } else if ($pg > ($this->_range * floor($this->_numPages / $this->_range))) {
                $range = array(
                    'start' => ($this->_range * floor($this->_numPages / $this->_range)) + 1,
                    'end'   => $this->_numPages,
                    'prev'  => true,
                    'next'  => false
                );
            // Else, if page is within the last range block, with no remainder.
            } else if ((($this->_numPages % $this->_range) == 0) && ($pg > ($this->_range * (($this->_numPages / $this->_range) - 1)))) {
                $range = array(
                    'start' => ($this->_range * (($this->_numPages / $this->_range) - 1)) + 1,
                    'end'   => $this->_numPages,
                    'prev'  => true,
                    'next'  => false
                );
            // Else, if page is within a middle range block.
            } else {
                $posInRange = (($pg % $this->_range) == 0) ? ($this->_range - 1) : (($pg % $this->_range) - 1);
                $linkStart = $pg - $posInRange;
                $range = array(
                    'start' => $linkStart,
                    'end'   => $linkStart + ($this->_range - 1),
                    'prev'  => true,
                    'next'  => true
                );
            }
        }

        return $range;
    }

    /**
     * Output the rendered page
     *
     * @return string
     */

    public function __toString()
    {
        if (isset($_GET['page']) && ((int)$_GET['page'] > 0)) {
            $pg = (int)$_GET['page'];
        } else {
            $pg = 1;
        }
        return $this->render($pg, true);
    }

}
