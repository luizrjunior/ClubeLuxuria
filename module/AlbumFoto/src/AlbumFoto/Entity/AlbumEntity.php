<?php

namespace AlbumFoto\Entity;

use Application\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * AlbumEntity
 *
 * @ORM\Table(name="tb_album", indexes={@ORM\Index(name="fk_tb_album_tb_cliente1_idx", columns={"ID_CLIENTE"})})
 * @ORM\Entity(repositoryClass="AlbumFoto\Entity\Repository\AlbumRepository")
 */
class AlbumEntity extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_ALBUM", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAlbum;

    /**
     * @var integer
     *
     * @ORM\Column(name="TP_ALBUM", type="integer", nullable=false)
     */
    private $tpAlbum;

    /**
     * @var integer
     *
     * @ORM\Column(name="ST_ALBUM", type="integer", nullable=false)
     */
    private $stAlbum;

    /**
     * @var integer
     *
     * @ORM\Column(name="ST_COMENTARIO", type="integer", nullable=false)
     */
    private $stComentario;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DT_CRIACAO", type="date", nullable=false)
     */
    private $dtCriacao;

    /**
     * @var string
     *
     * @ORM\Column(name="NO_ALBUM", type="string", length=45, nullable=false)
     */
    private $noAlbum;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_ALBUM", type="string", length=255, nullable=true)
     */
    private $dsAlbum;

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
    
    function getIdAlbum() {
        return $this->idAlbum;
    }

    function getTpAlbum() {
        return $this->tpAlbum;
    }

    function getStAlbum() {
        return $this->stAlbum;
    }

    function getStComentario() {
        return $this->stComentario;
    }

    function getDtCriacao() {
        return $this->dtCriacao;
    }

    function getNoAlbum() {
        return $this->noAlbum;
    }

    function getDsAlbum() {
        return $this->dsAlbum;
    }

    function getIdCliente() {
        return $this->idCliente;
    }

    function setIdAlbum($idAlbum) {
        $this->idAlbum = $idAlbum;
    }

    function setTpAlbum($tpAlbum) {
        $this->tpAlbum = $tpAlbum;
    }

    function setStAlbum($stAlbum) {
        $this->stAlbum = $stAlbum;
    }

    function setStComentario($stComentario) {
        $this->stComentario = $stComentario;
    }

    function setDtCriacao(\DateTime $dtCriacao) {
        $this->dtCriacao = $dtCriacao;
    }

    function setNoAlbum($noAlbum) {
        $this->noAlbum = $noAlbum;
    }

    function setDsAlbum($dsAlbum) {
        $this->dsAlbum = $dsAlbum;
    }

    function setIdCliente(\Cliente\Entity\ClienteEntity $idCliente) {
        $this->idCliente = $idCliente;
    }


}
