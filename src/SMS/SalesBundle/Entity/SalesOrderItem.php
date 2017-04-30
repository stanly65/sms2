<?php

namespace SMS\SalesBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use SMS\CatalogBundle\Entity\Product;

/**
 * SalesOrderItem Entity.
 *
 * @ORM\Table(name="sales_order_item")
 * @ORM\Entity(repositoryClass="SMS\SalesBundle\Repository\SalesOrderItemRepository")
 */
class SalesOrderItem
{
    /**
     * The id of the item.
     *
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * The many-to-one association between SalesOrderItem and SalesOrder.
     *
     * @var SalesOrder
     *
     * @ORM\ManyToOne(targetEntity="SalesOrder", inversedBy="items")
     * @ORM\JoinColumn(name="sales_order_id", referencedColumnName="id")
     */
    private $salesOrder;

    /**
     * The many-to-one association between SalesOrderItem and Product.
     *
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="SMS\CatalogBundle\Entity\Product", inversedBy="orderItems")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

    /**
     * The title of the item.
     *
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * The quantity of the items.
     *
     * @var int
     *
     * @ORM\Column(name="qty", type="integer")
     */
    private $qty;

    /**
     * The price per unit.
     *
     * @var float
     *
     * @ORM\Column(name="unit_price", type="decimal", precision=10, scale=2)
     */
    private $unitPrice;

    /**
     * The total price.
     *
     * @var float
     *
     * @ORM\Column(name="total_price", type="decimal", precision=10, scale=2)
     */
    private $totalPrice;

    /**
     * The creation date of this item.
     *
     * @var DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * The modification date of this item.
     *
     * @var DateTime
     *
     * @ORM\Column(name="modified_at", type="datetime")
     */
    private $modifiedAt;

    /**
     * Gets id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets order.
     *
     * @param SalesOrder $salesOrder
     *
     * @return SalesOrderItem
     */
    public function setSalesOrder(SalesOrder $salesOrder)
    {
        $this->salesOrder = $salesOrder;

        return $this;
    }

    /**
     * Gets order.
     *
     * @return SalesOrder
     */
    public function getSalesOrder()
    {
        return $this->salesOrder;
    }

    /**
     * Sets product.
     *
     * @param Product $product
     *
     * @return SalesOrderItem
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Gets product.
     *
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Sets title.
     *
     * @param string $title
     *
     * @return SalesOrderItem
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Gets title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets quantity.
     *
     * @param integer $qty
     *
     * @return SalesOrderItem
     */
    public function setQty($qty)
    {
        $this->qty = $qty;

        return $this;
    }

    /**
     * Gets quantity.
     *
     * @return int
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * Sets unit price.
     *
     * @param float $unitPrice
     *
     * @return SalesOrderItem
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    /**
     * Gets unit price.
     *
     * @return float
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * Sets total price.
     *
     * @param float $totalPrice
     *
     * @return SalesOrderItem
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    /**
     * Gets total price.
     *
     * @return float
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * Sets creation date.
     *
     * @param DateTime $createdAt
     *
     * @return SalesOrderItem
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get creation date.
     *
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Sets modification date.
     *
     * @param DateTime $modifiedAt
     *
     * @return SalesOrderItem
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    /**
     * Gets modification date.
     *
     * @return DateTime
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }
}

