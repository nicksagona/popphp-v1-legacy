Pop PHP Framework
=================

Documentation : Service
-----------------------

Home

Le composant de service agit comme un service de localisation pour
l'application en cours d'exécution ou d'un projet. Il prend en charge
chargement paresseux d'instances de service, de sorte que les services
ne seront pas créés tant que l'application a besoin d'eux. Il ya
beaucoup d'options pour la façon dont vous pouvez appeler les services,
de la définition des classes d'utilisation des fermetures.

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
