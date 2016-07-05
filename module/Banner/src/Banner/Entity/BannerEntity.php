<?php

namespace Banner\Entity;

use Application\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * BannerEntity
 *
 * @ORM\Table(name="tb_banner", indexes={@ORM\Index(name="fk_tb_banner_tb_cliente1_idx", columns={"ID_CLIENTE"})})
 * @ORM\Entity(repositoryClass="Banner\Entity\Repository\BannerRepository")
 */
class BannerEntity extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_BANNER", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idBanner;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ST_BANNER", type="integer", nullable=false)
     */
    private $stBanner;

    /**
     * @var boolean
     *
     * @ORM\Column(name="TP_BANNER", type="integer", nullable=false)
     */
    private $tpBanner;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DT_INICIO", type="date", nullable=false)
     */
    private $dtInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DT_FIM", type="date", nullable=false)
     */
    private $dtFim;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_BANNER", type="text", nullable=true)
     */
    private $dsBanner;

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
    
    function getIdBanner() {
        return $this->idBanner;
    }

    function getStBanner() {
        return $this->stBanner;
    }

    function getTpBanner() {
        return $this->tpBanner;
    }

    function getDtInicio() {
        return $this->dtInicio;
    }

    function getDtFim() {
        return $this->dtFim;
    }

    function getDsBanner() {
        return $this->dsBanner;
    }

    function getIdCliente() {
        return $this->idCliente;
    }

    function setIdBanner($idBanner) {
        $this->idBanner = $idBanner;
    }

    function setStBanner($stBanner) {
        $this->stBanner = $stBanner;
    }

    function setTpBanner($tpBanner) {
        $this->tpBanner = $tpBanner;
    }

    function setDtInicio(\DateTime $dtInicio) {
        $this->dtInicio = $dtInicio;
    }

    function setDtFim(\DateTime $dtFim) {
        $this->dtFim = $dtFim;
    }

    function setDsBanner($dsBanner) {
        $this->dsBanner = $dsBanner;
    }

    function setIdCliente(\Cliente\Entity\ClienteEntity $idCliente) {
        $this->idCliente = $idCliente;
    }

}