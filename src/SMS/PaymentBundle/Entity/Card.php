<?php

namespace SMS\PaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Card Entity.
 *
 * @ORM\Table(name="card")
 * @ORM\Entity(repositoryClass="SMS\PaymentBundle\Repository\CardRepository")
 */
class Card
{
    /**
     * The id of the card.
     *
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * The number of the card.
     *
     * @var string
     *
     * @ORM\Column(name="card_number", type="string", length=255)
     */
    private $cardNumber;

    /**
     * The expiry date of the card.
     *
     * @var string
     *
     * @ORM\Column(name="expiry_date", type="string", length=255)
     */
    private $expiryDate;

    /**
     * The security code of the card.
     *
     * @var string
     *
     * @ORM\Column(name="security_code", type="string", length=255)
     */
    private $securityCode;


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
     * Sets number.
     *
     * @param string $cardNumber
     *
     * @return Card
     */
    public function setCardNumber($cardNumber)
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    /**
     * Gets number.
     *
     * @return string
     */
    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    /**
     * Sets expiry date.
     *
     * @param string $expiryDate
     *
     * @return Card
     */
    public function setExpiryDate($expiryDate)
    {
        $this->expiryDate = $expiryDate;

        return $this;
    }

    /**
     * Gets expiry date.
     *
     * @return string
     */
    public function getExpiryDate()
    {
        return $this->expiryDate;
    }

    /**
     * Sets security code.
     *
     * @param string $securityCode
     *
     * @return Card
     */
    public function setSecurityCode($securityCode)
    {
        $this->securityCode = $securityCode;

        return $this;
    }

    /**
     * Gets security code.
     *
     * @return string
     */
    public function getSecurityCode()
    {
        return $this->securityCode;
    }
}

