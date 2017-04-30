<?php

namespace SMS\CustomerBundle\Service\Menu;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class CustomerMenu
{
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
     * Sets the current security token.
     *
     * @param TokenStorage $tokenStorage
     * @param Router $router
     */
    public function __construct(TokenStorage $tokenStorage, Router $router)
    {
        $this->token = $tokenStorage->getToken();
        $this->router = $router;
    }

    /**
     * Gets the menu with actual customer data, depending on customer login status.
     *
     * @return array
     */
    public function getItems()
    {
        $items = [];
        if ($this->token && $this->token->getUser() instanceof User) {
            $user = $this->token->getUser();
            $items[] = [
                'path' => $this->router->generate('customer_account'),
                'label' => $user->getFirstName() . ' ' . $user->getLastName(),
            ];
            $items[] = [
                'path' => $this->router->generate('logout'),
                'label' => 'Logout',
            ];
        } else {
            $items[] = [
                'path' => $this->router->generate('login'),
                'label' => 'Login',
            ];
            $items[] = [
                'path' => $this->router->generate('register'),
                'label' => 'Register',
            ];
        }

        return $items;
    }
}
