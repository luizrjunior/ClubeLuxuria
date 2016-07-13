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
     * @ORM\Column(name="DS_IDADE", type="string", length=45, nullable=true)
     */
    private $dsIdade;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_APELIDO", type="string", length=45, nullable=true)
     */
    private $dsApelido;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_CABELOS", type="string", length=45, nullable=true)
     */
    private $dsCabelos;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_OLHOS", type="string", length=45, nullable=true)
     */
    private $dsOlhos;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_LABIOS", type="string", length=45, nullable=true)
     */
    private $dsLabios;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_ALTURA", type="string", length=45, nullable=true)
     */
    private $dsAltura;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_PESO", type="string", length=45, nullable=true)
     */
    private $dsPeso;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_BUSTO", type="string", length=45, nullable=true)
     */
    private $dsBusto;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_CINTURA", type="string", length=45, nullable=true)
     */
    private $dsCintura;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_QUADRIL", type="string", length=45, nullable=true)
     */
    private $dsQuadril;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_HOBBY", type="string", length=45, nullable=true)
     */
    private $dsHobby;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_COMIDAS", type="string", length=45, nullable=true)
     */
    private $dsComidas;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_BEBIDAS", type="string", length=45, nullable=true)
     */
    private $dsBebidas;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_FRASE", type="string", length=25, nullable=true)
     */
    private $dsFrase;

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
    
    function getDsIdade() {
        return $this->dsIdade;
    }

    function getDsApelido() {
        return $this->dsApelido;
    }

    function getDsCabelos() {
        return $this->dsCabelos;
    }

    function getDsOlhos() {
        return $this->dsOlhos;
    }

    function getDsLabios() {
        return $this->dsLabios;
    }

    function getDsAltura() {
        return $this->dsAltura;
    }

    function getDsPeso() {
        return $this->dsPeso;
    }

    function getDsBusto() {
        return $this->dsBusto;
    }

    function getDsCintura() {
        return $this->dsCintura;
    }

    function getDsQuadril() {
        return $this->dsQuadril;
    }

    function getDsHobby() {
        return $this->dsHobby;
    }

    function getDsComidas() {
        return $this->dsComidas;
    }

    function getDsBebidas() {
        return $this->dsBebidas;
    }

    function setDsIdade($dsIdade) {
        $this->dsIdade = $dsIdade;
    }

    function setDsApelido($dsApelido) {
        $this->dsApelido = $dsApelido;
    }

    function setDsCabelos($dsCabelos) {
        $this->dsCabelos = $dsCabelos;
    }

    function setDsOlhos($dsOlhos) {
        $this->dsOlhos = $dsOlhos;
    }

    function setDsLabios($dsLabios) {
        $this->dsLabios = $dsLabios;
    }

    function setDsAltura($dsAltura) {
        $this->dsAltura = $dsAltura;
    }

    function setDsPeso($dsPeso) {
        $this->dsPeso = $dsPeso;
    }

    function setDsBusto($dsBusto) {
        $this->dsBusto = $dsBusto;
    }

    function setDsCintura($dsCintura) {
        $this->dsCintura = $dsCintura;
    }

    function setDsQuadril($dsQuadril) {
        $this->dsQuadril = $dsQuadril;
    }

    function setDsHobby($dsHobby) {
        $this->dsHobby = $dsHobby;
    }

    function setDsComidas($dsComidas) {
        $this->dsComidas = $dsComidas;
    }

    function setDsBebidas($dsBebidas) {
        $this->dsBebidas = $dsBebidas;
    }
    
    function getDsFrase() {
        return $this->dsFrase;
    }

    function setDsFrase($dsFrase) {
        $this->dsFrase = $dsFrase;
    }

    /**
     * @param array $options
     */
    public function __construct(Array $options = array()) {
        parent::__construct($options);
    }

}
