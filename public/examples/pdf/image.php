<?php

require_once '../../bootstrap.php';

use Pop\Color\Rgb,
    Pop\Pdf\Pdf;

try {
    //$file = new Pop\File\File('/home/nick/Desktop/pop-gif-full.pdf');
    //echo $file->read();
    $img = new Pop\Image\Gd('../assets/images/test.gif');
    $img->convert('png')
        ->save('../tmp/test.png');
    echo 'Done';
    //$pdf = new Pdf('../tmp/doc.pdf');
    //$pdf->addPage('Letter');
    //$pdf->addImage('../assets/images/test.gif', 20, 20, 240, true);
    //$pdf->output();
} catch (\Exception $e) {
    echo $e->getMessage();
}

?>
