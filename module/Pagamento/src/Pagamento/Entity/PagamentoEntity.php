<?php

namespace Pagamento\Entity;

use Application\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * PagamentoEntity
 *
 * @ORM\Table(name="tb_pagamento", indexes={@ORM\Index(name="fk_tb_pagamento_tb_cliente1_idx", columns={"ID_CLIENTE"})})
 * @ORM\Entity(repositoryClass="Pagamento\Entity\Repository\PagamentoRepository")
 */
class PagamentoEntity extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_PAGAMENTO", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPagamento;

    /**
     * @var integer
     *
     * @ORM\Column(name="TP_PAGAMENTO", type="integer", nullable=false)
     */
    private $tpPagamento;

    /**
     * @var integer
     *
     * @ORM\Column(name="TP_ASSINATURA", type="integer", nullable=false)
     */
    private $tpAssinatura;

    /**
     * @var integer
     *
     * @ORM\Column(name="ST_PAGAMENTO", type="integer", nullable=false)
     */
    private $stPagamento;

    /**
     * @var integer
     *
     * @ORM\Column(name="ST_VENCIMENTO", type="integer", nullable=false)
     */
    private $stVencimento;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DT_PAGAMENTO", type="date", nullable=true)
     */
    private $dtPagamento;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DT_CADASTRO", type="date", nullable=false)
     */
    private $dtCadastro;

    /**
     * @var string
     *
     * @ORM\Column(name="VL_PAGAMENTO", type="decimal", precision=12, scale=2, nullable=false)
     */
    private $vlPagamento;

    /**
     * @var string
     *
     * @ORM\Column(name="VL_ANUNCIO_COMUM", type="decimal", precision=12, scale=2, nullable=false)
     */
    private $vlAnuncioComum;

    /**
     * @var string
     *
     * @ORM\Column(name="NO_DEPOSITANTE", type="string", length=125, nullable=true)
     */
    private $noDepositante;

    /**
     * @var string
     *
     * @ORM\Column(name="NU_CPF_DEPOSITANTE", type="string", length=15, nullable=true)
     */
    private $nuCpfDepositante;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DT_DEPOSITO", type="date", nullable=true)
     */
    private $dtDeposito;

    /**
     * @var string
     *
     * @ORM\Column(name="NU_COMPROVANTE", type="string", length=45, nullable=true)
     */
    private $nuComprovante;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_LOCAL_ENTREGA", type="string", length=145, nullable=true)
     */
    private $dsLocalEntrega;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DT_ENTREGA", type="date", nullable=true)
     */
    private $dtEntrega;

    /**
     * @var string
     *
     * @ORM\Column(name="HR_ENTREGA", type="string", length=5, nullable=true)
     */
    private $hrEntrega;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_FALAR_COM", type="string", length=45, nullable=true)
     */
    private $dsFalarCom;

    /**
     * @var string
     *
     * @ORM\Column(name="NU_TELEFONE", type="string", length=10, nullable=true)
     */
    private $nuTelefone;

    /**
     * @var \Cliente\Entity\ClienteEntity
     *
     * @ORM\ManyToOne(targetEntity="Cliente\Entity\ClienteEntity")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_CLIENTE", referencedColumnName="ID_CLIENTE")
     * })
     */
    private $idCliente;
    
    /**
     * @param array $options
     */
    public function __construct(Array $options = array())
    {
        parent::__construct($options);
    }    
    
    function getIdPagamento() {
        return $this->idPagamento;
    }

    function getTpPagamento() {
        return $this->tpPagamento;
    }

    function getStPagamento() {
        return $this->stPagamento;
    }

    function getDtPagamento() {
        return $this->dtPagamento;
    }

    function getVlPagamento() {
        return $this->vlPagamento;
    }

    function getNoDepositante() {
        return $this->noDepositante;
    }

    function getNuCpfDepositante() {
        return $this->nuCpfDepositante;
    }

    function getDtDeposito() {
        return $this->dtDeposito;
    }

    function getNuComprovante() {
        return $this->nuComprovante;
    }

    function getDsLocalEntrega() {
        return $this->dsLocalEntrega;
    }

    function getDtEntrega() {
        return $this->dtEntrega;
    }

    function getHrEntrega() {
        return $this->hrEntrega;
    }

    function getDsFalarCom() {
        return $this->dsFalarCom;
    }

    function getNuTelefone() {
        return $this->nuTelefone;
    }

    function getIdCliente() {
        return $this->idCliente;
    }

    function setIdPagamento($idPagamento) {
        $this->idPagamento = $idPagamento;
    }

    function setTpPagamento($tpPagamento) {
        $this->tpPagamento = $tpPagamento;
    }

    function setStPagamento($stPagamento) {
        $this->stPagamento = $stPagamento;
    }

    function setDtPagamento(\DateTime $dtPagamento) {
        $this->dtPagamento = $dtPagamento;
    }

    function setVlPagamento($vlPagamento) {
        $this->vlPagamento = $vlPagamento;
    }

    function setNoDepositante($noDepositante) {
        $this->noDepositante = $noDepositante;
    }

    function setNuCpfDepositante($nuCpfDepositante) {
        $this->nuCpfDepositante = $nuCpfDepositante;
    }

    function setDtDeposito(\DateTime $dtDeposito) {
        $this->dtDeposito = $dtDeposito;
    }

    function setNuComprovante($nuComprovante) {
        $this->nuComprovante = $nuComprovante;
    }

    function setDsLocalEntrega($dsLocalEntrega) {
        $this->dsLocalEntrega = $dsLocalEntrega;
    }

    function setDtEntrega(\DateTime $dtEntrega) {
        $this->dtEntrega = $dtEntrega;
    }

    function setHrEntrega($hrEntrega) {
        $this->hrEntrega = $hrEntrega;
    }

    function setDsFalarCom($dsFalarCom) {
        $this->dsFalarCom = $dsFalarCom;
    }

    function setNuTelefone($nuTelefone) {
        $this->nuTelefone = $nuTelefone;
    }

    function setIdCliente(\Cliente\Entity\ClienteEntity $idCliente) {
        $this->idCliente = $idCliente;
    }
    
    function getTpAssinatura() {
        return $this->tpAssinatura;
    }

    function setTpAssinatura($tpAssinatura) {
        $this->tpAssinatura = $tpAssinatura;
    }
    
    function getVlAnuncioComum() {
        return $this->vlAnuncioComum;
    }

    function setVlAnuncioComum($vlAnuncioComum) {
        $this->vlAnuncioComum = $vlAnuncioComum;
    }
    
    function getStVencimento() {
        return $this->stVencimento;
    }

    function setStVencimento($stVencimento) {
        $this->stVencimento = $stVencimento;
    }
    
    function getDtCadastro() {
        return $this->dtCadastro;
    }

    function setDtCadastro(\DateTime $dtCadastro) {
        $this->dtCadastro = $dtCadastro;
    }

}