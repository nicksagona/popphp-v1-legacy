Pop PHP Framework
=================

Documentation : Image
---------------------

Home

ÙŠÙˆÙ?Ø± Ø¹Ù†ØµØ± ØµÙˆØ±Ø© Ù…Ø¬Ù…Ø¹ API Ù…ÙˆØ­Ø¯Ø© Ù„Ø¥Ù†Ø´Ø§Ø¡
ÙˆØ§Ù„ØªÙ„Ø§Ø¹Ø¨ Ù?ÙŠ Ø§Ù„ØµÙˆØ± Ø§Ù„ØªÙŠ ØªØ¹Ø²Ø² GD PHP ÙˆÙ…Ù„Ø­Ù‚Ø§Øª
ImagickØŒ Ù?Ø¶Ù„Ø§ Ø¹Ù† Ø´ÙƒÙ„ ØµÙˆØ±Ø© SVG. Ø¶Ù…Ù† Ù‡Ø°Ø§ Ø§Ù„Ù…ÙƒÙˆÙ†
Ù‡Ùˆ API Ù…ÙŠØ²Ø© Ø§Ù„ØºÙ†ÙŠØ© Ù„Ø£Ø¯Ø§Ø¡ Ø§Ù„Ø¹Ø¯ÙŠØ¯ Ù…Ù† Ù…Ø®ØªÙ„Ù?
Ø§Ù„ÙˆØ¸Ø§Ø¦Ù? Ø§Ù„ØªÙŠ ØªØ¹ØªÙ…Ø¯ Ø¹Ù„Ù‰ Ø§Ù„ØµÙˆØ±. ÙˆÙ…Ù†Ø° API Ù‡Ùˆ
Ù…ÙˆØ­Ø¯ØŒ Ø¥Ø°Ø§ ÙƒØ§Ù† Ø§Ù„Ù…Ø´Ø±ÙˆØ¹ ÙŠÙ†ØªÙ‚Ù„ Ø¥Ù„Ù‰ Ø¨ÙŠØ¦Ø©
Ù…Ø®ØªÙ„Ù?Ø©ØŒ ÙŠØ¬Ø¨ Ø£Ù† ØªØªØ­Ù„Ù„ Ø¨Ø³Ù‡ÙˆÙ„Ø©

    use Pop\Color\Space\Rgb,
        Pop\Image\Gd;

    $image = new Gd('new-image.jpg', 640, 480, new Rgb(255, 0, 0));
    $image->setFillColor(new Rgb(0, 0, 255))
          ->setStrokeColor(new Rgb(255, 255, 255))
          ->setStrokeWidth(3)
          ->drawEllipse(320, 240, 150, 75)
          ->output();

    $image->destroy();

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
