<?php

namespace SMS\PaymentBundle\Service;

use Symfony\Bundle\FrameworkBundle\Routing\Router;

class EpayPayment
{
    /**
     * The instance of Router.
     *
     * @var Router
     */
    private $router;

    /**
     * Initializes Router property.
     *
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Constructs the payment step of the checkout process.
     * 
     * @return array
     */
    public function getInfo()
    {
        return [
            'payment' => [
                'title' => 'Epay Payment',
                'code' => 'epay',
                'url_authorize' => $this->router->generate('sms_payment_epay_authorize'),
                'url_capture' => $this->router->generate('sms_payment_epay_capture'),
                'url_cancel' => $this->router->generate('sms_payment_epay_cancel'),
            ]
        ];
    }
}
