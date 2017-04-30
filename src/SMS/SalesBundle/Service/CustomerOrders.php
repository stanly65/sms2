<?php

namespace SMS\SalesBundle\Service;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use SMS\SalesBundle\Entity\SalesOrder;

class CustomerOrders
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
     * Provides a collection of previously created orders for currently logged-in user.
     *
     * @return array
     */
    public function getOrders()
    {
        $orders = [];
        if ($this->token && $this->token->getUser() instanceof User) {
            $user = $this->token->getUser();
            $salesOrders = $this->em->getRepository('SMSSalesBundle:SalesOrder')->findBy(['user' => $user]);
            foreach ($salesOrders as $salesOrder) {
                /* @var SalesOrder $salesOrder */
                $orders[] = [
                    'id' => $salesOrder->getId(),
                    'date' => $salesOrder->getCreatedAt()->format('d/m/Y H:i:s'),
                    'ship_to' => $salesOrder->getUserFirstName() . ' ' . $salesOrder->getUserLastName(),
                    'order_total' => $salesOrder->getTotalPrice(),
                    'status' => $salesOrder->getStatus(),
                    'actions' => [
                        [
                            'label' => 'Cancel',
                            'path' => $this->router->generate('sms_sales_order_cancel', ['id' => $salesOrder->getId()])
                        ],
                    ]
                ];
            }
        }

        return $orders;
    }
}
