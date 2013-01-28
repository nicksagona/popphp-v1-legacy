Pop PHP Framework
=================

Documentation : Service
-----------------------

Home

Die Service-Komponente fungiert als Service Locator für die laufende
Anwendung oder ein Projekt. Es unterstützt lazy-loading von
Service-Instanzen, so werden die Dienste erst erstellt, wenn die
Anwendung sie benötigt werden. Es gibt viele Möglichkeiten, wie Sie die
Dienste aufrufen können, von der Definition Klassen mit Verschlüssen.

    use Pop\Service\Locator;

    // Load the services config via the constructor
    $locator = new Locator(array(
        'config' => array(
            'call'   => 'Pop\Config',
            'params' => array(array('test' => 123), true)
        ),
        'rgb' => array(
            'call'   => 'Pop\Color\Space\Rgb',
            'params' => function() { return array(255, 0, 0); }
        ),
        'color' => function($locator) {
            return new \Pop\Color\Color($locator->get('rgb'));
        }
    ));

    // Get a service
    $config = $locator->get('config');  // Returns a config object
    $rgb    = $locator->get('rgb');     // Returns an RGB colorspace object
    $color  = $locator->get('color');   // Returns a color object that is loaded with the RGB object

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
