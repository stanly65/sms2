<?php

namespace SMS\SalesBundle\Entity;

use AppBundle\Entity\User;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * SalesOrder Entity.
 *
 * @ORM\Table(name="sales_order")
 * @ORM\Entity(repositoryClass="SMS\SalesBundle\Repository\SalesOrderRepository")
 */
class SalesOrder
{
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETE = 'complete';
    const STATUS_CANCELED = 'canceled';

    /**
     * The id of the order.
     *
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * The many-to-one association between Order and User.
     *
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="orders")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * The price of the items.
     *
     * @var float
     *
     * @ORM\Column(name="items_price", type="decimal", precision=10, scale=2)
     */
    private $itemsPrice;

    /**
     * The price of the shipment.
     *
     * @var float
     *
     * @ORM\Column(name="shipment_price", type="decimal", precision=10, scale=2)
     */
    private $shipmentPrice;

    /**
     * The total price of the order.
     *
     * @var float
     *
     * @ORM\Column(name="total_price", type="decimal", precision=10, scale=2)
     */
    private $totalPrice;

    /**
     * The status of the order.
     *
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * The payment method.
     *
     * @var string
     *
     * @ORM\Column(name="payment_method", type="string", length=255)
     */
    private $paymentMethod;

    /**
     * The shipment method.
     *
     * @var string
     *
     * @ORM\Column(name="shipment_method", type="string", length=255)
     */
    private $shipmentMethod;

    /**
     * The creation date of this order.
     *
     * @var DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * The modification date of this order.
     *
     * @var DateTime
     *
     * @ORM\Column(name="modified_at", type="datetime")
     */
    private $modifiedAt;

    /**
     * The email of the user.
     *
     * @var string
     *
     * @ORM\Column(name="user_email", type="string", length=255)
     */
    private $userEmail;

    /**
     * The first name of the user.
     *
     * @var string
     *
     * @ORM\Column(name="user_first_name", type="string", length=255)
     */
    private $userFirstName;

    /**
     * The last name of the user.
     *
     * @var string
     *
     * @ORM\Column(name="user_last_name", type="string", length=255)
     */
    private $userLastName;

    /**
     * The country of the user.
     *
     * @var string
     *
     * @ORM\Column(name="address_country", type="string", length=255)
     */
    private $addressCountry;

    /**
     * The city of the user.
     *
     * @var string
     *
     * @ORM\Column(name="address_city", type="string", length=255)
     */
    private $addressCity;

    /**
     * The post code of the user.
     *
     * @var string
     *
     * @ORM\Column(name="address_postcode", type="string", length=255)
     */
    private $addressPostcode;

    /**
     * The street code of the user.
     *
     * @var string
     *
     * @ORM\Column(name="address_street", type="string", length=255)
     */
    private $addressStreet;

    /**
     * The telephone code of the user.
     *
     * @var string
     *
     * @ORM\Column(name="address_telephone", type="string", length=255)
     */
    private $addressTelephone;

    /**
     * The one-to-many association between SalesOrder and SalesOrderItem.
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="SalesOrderItem", mappedBy="salesOrder")
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
     * @return SalesOrder
     */
    public function setUser($user)
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
     * Sets items price.
     *
     * @param float $itemsPrice
     *
     * @return SalesOrder
     */
    public function setItemsPrice($itemsPrice)
    {
        $this->itemsPrice = $itemsPrice;

        return $this;
    }

    /**
     * Gets items price.
     *
     * @return float
     */
    public function getItemsPrice()
    {
        return $this->itemsPrice;
    }

    /**
     * Sets shipment price.
     *
     * @param float $shipmentPrice
     *
     * @return SalesOrder
     */
    public function setShipmentPrice($shipmentPrice)
    {
        $this->shipmentPrice = $shipmentPrice;

        return $this;
    }

