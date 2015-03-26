<?php

namespace Lifestutor\StoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\EmbeddedDocument 
 */
class BillingAddress
{
    /**
     * @MongoDB\String
     */
	protected $address1;

	/**
     * @MongoDB\String
     */
	protected $address2;

    /**
     * @MongoDB\String
     */
    protected $cityProvince;

    /**
     * @MongoDB\String
     */
    protected $country;

    /**
     * @MongoDB\String
     */
    protected $postal;

    /**
     * [setAddress1 description]
     * 
     * @param string $address
     *
     * @return this
     */
    public function setAddress1($address)
    {
        $this->address1 = $address;

         return $this;
    }

    /**
     * [setAddress2 description]
     * 
     * @param string $address
     *
     * @return this
     */
    public function setAddress2($address)
    {
        $this->address2 = $address;

        return $this;
    }

    /**
     * [cityProvince description]
     * 
     * @param string $address
     *
     * @return this
     */
    public function setCityProvince($city)
    {
        $this->cityProvince = $city;

        return $this;
    }

    /**
     * [country description]
     * 
     * @param string $address
     *
     * @return this
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * [postal description]
     * 
     * @param string $address
     *
     * @return this
     */
    public function setPostal($postalCode)
    {
        $this->postal = $postalCode;

        return $this;
    }

    /**
     * Get address1
     *
     * @return string $address1
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * Get address2
     *
     * @return string $address2
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * Get cityProvince
     *
     * @return string $cityProvince
     */
    public function getCityProvince()
    {
        return $this->cityProvince;
    }

    /**
     * Get country
     *
     * @return string $country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Get postal
     *
     * @return string $postal
     */
    public function getPostal()
    {
        return $this->postal;
    }
}