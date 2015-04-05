<?php

namespace Lifestutor\StoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

use JMS\Serializer\Annotation\Expose;

/**
 * @MongoDB\Document
 */
class Customer extends User
{
    /**
     * @MongoDB\String
     */
    protected $userType = 'Customer';

    /**
     * @MongoDB\EmbedOne(targetDocument="BillingAddress")
     * @Expose
     */
    private $billingAddress;

    /**
     * @MongoDB\EmbedOne(targetDocument="ShippingAddress")
     */
    private $shippingAddress;

    /**
     * @MongoDB\EmbedOne(targetDocument="Cart")
     */
    private $cart;

    /**
     * Date of birth
     * 
     * @var null
     */
    protected $dateOfBirth = null;

    /**
     * [setBillingAddress description]
     * 
     * @param BillingAddress
     *
     * @return this
     */
    public function setBillingAddress(BillingAddress $address)
    {
        $this->billingAddress = $address;

        return $this;
    }

    /**
     * [setShippingAddress description]
     * 
     * @param ShippingAddress
     *
     * @return this
     */
    public function setShippingAddress(ShippingAddress $address)
    {
        $this->shippingAddress = $address;

        return $this;
    }

    /**
     * [initCart description]
     * 
     * @param Cart
     *
     * @return this
     */
    public function initCart(Cart $cart)
    {
        $this->cart = $cart;

        return $this;
    }

    /**
     * [getBillingAddress description]
     * 
     * @return BillingAddress
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * Get birth day
     * 
     * @return Date
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * Set birth day
     * 
     * @param string
     *
     * @return this
     */
    public function setDateOfBirth($date)
    {
        $this->dateOfBirth = $date;

        return $this;
    }
}