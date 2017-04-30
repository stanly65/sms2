<?php

namespace SMS\SalesBundle\Service;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class CheckoutMenu
{
    /**
     * The instance of EntityManager.
     *
     * @var EntityManager
     */
    private $em;
    
    /**
     * The security token.
     *
     * @var TokenStorage
     */
    private $token;

    /**
     * The instance of Router.
     *
     * @var Router
     */
    private $router;

    /**
     * Initializes properties.
     * 
     * @param EntityManager $entityManager
     * @param TokenStorage $tokenStorage
     * @param Router $router
     */
    public function __construct(EntityManager $entityManager, TokenStorage $tokenStorage, Router $router)
    {
        $this->em = $entityManager;
        $this->token = $tokenStorage->getToken();
        $this->router = $router;
    }

    /**
     * Provides links to the cart and the first step of the checkout process.
     *
     * @return array
     */
    public function getItems()
    {
        if ($this->token && $this->token->getUser() instanceof User) {
            $user = $this->token->getUser();
            $cart = $this->em->getRepository('SMSSalesBundle:Cart')->findOneBy(['user' => $user]);
            if ($cart) {

                return [
                    [
                        'path' => $this->router->generate('sms_sales_cart'),
                        'label' => sprintf('Cart (%s)', count($cart->getItems()))
                    ],
                    [
                        'path' => $this->router->generate('sms_sales_checkout'),
                        'label' => 'Checkout'
                    ],
                ];
            }
        }

        return [];
    }
}
