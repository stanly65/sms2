<?php

namespace SMS\ShipmentBundle\Service;

use Symfony\Bundle\FrameworkBundle\Routing\Router;

class FlatRateShipment
{
    /**
     * The instance of Router.
     *
     * @var Router
     */
    private $router;

    /**
     * Initializes the instance of Router.
     *
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Constructs the shipment step of the checkout process.
     *
     * @return array
     */
    public function getInfo()
    {
        return [
            'shipment' => [
                'title' => 'Flat Rate Shipment',
                'code' => 'flat_rate',
                'delivery_options' => [
        'title' => 'Fixed delivery',
        'code' => 'fixed',
        'price' => 9.99
                ],
                'url_process' => $this->router->generate('sms_shipment_flat_rate_process'),
            ]
        ];
    }
}
