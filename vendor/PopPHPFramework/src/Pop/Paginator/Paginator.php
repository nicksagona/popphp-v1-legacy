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

use Pop\Filter\StringFilter;

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
     * Header template
     * @var string
     */
    protected $_header = null;

    /**
     * Row template
     * @var string
     */
    protected $_rowtmpl = null;

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
    protected $_content = array();

    /**
     * Items per page property
     * @var int
     */
    protected $_perpage = null;

    /**
     * Page range property
     * @var int
     */
    protected $_range = null;

    /**
     * Total item count property
     * @var int
     */
    protected $_total = null;

    /**
     * Page range key property
     * @var string
     */
    protected $_rangeKey = null;

    /**
     * Page range property
     * @var array
     */
    protected $_rangeItems = array('Arrow'  => array('prev'=> '&lt;', 'next' => '&gt;'),
                                   'Arrows' => array('prev'=> '&lt;&lt;', 'next' => '&gt;&gt;'),
                                   'Words'  => array('prev'=> 'Prev', 'next' => 'Next'),
                                   'Dots'   => array('prev'=> '...', 'next' => '...'));

    /**
     * Number of pages property
     * @var int
     */
    protected $_numpages = null;

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
     * Constructor
     *
     * Instantiate the paginator object.
     *
     * @param  array $content
     * @param  int $perpage
     * @param  int $range
     * @param  int $total
     * @param  string $key
     * @return void
     */
    public function __construct($content, $perpage = 10, $range = null, $total = null, $key = 'Arrows')
    {
        $this->_content = $content;
        $this->_perpage = $perpage;
        $this->_range = $range;
        $this->_total = $total;
        $this->_rangeKey = $key;
    }

    /**
     * Method to set the content property.
     *
     * @param  array $content
     * @return Pop_Paginator
     */
    public function setContent($content)
    {
        $this->_content = $content;
        return $this;
    }

    /**
     * Method to set the content property.
     *
     * @return array
     */
    public function getContent()
    {
        return $this->_content;
    }

    /**
     * Method to set the header template property.
     *
     * @param  string $hdr
     * @return Pop_Paginator
     */
    public function setHeader($hdr)
    {
        $this->_header = $hdr;
        return $this;
    }

    /**
     * Method to set the row template property.
     *
     * @param  string $tmpl
     * @return Pop_Paginator
     */
    public function setRowTemplate($tmpl)
    {
        $this->_rowtmpl = $tmpl;
        return $this;
    }

    /**
     * Method to set the footer template property.
     *
     * @param  string $ftr
     * @return Pop_Paginator
     */
    public function setFooter($ftr)
    {
        $this->_footer = $ftr;
        return $this;
    }

    /**
     * Method to render the current page.
     *
     * @param  int|string $pg
     * @param  string $sep
     * @param  string $clsLnk
     * @param  string $clsOff
     * @param  string $dt
     * @param  boolean $ret
     * @return mixed
     */
    public function render($pg, $sep = ' | ', $clsLnk = null, $clsOff = null, $dt = null, $ret = false)
    {
        // Initialize the output.
        $output = '';

        // Calculate the necessary properties.
        $this->_calcItems($pg);

        // Generate the page links.
        $this->_links = array();

        $query = '';

        // Preserve any passed GET parameters.
        if (count($_GET) > 0) {
            foreach ($_GET as $key => $value) {
                if ($key != 'page') {
                    $query .= '&' . $key . '=' . $value;
                }
            }
        }

        // Check and calculate for any page ranges.
        if (((null === $this->_range) || ($this->_range > $this->_numpages)) && (null === $this->_total)) {
            $link_start = 1;
            $link_end = $this->_numpages;
            $prev = false;
            $next = false;
        } else {
            // If page is within the first range block.
            if (($pg <= $this->_range) && ($this->_numpages <= $this->_range)) {
                $link_start = 1;
                $link_end = $this->_numpages;
                $prev = false;
                $next = false;
            // If page is within the first range block, with a next range.
            } else if (($pg <= $this->_range) && ($this->_numpages > $this->_range)) {
                $link_start = 1;
                $link_end = $this->_range;
                $prev = false;
                $next = true;
            // Else, if page is within the last range block, with an uneven remainder.
            } else if ($pg > ($this->_range * floor($this->_numpages / $this->_range))) {
                $link_start = ($this->_range * floor($this->_numpages / $this->_range)) + 1;
                $link_end = $this->_numpages;
                $prev = true;
                $next = false;
            // Else, if page is within the last range block, with no remainder.
            } else if ((($this->_numpages % $this->_range) == 0) && ($pg > ($this->_range * (($this->_numpages / $this->_range) - 1)))) {
                $link_start = ($this->_range * (($this->_numpages / $this->_range) - 1)) + 1;
                $link_end = $this->_numpages;
                $prev = true;
                $next = false;
            // Else, if page is within a middle range block.
            } else {
                $pos_in_range = (($pg % $this->_range) == 0) ? ($this->_range - 1) : (($pg % $this->_range) - 1);
                $link_start = $pg - $pos_in_range;
                $link_end = $link_start + ($this->_range - 1);
                $prev = true;
                $next = true;
            }
        }

        // Calculate page links.
        for ($i = $link_start; $i <= $link_end; $i++) {
            $new_link = '';
            $prev_link = '';
            $next_link = '';
            $classOff = (null !== $clsOff) ? " class=\"{$clsOff}\"" : '';
            $classLink = (null !== $clsLnk) ? " class=\"{$clsLnk}\"" : '';

            $new_link = ($i == $pg) ? "<span{$classOff}>{$i}</span>" : "<a{$classLink} href=\"" . $_SERVER['PHP_SELF'] . "?page={$i}{$query}\">{$i}</a>";

            if (($i == $link_start) && ($prev)) {
                $prev_link = "<a{$classLink} href=\"" . $_SERVER['PHP_SELF'] . "?page=" . ($i - 1) . "{$query}\">" . $this->_rangeItems[$this->_rangeKey]['prev'] . "</a>";
                $this->_links[] = $prev_link;
            }
            $this->_links[] = $new_link;
            if (($i == $link_end) && ($next)) {
                $next_link = "<a{$classLink} href=\"" . $_SERVER['PHP_SELF'] . "?page=" . ($i + 1) . "{$query}\">" . $this->_rangeItems[$this->_rangeKey]['next'] . "</a>";
                $this->_links[] = $next_link;
            }
        }

        // Format and output the header.
        if (null === $this->_header) {
            if (count($this->_links) > 1) {
                $output .= implode($sep, $this->_links) . "\n";
            }
            $output .= "<table>\n";
        } else {
            $hdr = new StringFilter($this->_header);
            if (count($this->_links) > 1) {
                $hdr->replace('[{page_links}]', implode($sep, $this->_links));
            } else {
                $hdr->replace('[{page_links}]', '');
            }
            $output .= $hdr;
        }

        // Format and output the rows.
        for ($i = $this->_start; $i < $this->_end; $i++) {
            if (null === $this->_rowtmpl) {
                $output .= "<tr>";
                if (isset($this->_content[$i])) {
                    foreach ($this->_content[$i] as $value) {
                        if (null !== $dt) {
                            $val = (strtotime($value) !== false) ? date($dt, strtotime($value)) : $value;
                        } else {
                            $val = $value;
                        }
                        $output .= "<td>{$val}</td>";
                    }
                    $output .= "</tr>\n";
                }
            } else {
                $tmpl = new StringFilter($this->_rowtmpl);
                if (isset($this->_content[$i])) {
                    foreach ($this->_content[$i] as $key => $value) {
                        if (null !== $dt) {
                            $val = ((strtotime($value) !== false) || (stripos($key, 'date') !== false)) ? date($dt, strtotime($value)) : $value;
                        } else {
                            $val = $value;
                        }
                        $tmpl->replace('[{' . $key . '}]', $val);
                    }
                    $output .= $tmpl;
                }
            }
        }

        // Format and output the footer.
        if (null === $this->_footer) {
            $output .= "</table>\n";
            if (count($this->_links) > 1) {
                $output .= implode($sep, $this->_links) . "\n";
            }
        } else {
            $ftr = new StringFilter($this->_footer);
            if (count($this->_links) > 1) {
                $ftr->replace('[{page_links}]', implode($sep, $this->_links));
            } else {
                $ftr->replace('[{page_links}]', '');
            }
            $output .= $ftr;
        }

        if ($ret) {
            return $output;
        } else {
            echo $output;
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
        if (null !== $this->_total) {
            $this->_rem = $this->_total % $this->_perpage;
            $this->_numpages = ($this->_rem != 0) ? (floor(($this->_total / $this->_perpage)) + 1) : floor(($this->_total / $this->_perpage));
        } else {
            $this->_rem = (count($this->_content)) % $this->_perpage;
            $this->_numpages = ($this->_rem != 0) ? (floor((count($this->_content) / $this->_perpage)) + 1) : floor((count($this->_content) / $this->_perpage));
        }

        // Calculate the start index.
        $this->_start = ($p * $this->_perpage) - $this->_perpage;

        // Calculate the end index.
        if (($p == $this->_numpages) && ($this->_rem == 0)) {
            $this->_end = $this->_start + $this->_perpage;
        } else if ($p == $this->_numpages) {
            $this->_end = (($p * $this->_perpage) - ($this->_perpage - $this->_rem));
        } else {
            $this->_end = ($p * $this->_perpage);
        }

        // Calculate if out of range.
        if ($this->_start >= count($this->_content)) {
            $this->_start = 0;
            $this->_end = $this->_perpage;
        }
    }

}
