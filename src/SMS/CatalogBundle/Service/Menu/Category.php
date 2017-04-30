<?php

namespace SMS\CatalogBundle\Service\Menu;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use SMS\CatalogBundle\Entity\Category as CategoryEntity;

class Category
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
     * Gets all categories.
     *
     * @return array
     */
    public function getItems()
    {
        $output = [];
        $categories = $this->em->getRepository('SMSCatalogBundle:Category')->findAll();
        foreach ($categories as $category) {
            /* @var $category CategoryEntity */
            $output[] = [
                'path' => $this->router->generate('category_show', [
                    'id' => $category->getId()
                ]),
                'label' => $category->getTitle(),
            ];
        }

        return $output;
    }
}
