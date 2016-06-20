<?php

namespace Anunciante\Entity;

use Application\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * AnuncianteEntity
 *
 * @ORM\Table(name="tb_anunciante", indexes={@ORM\Index(name="fk_tb_frases_pagina_cliente_tb_cliente1_idx", columns={"ID_CLIENTE"}), @ORM\Index(name="fk_tb_anunciante_tb_cidade1_idx", columns={"ID_CIDADE"})})
 * @ORM\Entity(repositoryClass="Anunciante\Entity\Repository\AnuncianteRepository")
 */
class AnuncianteEntity extends AbstractEntity {

    /**
     * @var integer
     *
     * @ORM\Column(name="ID_ANUNCIANTE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAnunciante;

    /**
     * @var integer
     *
     * @ORM\Column(name="ST_ANUNCIANTE", type="integer", nullable=true)
     */
    private $stAnunciante;

    /**
     * @var integer
     *
     * @ORM\Column(name="TP_ANUNCIANTE", type="integer", nullable=true)
     */
    private $tpAnunciante;

    /**
     * @var integer
     *
     * @ORM\Column(name="TP_CABELO_COR", type="integer", nullable=true)
     */
    private $tpCabeloCor;

    /**
     * @var integer
     *
     * @ORM\Column(name="ST_ACEITA_CARTAO", type="integer", nullable=true)
     */
    private $stAceitaCartao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DT_ALTERACAO", type="datetime", nullable=true)
     */
    private $dtAlteracao;

    /**
     * @var string
     *
     * @ORM\Column(name="NO_ARTISTICO", type="string", length=45, nullable=true)
     */
    private $noArtistico;

    /**
     * @var string
     *
     * @ORM\Column(name="NU_TELEFONE", type="string", length=45, nullable=true)
     */
    private $nuTelefone;

    /**
     * @var string
     *
     * @ORM\Column(name="NU_LATITUDE", type="string", length=45, nullable=true)
     */
    private $nuLatitude;

    /**
     * @var string
     *
     * @ORM\Column(name="NU_LONGITUDE", type="string", length=45, nullable=true)
     */
    private $nuLongitude;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_FRASE_1", type="string", length=25, nullable=true)
     */
    private $dsFrase1;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_FRASE_2", type="string", length=45, nullable=true)
     */
    private $dsFrase2;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_FRASE_3", type="string", length=255, nullable=true)
     */
    private $dsFrase3;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_URL_SITE", type="string", length=125, nullable=true)
     */
    private $dsUrlSite;

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
     * @var \Cidade\Entity\CidadeEntity
     *
     * @ORM\ManyToOne(targetEntity="Cidade\Entity\CidadeEntity")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_CIDADE", referencedColumnName="ID_CIDADE")
     * })
     */
    private $idCidade;
    
    function getIdAnunciante() {
        return $this->idAnunciante;
    }

    function getStAnunciante() {
        return $this->stAnunciante;
    }

    function getTpAnunciante() {
        return $this->tpAnunciante;
    }

    function getTpCabeloCor() {
        return $this->tpCabeloCor;
    }

    function getStAceitaCartao() {
        return $this->stAceitaCartao;
    }

    function getDtAlteracao() {
        return $this->dtAlteracao;
    }

    function getNoArtistico() {
        return $this->noArtistico;
    }

    function getNuTelefone() {
        return $this->nuTelefone;
    }

    function getNuLatitude() {
        return $this->nuLatitude;
    }

    function getNuLongitude() {
        return $this->nuLongitude;
    }

    function getDsFrase1() {
        return $this->dsFrase1;
    }

    function getDsFrase2() {
        return $this->dsFrase2;
    }

    function getDsFrase3() {
        return $this->dsFrase3;
    }

    function getDsUrlSite() {
        return $this->dsUrlSite;
    }

    function getIdCliente() {
        return $this->idCliente;
    }

    function getIdCidade() {
        return $this->idCidade;
    }

    function setIdAnunciante($idAnunciante) {
        $this->idAnunciante = $idAnunciante;
    }

    function setStAnunciante($stAnunciante) {
        $this->stAnunciante = $stAnunciante;
    }

    function setTpAnunciante($tpAnunciante) {
        $this->tpAnunciante = $tpAnunciante;
    }

    function setTpCabeloCor($tpCabeloCor) {
        $this->tpCabeloCor = $tpCabeloCor;
    }

    function setStAceitaCartao($stAceitaCartao) {
        $this->stAceitaCartao = $stAceitaCartao;
    }

    function setDtAlteracao(\DateTime $dtAlteracao) {
        $this->dtAlteracao = $dtAlteracao;
    }

    function setNoArtistico($noArtistico) {
        $this->noArtistico = $noArtistico;
    }

    function setNuTelefone($nuTelefone) {
        $this->nuTelefone = $nuTelefone;
    }

    function setNuLatitude($nuLatitude) {
        $this->nuLatitude = $nuLatitude;
    }

    function setNuLongitude($nuLongitude) {
        $this->nuLongitude = $nuLongitude;
    }

    function setDsFrase1($dsFrase1) {
        $this->dsFrase1 = $dsFrase1;
    }

    function setDsFrase2($dsFrase2) {
        $this->dsFrase2 = $dsFrase2;
    }

    function setDsFrase3($dsFrase3) {
        $this->dsFrase3 = $dsFrase3;
    }

    function setDsUrlSite($dsUrlSite) {
        $this->dsUrlSite = $dsUrlSite;
    }

    function setIdCliente(\Cliente\Entity\ClienteEntity $idCliente) {
        $this->idCliente = $idCliente;
    }

    function setIdCidade(\Cidade\Entity\CidadeEntity $idCidade) {
        $this->idCidade = $idCidade;
    }
    
    /**
     * @param array $options
     */
    public function __construct(Array $options = array()) {
        parent::__construct($options);
    }

}
