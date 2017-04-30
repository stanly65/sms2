<?php

namespace SMS\CatalogBundle\Service\Block;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use SMS\CatalogBundle\Entity\Product;

class OnSale
{
    /**
     * The instance of EntityManager.
     *
     * @var EntityManager
     */
    private $em;

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
     * @param Router $router
     */
    public function __construct(EntityManager $entityManager, Router $router)
    {
        $this->em = $entityManager;
        $this->router = $router;
    }

    /**
     * Gets some products.
     *
     * @return array
     */
    public function getItems()
    {
        $output  = [];
        $products = $this->em->getRepository('SMSCatalogBundle:Product')->findBy(
            ['onsale' => true], null);
        foreach ($products as $product) {
            /* @var $product Product */
            $output[] = [
                'path' => $this->router->generate('product_show', [
                    'id' => $product->getId()
                ]),
                'name' => $product->getTitle(),
                'img' => $product->getImage(),
                'qty' => $product->getQty(),
                'price' => $product->getPrice(),
                'id' => $product->getId(),
            ];
        }

        return $output;
    }
}
