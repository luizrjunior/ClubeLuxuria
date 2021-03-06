<?php

namespace DoctrineORMModule\Proxy\__CG__\Login\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class PreCadastroEntity extends \Login\Entity\PreCadastroEntity implements \Doctrine\ORM\Proxy\Proxy
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
            return array('__isInitialized__', '' . "\0" . 'Login\\Entity\\PreCadastroEntity' . "\0" . 'idCadastro', '' . "\0" . 'Login\\Entity\\PreCadastroEntity' . "\0" . 'noUsuario', '' . "\0" . 'Login\\Entity\\PreCadastroEntity' . "\0" . 'dtNascimento', '' . "\0" . 'Login\\Entity\\PreCadastroEntity' . "\0" . 'cpf', '' . "\0" . 'Login\\Entity\\PreCadastroEntity' . "\0" . 'email', '' . "\0" . 'Login\\Entity\\PreCadastroEntity' . "\0" . 'tel1', '' . "\0" . 'Login\\Entity\\PreCadastroEntity' . "\0" . 'tel2', '' . "\0" . 'Login\\Entity\\PreCadastroEntity' . "\0" . 'uf', '' . "\0" . 'Login\\Entity\\PreCadastroEntity' . "\0" . 'cep', '' . "\0" . 'Login\\Entity\\PreCadastroEntity' . "\0" . 'cidade', '' . "\0" . 'Login\\Entity\\PreCadastroEntity' . "\0" . 'bairro', '' . "\0" . 'Login\\Entity\\PreCadastroEntity' . "\0" . 'complemento', '' . "\0" . 'Login\\Entity\\PreCadastroEntity' . "\0" . 'codPromocional');
        }

        return array('__isInitialized__', '' . "\0" . 'Login\\Entity\\PreCadastroEntity' . "\0" . 'idCadastro', '' . "\0" . 'Login\\Entity\\PreCadastroEntity' . "\0" . 'noUsuario', '' . "\0" . 'Login\\Entity\\PreCadastroEntity' . "\0" . 'dtNascimento', '' . "\0" . 'Login\\Entity\\PreCadastroEntity' . "\0" . 'cpf', '' . "\0" . 'Login\\Entity\\PreCadastroEntity' . "\0" . 'email', '' . "\0" . 'Login\\Entity\\PreCadastroEntity' . "\0" . 'tel1', '' . "\0" . 'Login\\Entity\\PreCadastroEntity' . "\0" . 'tel2', '' . "\0" . 'Login\\Entity\\PreCadastroEntity' . "\0" . 'uf', '' . "\0" . 'Login\\Entity\\PreCadastroEntity' . "\0" . 'cep', '' . "\0" . 'Login\\Entity\\PreCadastroEntity' . "\0" . 'cidade', '' . "\0" . 'Login\\Entity\\PreCadastroEntity' . "\0" . 'bairro', '' . "\0" . 'Login\\Entity\\PreCadastroEntity' . "\0" . 'complemento', '' . "\0" . 'Login\\Entity\\PreCadastroEntity' . "\0" . 'codPromocional');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (PreCadastroEntity $proxy) {
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
    public function getIdCadastro()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getIdCadastro();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIdCadastro', array());

        return parent::getIdCadastro();
    }

    /**
     * {@inheritDoc}
     */
    public function getNoUsuario()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNoUsuario', array());

        return parent::getNoUsuario();
    }

    /**
     * {@inheritDoc}
     */
    public function getDtNascimento()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDtNascimento', array());

        return parent::getDtNascimento();
    }

    /**
     * {@inheritDoc}
     */
    public function getCpf()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCpf', array());

        return parent::getCpf();
    }

    /**
     * {@inheritDoc}
     */
    public function getEmail()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEmail', array());

        return parent::getEmail();
    }

    /**
     * {@inheritDoc}
     */
    public function getTel1()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTel1', array());

        return parent::getTel1();
    }

    /**
     * {@inheritDoc}
     */
    public function getTel2()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTel2', array());

        return parent::getTel2();
    }

    /**
     * {@inheritDoc}
     */
    public function getUf()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUf', array());

        return parent::getUf();
    }

    /**
     * {@inheritDoc}
     */
    public function getCep()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCep', array());

        return parent::getCep();
    }

    /**
     * {@inheritDoc}
     */
    public function getCidade()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCidade', array());

        return parent::getCidade();
    }

    /**
     * {@inheritDoc}
     */
    public function getBairro()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBairro', array());

        return parent::getBairro();
    }

    /**
     * {@inheritDoc}
     */
    public function getComplemento()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getComplemento', array());

        return parent::getComplemento();
    }

    /**
     * {@inheritDoc}
     */
    public function getCodPromocional()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCodPromocional', array());

        return parent::getCodPromocional();
    }

    /**
     * {@inheritDoc}
     */
    public function setNoUsuario($noUsuario)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNoUsuario', array($noUsuario));

        return parent::setNoUsuario($noUsuario);
    }

    /**
     * {@inheritDoc}
     */
    public function setDtNascimento($dtNascimento)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDtNascimento', array($dtNascimento));

        return parent::setDtNascimento($dtNascimento);
    }

    /**
     * {@inheritDoc}
     */
    public function setCpf($cpf)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCpf', array($cpf));

        return parent::setCpf($cpf);
    }

    /**
     * {@inheritDoc}
     */
    public function setEmail($email)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEmail', array($email));

        return parent::setEmail($email);
    }

    /**
     * {@inheritDoc}
     */
    public function setTel1($tel1)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTel1', array($tel1));

        return parent::setTel1($tel1);
    }

    /**
     * {@inheritDoc}
     */
    public function setTel2($tel2)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTel2', array($tel2));

        return parent::setTel2($tel2);
    }

    /**
     * {@inheritDoc}
     */
    public function setUf($uf)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUf', array($uf));

        return parent::setUf($uf);
    }

    /**
     * {@inheritDoc}
     */
    public function setCep($cep)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCep', array($cep));

        return parent::setCep($cep);
    }

    /**
     * {@inheritDoc}
     */
    public function setCidade($cidade)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCidade', array($cidade));

        return parent::setCidade($cidade);
    }

    /**
     * {@inheritDoc}
     */
    public function setBairro($bairro)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBairro', array($bairro));

        return parent::setBairro($bairro);
    }

    /**
     * {@inheritDoc}
     */
    public function setComplemento($complemento)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setComplemento', array($complemento));

        return parent::setComplemento($complemento);
    }

    /**
     * {@inheritDoc}
     */
    public function setCodPromocional($codPromocional)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCodPromocional', array($codPromocional));

        return parent::setCodPromocional($codPromocional);
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
