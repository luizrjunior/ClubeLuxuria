<?php

namespace DoctrineORMModule\Proxy\__CG__\Pagamento\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class PagamentoEntity extends \Pagamento\Entity\PagamentoEntity implements \Doctrine\ORM\Proxy\Proxy
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
            return array('__isInitialized__', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'idPagamento', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'tpPlano', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'tpPagamento', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'tpAssinatura', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'stPagamento', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'stVencimento', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'dtPagamento', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'dtCadastro', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'vlPagamento', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'vlTaxaPublicacao', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'vlAnuncioComum', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'noDepositante', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'nuCpfDepositante', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'dtDeposito', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'nuComprovante', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'dsLocalEntrega', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'dtEntrega', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'hrEntrega', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'dsFalarCom', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'nuTelefone', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'idCliente');
        }

        return array('__isInitialized__', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'idPagamento', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'tpPlano', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'tpPagamento', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'tpAssinatura', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'stPagamento', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'stVencimento', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'dtPagamento', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'dtCadastro', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'vlPagamento', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'vlTaxaPublicacao', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'vlAnuncioComum', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'noDepositante', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'nuCpfDepositante', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'dtDeposito', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'nuComprovante', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'dsLocalEntrega', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'dtEntrega', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'hrEntrega', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'dsFalarCom', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'nuTelefone', '' . "\0" . 'Pagamento\\Entity\\PagamentoEntity' . "\0" . 'idCliente');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (PagamentoEntity $proxy) {
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
    public function getIdPagamento()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getIdPagamento();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIdPagamento', array());

        return parent::getIdPagamento();
    }

    /**
     * {@inheritDoc}
     */
    public function getTpPlano()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTpPlano', array());

        return parent::getTpPlano();
    }

    /**
     * {@inheritDoc}
     */
    public function getTpPagamento()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTpPagamento', array());

        return parent::getTpPagamento();
    }

    /**
     * {@inheritDoc}
     */
    public function getStPagamento()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStPagamento', array());

        return parent::getStPagamento();
    }

    /**
     * {@inheritDoc}
     */
    public function getDtPagamento()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDtPagamento', array());

        return parent::getDtPagamento();
    }

    /**
     * {@inheritDoc}
     */
    public function getVlPagamento()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getVlPagamento', array());

        return parent::getVlPagamento();
    }

    /**
     * {@inheritDoc}
     */
    public function getNoDepositante()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNoDepositante', array());

        return parent::getNoDepositante();
    }

    /**
     * {@inheritDoc}
     */
    public function getNuCpfDepositante()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNuCpfDepositante', array());

        return parent::getNuCpfDepositante();
    }

    /**
     * {@inheritDoc}
     */
    public function getDtDeposito()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDtDeposito', array());

        return parent::getDtDeposito();
    }

    /**
     * {@inheritDoc}
     */
    public function getNuComprovante()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNuComprovante', array());

        return parent::getNuComprovante();
    }

    /**
     * {@inheritDoc}
     */
    public function getDsLocalEntrega()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDsLocalEntrega', array());

        return parent::getDsLocalEntrega();
    }

    /**
     * {@inheritDoc}
     */
    public function getDtEntrega()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDtEntrega', array());

        return parent::getDtEntrega();
    }

    /**
     * {@inheritDoc}
     */
    public function getHrEntrega()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getHrEntrega', array());

        return parent::getHrEntrega();
    }

    /**
     * {@inheritDoc}
     */
    public function getDsFalarCom()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDsFalarCom', array());

        return parent::getDsFalarCom();
    }

    /**
     * {@inheritDoc}
     */
    public function getNuTelefone()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNuTelefone', array());

        return parent::getNuTelefone();
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
    public function setIdPagamento($idPagamento)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIdPagamento', array($idPagamento));

        return parent::setIdPagamento($idPagamento);
    }

    /**
     * {@inheritDoc}
     */
    public function setTpPlano($tpPlano)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTpPlano', array($tpPlano));

        return parent::setTpPlano($tpPlano);
    }

    /**
     * {@inheritDoc}
     */
    public function setTpPagamento($tpPagamento)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTpPagamento', array($tpPagamento));

        return parent::setTpPagamento($tpPagamento);
    }

    /**
     * {@inheritDoc}
     */
    public function setStPagamento($stPagamento)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStPagamento', array($stPagamento));

        return parent::setStPagamento($stPagamento);
    }

    /**
     * {@inheritDoc}
     */
    public function setDtPagamento(\DateTime $dtPagamento)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDtPagamento', array($dtPagamento));

        return parent::setDtPagamento($dtPagamento);
    }

    /**
     * {@inheritDoc}
     */
    public function setVlPagamento($vlPagamento)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setVlPagamento', array($vlPagamento));

        return parent::setVlPagamento($vlPagamento);
    }

    /**
     * {@inheritDoc}
     */
    public function setNoDepositante($noDepositante)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNoDepositante', array($noDepositante));

        return parent::setNoDepositante($noDepositante);
    }

    /**
     * {@inheritDoc}
     */
    public function setNuCpfDepositante($nuCpfDepositante)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNuCpfDepositante', array($nuCpfDepositante));

        return parent::setNuCpfDepositante($nuCpfDepositante);
    }

    /**
     * {@inheritDoc}
     */
    public function setDtDeposito(\DateTime $dtDeposito)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDtDeposito', array($dtDeposito));

        return parent::setDtDeposito($dtDeposito);
    }

    /**
     * {@inheritDoc}
     */
    public function setNuComprovante($nuComprovante)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNuComprovante', array($nuComprovante));

        return parent::setNuComprovante($nuComprovante);
    }

    /**
     * {@inheritDoc}
     */
    public function setDsLocalEntrega($dsLocalEntrega)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDsLocalEntrega', array($dsLocalEntrega));

        return parent::setDsLocalEntrega($dsLocalEntrega);
    }

    /**
     * {@inheritDoc}
     */
    public function setDtEntrega(\DateTime $dtEntrega)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDtEntrega', array($dtEntrega));

        return parent::setDtEntrega($dtEntrega);
    }

    /**
     * {@inheritDoc}
     */
    public function setHrEntrega($hrEntrega)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setHrEntrega', array($hrEntrega));

        return parent::setHrEntrega($hrEntrega);
    }

    /**
     * {@inheritDoc}
     */
    public function setDsFalarCom($dsFalarCom)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDsFalarCom', array($dsFalarCom));

        return parent::setDsFalarCom($dsFalarCom);
    }

    /**
     * {@inheritDoc}
     */
    public function setNuTelefone($nuTelefone)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNuTelefone', array($nuTelefone));

        return parent::setNuTelefone($nuTelefone);
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
    public function getTpAssinatura()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTpAssinatura', array());

        return parent::getTpAssinatura();
    }

    /**
     * {@inheritDoc}
     */
    public function setTpAssinatura($tpAssinatura)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTpAssinatura', array($tpAssinatura));

        return parent::setTpAssinatura($tpAssinatura);
    }

    /**
     * {@inheritDoc}
     */
    public function getVlTaxaPublicacao()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getVlTaxaPublicacao', array());

        return parent::getVlTaxaPublicacao();
    }

    /**
     * {@inheritDoc}
     */
    public function getVlAnuncioComum()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getVlAnuncioComum', array());

        return parent::getVlAnuncioComum();
    }

    /**
     * {@inheritDoc}
     */
    public function setVlTaxaPublicacao($vlTaxaPublicacao)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setVlTaxaPublicacao', array($vlTaxaPublicacao));

        return parent::setVlTaxaPublicacao($vlTaxaPublicacao);
    }

    /**
     * {@inheritDoc}
     */
    public function setVlAnuncioComum($vlAnuncioComum)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setVlAnuncioComum', array($vlAnuncioComum));

        return parent::setVlAnuncioComum($vlAnuncioComum);
    }

    /**
     * {@inheritDoc}
     */
    public function getStVencimento()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStVencimento', array());

        return parent::getStVencimento();
    }

    /**
     * {@inheritDoc}
     */
    public function setStVencimento($stVencimento)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStVencimento', array($stVencimento));

        return parent::setStVencimento($stVencimento);
    }

    /**
     * {@inheritDoc}
     */
    public function getDtCadastro()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDtCadastro', array());

        return parent::getDtCadastro();
    }

    /**
     * {@inheritDoc}
     */
    public function setDtCadastro(\DateTime $dtCadastro)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDtCadastro', array($dtCadastro));

        return parent::setDtCadastro($dtCadastro);
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
