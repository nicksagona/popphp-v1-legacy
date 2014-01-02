Pop PHP Framework
=================

Documentation : Graph
---------------------

Home

Το στοιχείο Γράφημα επιτρέπει ισχυρή λειτουργικότητα με γραφική
παράσταση που μπορεί να χρησιμοποιήσει οποιοδήποτε από τα built-in
γραφικά στοιχεία, όπως εικόνας, SVG και PDF σε σχεδιάζει γραφικές
παραστάσεις σε διάφορες μορφές. Μπορείτε να ορίσετε ένα ευρύ φάσμα των
γραφικών χαρακτηριστικά για να δημιουργήσετε και να καταστήσει γραφήματα
γραμμής, γραφήματα μπαρ και διαγράμματα πίτας. Δεδομένου ότι η API
μεταξύ των διαφόρων γραφικών στοιχείων είναι τυποποιημένη, είναι πολύ
εύκολο για την ανταλλαγή μεταξύ διαφορετικών το αρχείο και μορφές
εικόνας για να παράγουν ένα γράφημα.

    use Pop\Color\Space\Rgb,
        Pop\Graph\Graph;

    $x = array('1995', '2000', '2005', '2010', '2015');
    $y = array('0M', '50M', '100M', '150M', '200M');

    $data = array(
        array(1995, 0),
        array(1997, 35),
        array(1998, 25),
        array(2002, 100),
        array(2004, 84),
        array(2006, 98),
        array(2007, 76),
        array(2010, 122),
        array(2012, 175),
        array(2015, 162)
    );


    $graph = new Graph(array(
        'filename' => 'graph.gif',
        'width'    => 640,
        'height'   => 480
    ));

    $graph->addFont('../assets/fonts/times.ttf')
          ->setFontColor(new Rgb(128, 128, 128))
          ->setFillColor(new Rgb(10, 125, 210))
          ->showY(true)
          ->showText(true)
          ->createLineGraph($data, $x, $y)
          ->output();

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
