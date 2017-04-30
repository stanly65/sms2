<?php

namespace SMS\ShipmentBundle\Service;

use Symfony\Bundle\FrameworkBundle\Routing\Router;

class PickupRateShipment
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
                'title' => 'Pickup',
                'code' => 'pickup_rate',
                'delivery_options' => [
                    'title' => 'Free delivery',
                    'code' => 'free',
                    'price' => 0.00
                ],
                'url_process' => $this->router->generate('sms_shipment_pickup_rate_process'),
            ]
        ];
    }
}
