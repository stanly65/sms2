<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DefaultController extends Controller
{
    /**
     * Displays "Main" page.
     *
     * @return Response
     *
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('AppBundle:default:index.html.twig');
    }

    /**
     * Displays "About Us" page.
     * 
     * @return Response
     *
     * @Route("/about", name="about")
     */
    public function aboutAction()
    {
        return $this->render('AppBundle:default:about.html.twig');
    }

    /**
     * Displays "Customer Service" page.
     *
     * @return Response
     *
     * @Route("/customer-service", name="customer_service")
     */
    public function customerServiceAction()
    {
        return $this->render('AppBundle:default:customer-service.html.twig');
    }

    /**
     * Displays "Orders and Returns" page.
     *
     * @return Response
     *
     * @Route("/orders-and-returns", name="orders_returns")
     */
    public function ordersAndReturnsAction()
    {
        return $this->render('AppBundle:default:orders-returns.html.twig');
    }

    /**
     * Displays "Privacy and Cookie Policy" page.
     *
     * @return Response
     *
     * @Route("/privacy-and-cookie-policy", name="privacy_cookie")
     */

    public function privacyAndCookiePolicyAction()
    {
        return $this->render('AppBundle:default:privacy-cookie.html.twig');
    }
}
