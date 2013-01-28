Pop PHP Framework
=================

Documentation : Validator
-------------------------

Home

×ž×¨×›×™×‘ Validator ×¤×©×•×˜ ×ž×¡×¤×§ ×¤×•× ×§×¦×™×•× ×œ×™ ×?×™×ž×•×ª
×œ×ž×§×¨×™×? ×¨×‘×™×? ×©×•× ×™×?, ×›×’×•×Ÿ ×©×™×ž×•×© ×‘×?×™×ž×•×ª ×?×•
×œ×? ×”×•×? ×ž×¡×¤×¨ ×©×œ ×¢×¨×š ×ž×¡×•×™×? ×?×• ×ž×—×¨×•×–×ª ×”×™×?
×?×œ×¤×?× ×•×ž×¨×™. validators ×”×ž×ª×§×“×? ×™×•×ª×¨ ×–×ž×™×Ÿ, ×›×ž×•
×’×?, ×›×’×•×Ÿ ×?×™×ž×•×ª ×›×ª×•×‘×ª ×“×•×?"×œ, ×•×›×ª×•×‘×ª ×”-IP ×?×•
×ž×¡×¤×¨ ×›×¨×˜×™×¡ ×?×©×¨×?×™. ×•×?×? ×ž×” ×©×?×ª×” ×¦×¨×™×š ×–×” ×œ×?
×–×ž×™×Ÿ, ×©×œ ×”×¨×›×™×‘ × ×™×ª×Ÿ ×œ×”×¨×—×™×‘ ×‘×§×œ×•×ª.

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
