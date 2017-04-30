<?php

namespace SMS\PaymentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SMSPaymentBundle:Default:index.html.twig');
    }
}
