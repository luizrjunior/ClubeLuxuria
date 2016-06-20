<?php

namespace ConfigPaginaCliente\Entity;

use Application\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * ConfigPaginaClienteEntity
 *
 * @ORM\Table(name="tb_config_pagina_cliente", indexes={@ORM\Index(name="fk_tb_config_pagina_cliente_tb_cliente1_idx", columns={"ID_CLIENTE"})})
 * @ORM\Entity(repositoryClass="ConfigPaginaCliente\Entity\Repository\ConfigPaginaClienteRepository")
 */
class ConfigPaginaClienteEntity extends AbstractEntity {
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_CONFIG_PAGINA_CLIENTE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idConfigPaginaCliente;

    /**
     * @var integer
     *
     * @ORM\Column(name="ST_INFO_CLIENTE", type="integer", nullable=false)
     */
    private $stInfoCliente;

    /**
     * @var integer
     *
     * @ORM\Column(name="ST_FRASE_1", type="integer", nullable=false)
     */
    private $stFrase1;

    /**
     * @var integer
     *
     * @ORM\Column(name="ST_FRASE_2", type="integer", nullable=false)
     */
    private $stFrase2;

    /**
     * @var integer
     *
     * @ORM\Column(name="ST_FRASE_3", type="integer", nullable=false)
     */
    private $stFrase3;

    /**
     * @var integer
     *
     * @ORM\Column(name="ST_SERVICO", type="integer", nullable=false)
     */
    private $stServico;

    /**
     * @var integer
     *
     * @ORM\Column(name="ST_ATENDIMENTO", type="integer", nullable=false)
     */
    private $stAtendimento;

    /**
     * @var integer
     *
     * @ORM\Column(name="ST_CARTOES", type="integer", nullable=false)
     */
    private $stCartoes;

    /**
     * @var integer
     *
     * @ORM\Column(name="ST_URL_SITE", type="integer", nullable=false)
     */
    private $stUrlSite;

    /**
     * @var integer
     *
     * @ORM\Column(name="ST_DEPOIMENTOS", type="integer", nullable=false)
     */
    private $stDepoimentos;

    /**
     * @var integer
     *
     * @ORM\Column(name="ST_CACHES", type="integer", nullable=false)
     */
    private $stCaches;

    /**
     * @var integer
     *
     * @ORM\Column(name="ST_VIDEOS", type="integer", nullable=false)
     */
    private $stVideos;

    /**
     * @var integer
     *
     * @ORM\Column(name="ST_ROTA", type="integer", nullable=false)
     */
    private $stRota;

    /**
     * @var \Cliente\Entity\ClienteEntity
     *
     * @ORM\ManyToOne(targetEntity="Cliente\Entity\ClienteEntity")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_CLIENTE", referencedColumnName="ID_CLIENTE")
     * })
     */
    private $idCliente;

    function getIdConfigPaginaCliente() {
        return $this->idConfigPaginaCliente;
    }

    function getStFrase1() {
        return $this->stFrase1;
    }

    function getStFrase2() {
        return $this->stFrase2;
    }

    function getStFrase3() {
        return $this->stFrase3;
    }

    function getStServico() {
        return $this->stServico;
    }

    function getStAtendimento() {
        return $this->stAtendimento;
    }

    function getStCartoes() {
        return $this->stCartoes;
    }

    function getStDepoimentos() {
        return $this->stDepoimentos;
    }

    function getStCaches() {
        return $this->stCaches;
    }

    function getStVideos() {
        return $this->stVideos;
    }

    function getStRota() {
        return $this->stRota;
    }

    function getIdCliente() {
        return $this->idCliente;
    }

    function setIdConfigPaginaCliente($idConfigPaginaCliente) {
        $this->idConfigPaginaCliente = $idConfigPaginaCliente;
    }

    function setStFrase1($stFrase1) {
        $this->stFrase1 = $stFrase1;
    }

    function setStFrase2($stFrase2) {
        $this->stFrase2 = $stFrase2;
    }

    function setStFrase3($stFrase3) {
        $this->stFrase3 = $stFrase3;
    }

    function setStServico($stServico) {
        $this->stServico = $stServico;
    }

    function setStAtendimento($stAtendimento) {
        $this->stAtendimento = $stAtendimento;
    }

    function setStCartoes($stCartoes) {
        $this->stCartoes = $stCartoes;
    }

    function setStDepoimentos($stDepoimentos) {
        $this->stDepoimentos = $stDepoimentos;
    }

    function setStCaches($stCaches) {
        $this->stCaches = $stCaches;
    }

    function setStVideos($stVideos) {
        $this->stVideos = $stVideos;
    }

    function setStRota($stRota) {
        $this->stRota = $stRota;
    }

    function setIdCliente(\Cliente\Entity\ClienteEntity $idCliente) {
        $this->idCliente = $idCliente;
    }

    function getStInfoCliente() {
        return $this->stInfoCliente;
    }

    function setStInfoCliente($stInfoCliente) {
        $this->stInfoCliente = $stInfoCliente;
    }
    
    function getStUrlSite() {
        return $this->stUrlSite;
    }

    function setStUrlSite($stUrlSite) {
        $this->stUrlSite = $stUrlSite;
    }

    /**
     * @param array $options
     */
    public function __construct(Array $options = array()) {
        parent::__construct($options);
    }
}
