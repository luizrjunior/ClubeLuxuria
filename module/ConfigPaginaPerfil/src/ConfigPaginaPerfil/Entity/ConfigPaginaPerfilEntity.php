<?php

namespace ConfigPaginaPerfil\Entity;

use Application\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * ConfigPaginaPerfilEntity
 *
 * @ORM\Table(name="tb_config_pagina_perfil", indexes={@ORM\Index(name="fk_tb_config_pagina_perfil_tb_usuario1_idx", columns={"ID_USUARIO"})})
 * @ORM\Entity(repositoryClass="ConfigPaginaPerfil\Entity\Repository\ConfigPaginaPerfilRepository")
 */
class ConfigPaginaPerfilEntity extends AbstractEntity {
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_CONFIG_PAGINA_PERFIL", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idConfigPaginaPerfil;

    /**
     * @var integer
     *
     * @ORM\Column(name="ST_INFO_USUARIO", type="integer", nullable=false)
     */
    private $stInfoUsuario;

    /**
     * @var integer
     *
     * @ORM\Column(name="ST_BANNER_PRINCIPAL", type="integer", nullable=false)
     */
    private $stBannerPrincipal;

    /**
     * @var integer
     *
     * @ORM\Column(name="ST_MINHAS_FAVORITAS", type="integer", nullable=false)
     */
    private $stMinhasFavoritas;

    /**
     * @var integer
     *
     * @ORM\Column(name="ST_DESTAQUES", type="integer", nullable=false)
     */
    private $stDestaques;

    /**
     * @var integer
     *
     * @ORM\Column(name="TP_PLANO_FUNDO", type="integer", nullable=false)
     */
    private $tpPlanoFundo;

    /**
     * @var \Usuario\Entity\UsuarioEntity
     *
     * @ORM\ManyToOne(targetEntity="Usuario\Entity\UsuarioEntity")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_USUARIO", referencedColumnName="ID_USUARIO")
     * })
     */
    private $idUsuario;

    function getIdConfigPaginaPerfil() {
        return $this->idConfigPaginaPerfil;
    }

    function getStBannerPrincipal() {
        return $this->stBannerPrincipal;
    }

    function getStMinhasFavoritas() {
        return $this->stMinhasFavoritas;
    }

    function getStDestaques() {
        return $this->stDestaques;
    }

    function getIdUsuario() {
        return $this->idUsuario;
    }

    function getStInfoUsuario() {
        return $this->stInfoUsuario;
    }

    function getTpPlanoFundo() {
        return $this->tpPlanoFundo;
    }

    function setIdConfigPaginaPerfil($idConfigPaginaPerfil) {
        $this->idConfigPaginaPerfil = $idConfigPaginaPerfil;
    }

    function setStBannerPrincipal($stBannerPrincipal) {
        $this->stBannerPrincipal = $stBannerPrincipal;
    }

    function setStMinhasFavoritas($stMinhasFavoritas) {
        $this->stMinhasFavoritas = $stMinhasFavoritas;
    }

    function setStDestaques($stDestaques) {
        $this->stDestaques = $stDestaques;
    }

    function setIdUsuario(\Usuario\Entity\UsuarioEntity $idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    function setStInfoUsuario($stInfoUsuario) {
        $this->stInfoUsuario = $stInfoUsuario;
    }
    
    function setTpPlanoFundo($tpPlanoFundo) {
        $this->tpPlanoFundo = $tpPlanoFundo;
    }
        
    /**
     * @param array $options
     */
    public function __construct(Array $options = array()) {
        parent::__construct($options);
    }
}
