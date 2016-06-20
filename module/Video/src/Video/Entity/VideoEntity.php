<?php

namespace Video\Entity;

use Application\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * VideoEntity
 *
 * @ORM\Table(name="tb_video", indexes={@ORM\Index(name="fk_tb_video_tb_cliente1_idx", columns={"ID_CLIENTE"})})
 * @ORM\Entity(repositoryClass="Video\Entity\Repository\VideoRepository")
 */
class VideoEntity extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_VIDEO", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idVideo;

    /**
     * @var integer
     *
     * @ORM\Column(name="TP_VIDEO", type="integer", nullable=false)
     */
    private $tpVideo;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_VIDEO", type="string", length=135, nullable=false)
     */
    private $dsVideo;

    /**
     * @var string
     *
     * @ORM\Column(name="TI_VIDEO", type="string", length=135, nullable=false)
     */
    private $tiVideo;

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
    
    function getIdVideo() {
        return $this->idVideo;
    }

    function getTpVideo() {
        return $this->tpVideo;
    }

    function getDsVideo() {
        return $this->dsVideo;
    }

    function getIdCliente() {
        return $this->idCliente;
    }

    function setIdVideo($idVideo) {
        $this->idVideo = $idVideo;
    }

    function setTpVideo($tpVideo) {
        $this->tpVideo = $tpVideo;
    }

    function setDsVideo($dsVideo) {
        $this->dsVideo = $dsVideo;
    }

    function setIdCliente(\Cliente\Entity\ClienteEntity $idCliente) {
        $this->idCliente = $idCliente;
    }
    
    function getTiVideo() {
        return $this->tiVideo;
    }

    function setTiVideo($tiVideo) {
        $this->tiVideo = $tiVideo;
    }

}
