<?php

namespace Lifestutor\StoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\EmbeddedDocument 
 */
class ShippingAddress
{
	/**
	 * @var array
	 */
	private $address1 = array(
		'address1' => null,
		'address2' => null
	);

	/**
	 * @var array
	 */
	private $address2 = array(
		'cityProvince' 	=> null,
		'country' 		=> null,
		'postal' 		=> null
	);

    /**
     * Set Address 1
     *
     * @param string address
     *
     * @return this
     */
    public function setAddress1($address)
    {
    	$this->address1['address1'] = $address;

    	return $this;
    }

    /**
     * Set Address 2
     *
     * @param string address
     *
     * @return this
     */
    public function setAddress2($address)
    {
    	$this->address1['address2'] = $address;

    	return $this;
    }

    /**
     * Set City/Province
     *
     * @param string city
     *
     * @return this
     */
    public function setCityProvince($city)
    {
    	$this->address2['cityProvince'] = $city;

    	return $this;
    }

    /**
     * Set Postal
     *
     * @param string postal
     *
     * @return this
     */
    public function setPostal($postal)
    {
    	$this->address2['postal'] = $postal;

    	return $this;
    }

    /**
     * Set Country
     *
     * @param string country
     *
     * @return this
     */
    public function setCountry($country)
    {
    	$this->address2['country'] = $country;

    	return $this;
    }

    /**
     * Get Address 1
     *
     * @return string
     */
    public function getAddress1()
    {
    	return $this->address1['address1'];
    }

    /**
     * Get Address 2
     *
     * @return string
     */
    public function getAddress2()
    {
    	return $this->address1['address2'];
    }

    /**
     * Get City/Province
     *
     * @return string
     */
    public function getCityProvince()
    {
    	return $this->address2['cityProvince'];
    }

    /**
     * Get Postal
     *
     * @return string
     */
    public function getPostal()
    {
    	return $this->address2['postal'];
    }

    /**
     * Get Country
     *
     * @return string
     */
    public function getCountry()
    {
    	return $this->address2['country'];
    }

    /**
     * Get full address
     *
     * @return string
     */
    public function getFullAddress()
    {
    	$address = array();

    	$address[] = implode(', ', $this->address1);
    	$address[] = implode(' ', $this->address2);

    	return implode('', $address);
    }
}