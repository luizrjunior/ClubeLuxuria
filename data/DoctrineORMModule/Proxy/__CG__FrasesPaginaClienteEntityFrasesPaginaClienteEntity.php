<?php

namespace DoctrineORMModule\Proxy\__CG__\FrasesPaginaCliente\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class FrasesPaginaClienteEntity extends \FrasesPaginaCliente\Entity\FrasesPaginaClienteEntity implements \Doctrine\ORM\Proxy\Proxy
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
            return array('__isInitialized__', '' . "\0" . 'FrasesPaginaCliente\\Entity\\FrasesPaginaClienteEntity' . "\0" . 'idFrasesPaginaCliente', '' . "\0" . 'FrasesPaginaCliente\\Entity\\FrasesPaginaClienteEntity' . "\0" . 'idCliente', '' . "\0" . 'FrasesPaginaCliente\\Entity\\FrasesPaginaClienteEntity' . "\0" . 'frase1', '' . "\0" . 'FrasesPaginaCliente\\Entity\\FrasesPaginaClienteEntity' . "\0" . 'frase2', '' . "\0" . 'FrasesPaginaCliente\\Entity\\FrasesPaginaClienteEntity' . "\0" . 'frase3');
        }

        return array('__isInitialized__', '' . "\0" . 'FrasesPaginaCliente\\Entity\\FrasesPaginaClienteEntity' . "\0" . 'idFrasesPaginaCliente', '' . "\0" . 'FrasesPaginaCliente\\Entity\\FrasesPaginaClienteEntity' . "\0" . 'idCliente', '' . "\0" . 'FrasesPaginaCliente\\Entity\\FrasesPaginaClienteEntity' . "\0" . 'frase1', '' . "\0" . 'FrasesPaginaCliente\\Entity\\FrasesPaginaClienteEntity' . "\0" . 'frase2', '' . "\0" . 'FrasesPaginaCliente\\Entity\\FrasesPaginaClienteEntity' . "\0" . 'frase3');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (FrasesPaginaClienteEntity $proxy) {
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
    public function getIdFrasesPaginaCliente()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getIdFrasesPaginaCliente();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIdFrasesPaginaCliente', array());

        return parent::getIdFrasesPaginaCliente();
    }

    /**
     * {@inheritDoc}
     */
    public function getIdCliente()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIdCliente', array());

        return parent::getIdCliente();
    }

    /**
     * {@inheritDoc}
     */
    public function getFrase1()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFrase1', array());

        return parent::getFrase1();
    }

    /**
     * {@inheritDoc}
     */
    public function getFrase2()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFrase2', array());

        return parent::getFrase2();
    }

    /**
     * {@inheritDoc}
     */
    public function getFrase3()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFrase3', array());

        return parent::getFrase3();
    }

    /**
     * {@inheritDoc}
     */
    public function setIdFrasesPaginaCliente($idFrasesPaginaCliente)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIdFrasesPaginaCliente', array($idFrasesPaginaCliente));

        return parent::setIdFrasesPaginaCliente($idFrasesPaginaCliente);
    }

    /**
     * {@inheritDoc}
     */
    public function setIdCliente(\Cliente\Entity\ClienteEntity $idCliente)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIdCliente', array($idCliente));

        return parent::setIdCliente($idCliente);
    }

    /**
     * {@inheritDoc}
     */
    public function setFrase1($frase1)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFrase1', array($frase1));

        return parent::setFrase1($frase1);
    }

    /**
     * {@inheritDoc}
     */
    public function setFrase2($frase2)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFrase2', array($frase2));

        return parent::setFrase2($frase2);
    }

    /**
     * {@inheritDoc}
     */
    public function setFrase3($frase3)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFrase3', array($frase3));

        return parent::setFrase3($frase3);
    }

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'toArray', array());

        return parent::toArray();
    }

}
