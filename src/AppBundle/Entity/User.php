<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints as CaptchaAssert;

/**
 * User Entity.
 *
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * The first name of the customer.
     *
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255)
     *
     * @Assert\NotBlank(message="Please enter your first name.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="The name is too short.",
     *     maxMessage="The name is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    private $firstName;

    /**
     * The last name of the customer.
     *
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255)
     *
     * @Assert\NotBlank(message="Please enter your last name.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="The name is too short.",
     *     maxMessage="The name is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    private $lastName;

    /**
     * The phone number of the customer.
     *
     * @var string
     *
     * @ORM\Column(name="phone_number", type="string", length=255)
     *
     * @Assert\NotBlank(message="Please enter your phone.", groups={"Registration", "Profile"})
     */
    private $phoneNumber;

    /**
     * The country of the customer.
     *
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     *
     * @Assert\NotBlank(message="Please enter your country.", groups={"Registration", "Profile"})
     */
    private $country;

    /**
     * The city of the customer.
     *
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     *
     * @Assert\NotBlank(message="Please enter your city.", groups={"Registration", "Profile"})
     */
    private $city;

    /**
     * The post code of the customer.
     *
     * @var string
     *
     * @ORM\Column(name="postcode", type="string", length=255)
     *
     * @Assert\NotBlank(message="Please enter your postcode.", groups={"Registration", "Profile"})
     */
    private $postcode;

    /**
     * The street of the customer.
     *
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=255)
     *
     * @Assert\NotBlank(message="Please enter your address.", groups={"Registration", "Profile"})
     */
    private $street;

    /**
     * The one-to-many association between User and SalesOrder.
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="SMS\SalesBundle\Entity\SalesOrder", mappedBy="user")
     */
    private $orders;

    /**
     * Initializes orders.
     */
    public function __construct() {
        $this->orders = new ArrayCollection;
        parent::__construct();
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
     * Sets first name.
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Gets first name.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Sets last name.
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Gets last name.
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set phone number.
     *
     * @param string $phoneNumber
     *
     * @return User
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Gets phone number.
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Sets country.
     *
     * @param string $country
     *
     * @return User
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Gets country.
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Sets city.
     *
     * @param string $city
     *
     * @return User
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Gets city.
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Sets post code.
     *
     * @param string $postcode
     *
     * @return User
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * Gets postcode.
     *
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Sets street.
     *
     * @param string $street
     *
     * @return User
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Gets street.
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }
}