    /**
     * Gets shipment price.
     *
     * @return float
     */
    public function getShipmentPrice()
    {
        return $this->shipmentPrice;
    }

    /**
     * Sets total price.
     *
     * @param float $totalPrice
     *
     * @return SalesOrder
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
     * Gets status.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Sets status.
     *
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Sets payment method.
     *
     * @param string $paymentMethod
     *
     * @return SalesOrder
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    /**
     * Gets payment method.
     *
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * Sets shipment method.
     *
     * @param string $shipmentMethod
     *
     * @return SalesOrder
     */
    public function setShipmentMethod($shipmentMethod)
    {
        $this->shipmentMethod = $shipmentMethod;

        return $this;
    }

    /**
     * Gets shipment method.
     *
     * @return string
     */
    public function getShipmentMethod()
    {
        return $this->shipmentMethod;
    }

    /**
     * Sets creation date.
     *
     * @param DateTime $createdAt
     *
     * @return SalesOrder
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
     * @return SalesOrder
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
     * Sets email.
     *
     * @param string $userEmail
     *
     * @return SalesOrder
     */
    public function setUserEmail($userEmail)
    {
        $this->userEmail = $userEmail;

        return $this;
    }

    /**
     * Gets email.
     *
     * @return string
     */
    public function getUserEmail()
    {
        return $this->userEmail;
    }

    /**
     * Sets first name.
     *
     * @param string $userFirstName
     *
     * @return SalesOrder
     */
    public function setUserFirstName($userFirstName)
    {
        $this->userFirstName = $userFirstName;

        return $this;
    }

    /**
     * Gets first name.
     *
     * @return string
     */
    public function getUserFirstName()
    {
        return $this->userFirstName;
    }

    /**
     * Sets last name.
     *
     * @param string $userLastName
     *
     * @return SalesOrder
     */
    public function setUserLastName($userLastName)
    {
        $this->userLastName = $userLastName;

        return $this;
    }

    /**
     * Gets last name.
     *
     * @return string
     */
    public function getUserLastName()
    {
        return $this->userLastName;
    }

    /**
     * Sets country.
     *
     * @param string $addressCountry
     *
     * @return SalesOrder
     */
    public function setAddressCountry($addressCountry)
    {
        $this->addressCountry = $addressCountry;

        return $this;
    }

    /**
     * Gets country.
     *
     * @return string
     */
    public function getAddressCountry()
    {
        return $this->addressCountry;
    }

    /**
     * Sets city.
     *
     * @param string $addressCity
     *
     * @return SalesOrder
     */
    public function setAddressCity($addressCity)
    {
        $this->addressCity = $addressCity;

        return $this;
    }

    /**
     * Gets city.
     *
     * @return string
     */
    public function getAddressCity()
    {
        return $this->addressCity;
    }

    /**
     * Sets postcode.
     *
     * @param string $addressPostcode
     *
     * @return SalesOrder
     */
    public function setAddressPostcode($addressPostcode)
    {
        $this->addressPostcode = $addressPostcode;

        return $this;
    }

    /**
     * Gets postcode.
     *
     * @return string
     */
    public function getAddressPostcode()
    {
        return $this->addressPostcode;
    }

    /**
     * Sets address.
     *
     * @param string $addressStreet
     *
     * @return SalesOrder
     */
    public function setAddressStreet($addressStreet)
    {
        $this->addressStreet = $addressStreet;

        return $this;
    }

    /**
     * Gets address.
     *
     * @return string
     */
    public function getAddressStreet()
    {
        return $this->addressStreet;
    }

    /**
     * Sets telephone.
     *
     * @param string $addressTelephone
     *
     * @return SalesOrder
     */
    public function setAddressTelephone($addressTelephone)
    {
        $this->addressTelephone = $addressTelephone;

        return $this;
    }

    /**
     * Gets telephone.
     *
     * @return string
     */
    public function getAddressTelephone()
    {
        return $this->addressTelephone;
    }
}

