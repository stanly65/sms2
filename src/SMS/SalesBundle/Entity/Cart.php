<?php

namespace SMS\SalesBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\User;

/**
 * Cart Entity.
 *
 * @ORM\Table(name="cart")
 * @ORM\Entity(repositoryClass="SMS\SalesBundle\Repository\CartRepository")
 */
class Cart
{
    /**
     * The id of the cart.
     *
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * The one-to-one association between User and Cart.
     *
     * @var User
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * The creation date of this cart.
     *
     * @var DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * The modification date of this cart.
     *
     * @var DateTime
     *
     * @ORM\Column(name="modified_at", type="datetime")
     */
    private $modifiedAt;

    /**
     * The one-to-many association between Cart and CartItem.
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="CartItem", mappedBy="cart")
     */
    private $items;

    /**
     * Initializes items.
     */
    public function __construct() {
        $this->items = new ArrayCollection;
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
     * Sets user.
     *
     * @param User $user
     *
     * @return Cart
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Gets user.
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Sets creation date.
     *
     * @param DateTime $createdAt
     *
     * @return Cart
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
     * @return Cart
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
}

