<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StoreManagerController extends Controller
{
    /**
     * Displays a simple store manager dashboard.
     *
     * @Route("/manager", name="store_manager")
     */
    public function indexAction()
    {
        return $this->render('AppBundle:default:manager.html.twig');
    }
}