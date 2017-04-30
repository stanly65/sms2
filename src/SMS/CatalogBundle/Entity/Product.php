<?php

namespace SMS\CatalogBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Product Entity.
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="SMS\CatalogBundle\Repository\ProductRepository")
 */
class Product
{
    /**
     * The id of the product.
     *
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * The title of the product.
     *
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * The price of the product.
     *
     * @var float
     *
     *@ORM\Column(name="price", type="decimal", precision=10, scale=2)
     */
    private $price;

    /**
     * The description of the product.
     *
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * The quantity of the product.
     *
     * @var int
     *
     * @ORM\Column(name="qty", type="integer")
     * @Assert\Range(
     *     min = 1,
     *     minMessage = "Please, enter 1 or higher"
     * )
     */
    private $qty;

    /**
     * The many-to-one association between Product and Category.
     *
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * The image of the product uploaded through a form.
     *
     * @var UploadedFile
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     *
     * @Assert\File(
     *      maxSize = "2M",
     *      mimeTypes = {
     *          "image/png",
     *          "image/jpeg",
     *          "image/jpg",
     *          "image/gif",
     *      }
     * )
     */
    private $image;

    /**
     * The availability of the product.
     *
     * @var bool
     *
     * @ORM\Column(name="onsale", type="boolean")
     */
    private $onsale;

    /**
     * The one-to-many association between Product and CartItem.
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="SMS\SalesBundle\Entity\CartItem", mappedBy="product")
     */
    private $items;

    /**
     * The one-to-many association between Product and CartItem.
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="SMS\SalesBundle\Entity\SalesOrderItem", mappedBy="product")
     */
    private $orderItems;

    /**
     * Initializes cart items and order items.
     */
    public function __construct() {
        $this->items = new ArrayCollection;
        $this->orderItems = new ArrayCollection;
    }

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
     * Sets title.
     *
     * @param string $title
     *
     * @return Product
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
     * Sets price.
     *
     * @param float $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Gets price.
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Sets description.
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Gets description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets qty.
     *
     * @param integer $qty
     *
     * @return Product
     */
    public function setQty($qty)
    {
        $this->qty = $qty;

        return $this;
    }

    /**
     * Gets qty.
     *
     * @return int
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * Sets category.
     *
     * @param Category $category
     *
     * @return Product
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Gets category.
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Sets image.
     *
     * @param string $image
     *
     * @return Product
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Gets image.
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Sets availability.
     *
     * @param boolean $onsale
     *
     * @return Product
     */
    public function setOnsale($onsale)
    {
        $this->onsale = $onsale;

        return $this;
    }

    /**
     * Get availability.
     *
     * @return bool
     */
    public function getOnsale()
    {
        return $this->onsale;
    }

    /**
     * Gets items.
     *
     * @return ArrayCollection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Sets items.
     *
     * @param ArrayCollection $items
     */
    public function setItems(ArrayCollection $items)
    {
        $this->items = $items;
    }

    /**
     * Gets order items.
     *
     * @return ArrayCollection
     */
    public function getOrderItems()
    {
        return $this->orderItems;
    }

    /**
     * Sets order items.
     *
     * @param ArrayCollection $orderItems
     */
    public function setOrderItems(ArrayCollection $orderItems)
    {
        $this->items = $orderItems;
    }
}

