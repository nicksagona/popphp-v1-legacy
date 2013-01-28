Pop PHP Framework
=================

Documentation : Validator
-------------------------

Home

Ø§Ù„Ù…ÙƒÙˆÙ† Ù…Ø¯Ù‚Ù‚ ÙŠÙˆÙ?Ø± ÙˆØ¸Ø§Ø¦Ù? Ø§Ù„ØªØ­Ù‚Ù‚ Ù…Ù† ØµØ­Ø©
Ø¨Ø¨Ø³Ø§Ø·Ø© Ù„ÙƒØ«ÙŠØ± Ù…Ù† Ø­Ø§Ù„Ø§Øª Ø§Ù„Ø§Ø³ØªØ®Ø¯Ø§Ù…
Ø§Ù„Ù…Ø®ØªÙ„Ù?Ø©ØŒ Ù…Ø«Ù„ Ø§Ù„ØªØ­Ù‚Ù‚ Ù…Ù† ØµØ­Ø© Ù…Ø§ Ø¥Ø°Ø§ ÙƒØ§Ù†
Ø§Ù„Ø±Ù‚Ù… Ù…Ù† Ù‚ÙŠÙ…Ø© Ù…Ø¹ÙŠÙ†Ø© Ø£Ùˆ Ø³Ù„Ø³Ù„Ø© Ù…Ù†
Ø§Ù„Ø£Ø¨Ø¬Ø¯ÙŠØ© Ø§Ù„Ø±Ù‚Ù…ÙŠØ©. Ù…Ø¯Ù‚Ù‚ Ø£ÙƒØ«Ø± ØªÙ‚Ø¯Ù…Ø§
ÙˆØªØªÙˆÙ?Ø± Ø£ÙŠØ¶Ø§ØŒ Ù…Ø«Ù„ Ø§Ù„ØªØ­Ù‚Ù‚ Ù…Ù† ØµØ­Ø© Ø¹Ù†ÙˆØ§Ù†
Ø§Ù„Ø¨Ø±ÙŠØ¯ Ø§Ù„Ø¥Ù„ÙƒØªØ±ÙˆÙ†ÙŠØŒ ÙˆØ¹Ù†ÙˆØ§Ù† IP Ø£Ùˆ Ø±Ù‚Ù…
Ø¨Ø·Ø§Ù‚Ø© Ø§Ù„Ø§Ø¦ØªÙ…Ø§Ù†. ÙˆØ¥Ø°Ø§ Ù…Ø§ Ø¹Ù„ÙŠÙƒ ØºÙŠØ±
Ù…ØªÙˆÙ?Ø±Ø©ØŒ ÙŠÙ…ÙƒÙ† Ù„Ù„Ù…ÙƒÙˆÙ† Ø£Ù† ØªÙ…ØªØ¯ Ø¨Ø³Ù‡ÙˆÙ„Ø©.

    use Pop\Validator\AlphaNumeric;

    // Create an alphanumeric validator
    $val = new AlphaNumeric();

    // Evaluate if the input value meets the rule or not
    if (!$val->evaluate('abcd1234')) {
        echo $val->getMessage();
    } else {
        echo 'The validator test passed. The string is alphanumeric.';
    }

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
