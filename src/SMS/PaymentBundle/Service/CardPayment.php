<?php

namespace SMS\PaymentBundle\Service;

use Symfony\Component\Form\FormFactory;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use SMS\PaymentBundle\Entity\Card;

class CardPayment
{
    /**
     * The instance of FormFactory.
     *
     * @var FormFactory
     */
    private $formFactory;

    /**
     * The instance of Router.
     *
     * @var Router
     */
    private $router;

    /**
     * Initializes properties.
     *
     * @param $formFactory
     * @param Router $router
     */
    public function __construct(FormFactory $formFactory, Router $router)
    {
        $this->formFactory = $formFactory;
        $this->router = $router;
    }

    /**
     * Constructs the payment step of the checkout process.
     * 
     * @return array
     */
    public function getInfo()
    {
        $card = new Card;
        $form = $this->formFactory->create('SMS\PaymentBundle\Form\CardType', $card);

        return [
            'payment' => [
                'title' => 'Card Payment',
                'code' => 'card',
                'url_authorize' => $this->router->generate('sms_payment_card_authorize'),
                'url_capture' => $this->router->generate('sms_payment_card_capture'),
                'url_cancel' => $this->router->generate('sms_payment_card_cancel'),
                'form' => $form->createView()
            ]
        ];
    }
}
