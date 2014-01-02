Pop PHP Framework
=================

Documentation : Shipping
------------------------

Home

送料·コンポーネントは、標準的なフェデックス、UPSとUSPSのAPIを介して2つのアドレス間の運賃を比較するために標準化された機能を提供します。別の配送アダプタが必要な場合、人は簡単に書き込まれ、統合することができる。

    use Pop\Shipping\Shipping;
    use Pop\Shipping\Adapter\Fedex;
    use Pop\Shipping\Adapter\Ups;
    use Pop\Shipping\Adapter\Usps;

    $shipping = new Shipping(new Fedex('KEY', 'PASSWORD', 'ACCT_NUM', 'METER_NUM'));
    // -- OR --
    //$shipping = new Shipping(new Ups('ACCESS_KEY', 'USER_ID', 'PASSWORD'));
    //$shipping = new Shipping(new Usps('USERNAME', 'PASSWORD'));

    $shipping->shipTo(array(
        'company'  => 'Some Company',
        'address1' => '123 Main St.',
        'address2' => 'Suite A',
        'city'     => 'Metairie',
        'state'    => 'LA',
        'zip'      => '70002',
        'country'  => 'US'
    ));

    $shipping->shipFrom(array(
        'company'  => 'My Company',
        'address1' => '456 Main St.',
        'city'     => 'New Orleans',
        'state'    => 'LA',
        'zip'      => '70124',
        'country'  => 'US'
    ));

    $shipping->setDimensions(array(
        'length' => 12,
        'height' => 3,
        'width'  => 6
    ));

    $shipping->setWeight(5);

    $shipping->send();

    if ($shipping->isSuccess()) {
        foreach ($shipping->getRates() as $rate => $cost) {
            echo $rate . ': $' . $cost;
        }
    } else {
        echo $shipping->getResponseCode() . ' : ' . $shipping->getResponseMessage();
    }

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
