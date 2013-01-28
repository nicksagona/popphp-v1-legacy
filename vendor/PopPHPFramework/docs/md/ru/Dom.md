Pop PHP Framework
=================

Documentation : Dom
-------------------

Home

ÐšÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚ Dom Ð¿Ñ€ÐµÐ´Ð¾Ñ?Ñ‚Ð°Ð²Ð»Ñ?ÐµÑ‚ Ð¿Ñ€Ð¾Ñ?Ñ‚Ð¾Ð¹
Ñ?Ð¿Ð¾Ñ?Ð¾Ð± Ð´Ð»Ñ? Ñ?Ð¾Ð·Ð´Ð°Ð½Ð¸Ñ? Ð¸ Ð¼Ð°Ð½Ð¸Ð¿ÑƒÐ»Ð¸Ñ€Ð¾Ð²Ð°Ð½Ð¸Ñ?
DOM Ð´Ð¾ÐºÑƒÐ¼ÐµÐ½Ñ‚Ð¾Ð² Ð¸ Ð¸Ñ… Ð´ÐµÑ‚ÐµÐ¹.

    use Pop\Dom\Child,
        Pop\Dom\Dom;

    $title = new Child('title', 'This is the title');

    $meta = new Child('meta');
    $meta->setAttributes(array('http-equiv' => 'Content-Type', 'content' => 'text/html; charset=utf-8'));

    $head = new Child('head');
    $head->addChildren(array($title, $meta));

    $h1 = new Child('h1', 'This is a header');
    $p = new Child('p', 'This is a paragraph.');

    $div = new Child('div');
    $div->setAttributes('id', 'contentDiv');
    $div->addChildren(array($h1, $p));

    $body = new Child('body');
    $body->addChild($div);

    $html = new Child('html');
    $html->setAttributes(array('xmlns' => 'http://www.w3.org/1999/xhtml', 'xml:lang' => 'en'));
    $html->addChildren(array($head, $body));

    $doc = new Dom(Dom::XHTML11, 'utf-8', $html);
    $doc->render();

Ð’Ñ‹ Ñ‚Ð°ÐºÐ¶Ðµ Ð¼Ð¾Ð¶ÐµÑ‚Ðµ Ð´Ð¾Ð±Ð°Ð²Ð¸Ñ‚ÑŒ Ð´ÐµÑ‚ÐµÐ¹ Ñ?
Ð¿Ð¾Ð¼Ð¾Ñ‰ÑŒÑŽ Ñ?Ñ‚Ñ€ÑƒÐºÑ‚ÑƒÑ€Ð¸Ñ€Ð¾Ð²Ð°Ð½Ð½Ð¾Ð³Ð¾ Ð¼Ð°Ñ?Ñ?Ð¸Ð²Ð°
Ð·Ð½Ð°Ñ‡ÐµÐ½Ð¸Ð¹.

    use Pop\Dom\Dom;

    $children = array(
        array(
            'nodeName'      => 'h1',
            'nodeValue'     => 'This is a header',
            'attributes'    => array('class' => 'headerClass', 'style' => 'font-size: 3.0em;'),
            'childrenFirst' => false,
            'childNodes'    => null
        ),
        array(
            'nodeName'      => 'div',
            'nodeValue'     => 'This is a div element',
            'attributes'    => array('id' => 'contentDiv'),
            'childrenFirst' => false,
            'childNodes'    => array(
                array(
                     'nodeName'      => 'p',
                     'nodeValue'     => 'This is a paragraph1',
                     'attributes'    => array('style' => 'font-size: 0.9em;'),
                     'childrenFirst' => false,
                     'childNodes'    => array(
                         array(
                             'nodeName'   => 'strong',
                             'nodeValue'  => 'This is bold!',
                             'attributes' => array('style' => 'font-size: 1.2em;')
                         )
                     )
                ),
                array(
                    'nodeName'   => 'p',
                    'nodeValue'  => 'This is another paragraph!',
                    'attributes' => array('style' => 'font-size: 0.9em;')
                )
            ),
        )
    );

    $doc = new Dom(Dom::XHTML11);
    $doc->addChildren($children);
    $doc->render();

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
