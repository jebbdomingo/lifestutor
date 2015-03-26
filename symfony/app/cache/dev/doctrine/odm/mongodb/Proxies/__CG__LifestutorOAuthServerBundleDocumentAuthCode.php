<?php

namespace MongoDBODMProxies\__CG__\Lifestutor\OAuthServerBundle\Document;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class AuthCode extends \Lifestutor\OAuthServerBundle\Document\AuthCode implements \Doctrine\ODM\MongoDB\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = array();



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return array('__isInitialized__', 'id', 'client', 'redirectUri', 'token', 'expiresAt', 'scope', 'user');
        }

        return array('__isInitialized__', 'id', 'client', 'redirectUri', 'token', 'expiresAt', 'scope', 'user');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (AuthCode $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', array());
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', array());
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getClient()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getClient', array());

        return parent::getClient();
    }

    /**
     * {@inheritDoc}
     */
    public function setClient(\FOS\OAuthServerBundle\Model\ClientInterface $client)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setClient', array($client));

        return parent::setClient($client);
    }

    /**
     * {@inheritDoc}
     */
    public function setRedirectUri($redirectUri)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRedirectUri', array($redirectUri));

        return parent::setRedirectUri($redirectUri);
    }

    /**
     * {@inheritDoc}
     */
    public function getRedirectUri()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRedirectUri', array());

        return parent::getRedirectUri();
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', array());

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function getClientId()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getClientId', array());

        return parent::getClientId();
    }

    /**
     * {@inheritDoc}
     */
    public function setExpiresAt($timestamp)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setExpiresAt', array($timestamp));

        return parent::setExpiresAt($timestamp);
    }

    /**
     * {@inheritDoc}
     */
    public function getExpiresAt()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getExpiresAt', array());

        return parent::getExpiresAt();
    }

    /**
     * {@inheritDoc}
     */
    public function getExpiresIn()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getExpiresIn', array());

        return parent::getExpiresIn();
    }

    /**
     * {@inheritDoc}
     */
    public function hasExpired()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'hasExpired', array());

        return parent::hasExpired();
    }

    /**
     * {@inheritDoc}
     */
    public function setToken($token)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setToken', array($token));

        return parent::setToken($token);
    }

    /**
     * {@inheritDoc}
     */
    public function getToken()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getToken', array());

        return parent::getToken();
    }

    /**
     * {@inheritDoc}
     */
    public function setScope($scope)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setScope', array($scope));

        return parent::setScope($scope);
    }

    /**
     * {@inheritDoc}
     */
    public function getScope()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getScope', array());

        return parent::getScope();
    }

    /**
     * {@inheritDoc}
     */
    public function setUser(\Symfony\Component\Security\Core\User\UserInterface $user)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUser', array($user));

        return parent::setUser($user);
    }

    /**
     * {@inheritDoc}
     */
    public function getUser()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUser', array());

        return parent::getUser();
    }

    /**
     * {@inheritDoc}
     */
    public function getData()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getData', array());

        return parent::getData();
    }

}
