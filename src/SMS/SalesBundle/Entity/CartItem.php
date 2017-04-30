<?php

namespace SMS\SalesBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use SMS\CatalogBundle\Entity\Product;

/**
 * CartItem Entity.
 *
 * @ORM\Table(name="cart_item")
 * @ORM\Entity(repositoryClass="SMS\SalesBundle\Repository\CartItemRepository")
 */
class CartItem
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
     * The many-to-one association between CartItem and Cart.
     *
     * @var Cart
     *
     * @ORM\ManyToOne(targetEntity="Cart", inversedBy="items")
     * @ORM\JoinColumn(name="cart_id", referencedColumnName="id")
     */
    private $cart;

    /**
     * The many-to-one association between CartItem and Product.
     *
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="SMS\CatalogBundle\Entity\Product", inversedBy="items")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

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
     * Sets cart.
     *
     * @param Cart $cart
     *
     * @return CartItem
     */
    public function setCart(Cart $cart)
    {
        $this->cart = $cart;

        return $this;
    }
    /**
     * Gets cart.
     *
     * @return Cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Sets quantity.
     *
     * @param int $qty
     *
     * @return CartItem
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
     * @return CartItem
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
     * Sets creation date.
     *
     * @param DateTime $createdAt
     *
     * @return CartItem
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Gets creation date.
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
     * @return CartItem
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
     * Sets product.
     *
     * @param Product $product
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;
    }
}

