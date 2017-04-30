<?php

namespace SMS\SalesBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use SMS\SalesBundle\Entity\SalesOrderItem;
use SMS\SalesBundle\Repository\SalesOrderItemRepository;

class BestSellers
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
     * Shows five of the bestselling products in the store.
     *
     * @return array
     */
    public function getItems()
    {
        $products = [];
        $salesOrderItem = $this->em->getRepository('SMSSalesBundle:SalesOrderItem');
        /** @var SalesOrderItemRepository $salesOrderItem */
        $bestsellers = $salesOrderItem->getBestsellers();
        foreach ($bestsellers as $product) {
            $products[] = [
                'path' => $this->router->generate('product_show', ['id' => $product->getId()]),
                'name' => $product->getTitle(),
                'img' => $product->getImage(),
                'qty' => $product->getQty(),
                'price' => $product->getPrice(),
                'id' => $product->getId(),
            ];
        }

        return $products;
    }
}
