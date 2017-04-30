<?php

namespace SMS\SalesBundle\Service;

use Symfony\Bundle\FrameworkBundle\Routing\Router;

class AddToCartUrl
{
    /**
     * The instance of Router.
     *
     * @var Router
     */
    private $router;

    /**
     * Initializes properties.
     *
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Creates Add to Cart link.
     *
     * @param int $productId
     * @return string
     */
    public function get($productId)
    {
        return $this->router->generate('sms_sales_cart_add', ['id' => $productId]);
    }
}
