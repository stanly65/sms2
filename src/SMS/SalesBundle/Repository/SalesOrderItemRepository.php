<?php

namespace SMS\SalesBundle\Repository;

use SMS\CatalogBundle\Entity\Product;

class SalesOrderItemRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Builds a list of the five bestselling products.
     *
     * @return Product[] array
     */
    public function getBestsellers()
    {
        $products = [];
        $query = $this->_em->createQuery('SELECT IDENTITY(t.product), SUM(t.qty) AS HIDDEN q
                        FROM SMS\SalesBundle\Entity\SalesOrderItem t
                        GROUP BY t.product ORDER BY q DESC')
            ->setMaxResults(4);
        $result = $query->getResult();
        foreach ($result as $product) {
            $products[] = $this->_em->getRepository('SMSCatalogBundle:Product')
                ->find(current($product));
        }

        return $products;
    }
}
