<?php

namespace SMS\ShipmentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SMSShipmentBundle:Default:index.html.twig');
    }
}
