<?php

namespace SMS\SalesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SMSSalesBundle:Default:index.html.twig');
    }
}
