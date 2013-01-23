<?php

require_once '../../bootstrap.php';

use Pop\Feed;

try {
    $googleRss = 'http://news.google.com/news?pz=1&cf=all&ned=us&hl=en&topic=h&output=rss';
    $feed = new Feed\Reader(new Feed\Format\Rss($googleRss, 3));

    //$googleAtom = 'http://news.google.com/news?pz=1&cf=all&ned=us&hl=en&topic=h&output=atom';
    //$feed = new Feed\Reader(new Feed\Format\Atom($googleAtom, 3));

    //$opts = array('name' => 'highvoltagenola');
    //$opts = array('id' => '49700389248');
    //$feed = new Feed\Reader(new Feed\Format\Json\Facebook($opts, 3));

    //$opts = array('name' => 'highvoltagenola');
    //$opts = array('id' => '50079850');
    //$feed = new Feed\Reader(new Feed\Format\Json\Twitter($opts, 3));

    //$opts = array('name' => 'royraz');
    //$opts = array('id' => '2136270');
    //$feed = new Feed\Reader(new Feed\Format\Rss\Vimeo($opts, 3));

    //$opts = array('name' => 'highvoltagenola');
    //$opts = array('id' => '35318AF7BEB5DD11');
    //$feed = new Feed\Reader(new Feed\Format\Json\Youtube($opts, 3));

    //$opts = array('name' => 'highvoltagenola');
    //$opts = array('id' => '35318AF7BEB5DD11');
    //$feed = new Feed\Reader(new Feed\Format\Atom\Youtube($opts, 3));

    //print_r($feed);

    $tmpl = <<<NEWS
    <div class="news-div">
        <a href="[{link}]">[{title}]</a><br />
        <strong>[{published}]</strong> ([{time}])<br />
        <p>[{description}]</p>
    </div>

NEWS;

    //$feed = new Reader('http://news.google.com/news?pz=1&cf=all&ned=us&hl=en&topic=h&output=rss', 3);
    $feed->setTemplate($tmpl);
    $feed->render();

} catch (\Exception $e) {
    echo $e->getMessage();
}

