<?php

namespace Curtidas\Entity;

use Application\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * TbCurtidas
 *
 * @ORM\Table(name="tb_curtidas", indexes={@ORM\Index(name="fk_tb_cutida_tb_album1_idx", columns={"ID_ALBUM"}), @ORM\Index(name="fk_tb_cutida_tb_foto1_idx", columns={"ID_FOTO"}), @ORM\Index(name="fk_tb_cutida_tb_usuario1_idx", columns={"ID_USUARIO"}), @ORM\Index(name="fk_tb_cutida_tb_comentario1_idx", columns={"ID_COMENTARIO"}), @ORM\Index(name="fk_tb_cutida_tb_cliente1_idx", columns={"ID_CLIENTE"})})
 * @ORM\Entity(repositoryClass="Curtidas\Entity\Repository\CurtidasRepository")
 */
class CurtidasEntity extends AbstractEntity {

    /**
     * @var integer
     *
     * @ORM\Column(name="ID_CURTIDAS", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCurtidas;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DT_HR_CURTIDA", type="datetime", nullable=false)
     */
    private $dtHrCurtida;

    /**
     * @var \AlbumFoto\Entity\AlbumEntity
     *
     * @ORM\ManyToOne(targetEntity="AlbumFoto\Entity\AlbumEntity")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_ALBUM", referencedColumnName="ID_ALBUM")
     * })
     */
    private $idAlbum;

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
     * @var \Comentarios\Entity\ComentarioEntity
     *
     * @ORM\ManyToOne(targetEntity="Comentarios\Entity\ComentarioEntity")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_COMENTARIO", referencedColumnName="ID_COMENTARIO")
     * })
     */
//    private $idComentario;

    /**
     * @var \AlbumFoto\Entity\TbFoto
     *
     * @ORM\ManyToOne(targetEntity="AlbumFoto\Entity\FotoEntity")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_FOTO", referencedColumnName="ID_FOTO")
     * })
     */
    private $idFoto;

    /**
     * @var \Usuario\Entity\UsuarioEntity
     *
     * @ORM\ManyToOne(targetEntity="Usuario\Entity\UsuarioEntity")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_USUARIO", referencedColumnName="ID_USUARIO")
     * })
     */
    private $idUsuario;

    /**
     * @param array $options
     */
    public function __construct(Array $options = array()) {
        parent::__construct($options);
    }
    
    function getIdCurtidas() {
        return $this->idCurtidas;
    }

    function getDtHrCurtida() {
        return $this->dtHrCurtida;
    }

    function getIdAlbum() {
        return $this->idAlbum;
    }

    function getIdCliente() {
        return $this->idCliente;
    }

//    function getIdComentario() {
//        return $this->idComentario;
//    }

    function getIdFoto() {
        return $this->idFoto;
    }

    function getIdUsuario() {
        return $this->idUsuario;
    }

    function setIdCurtidas($idCurtidas) {
        $this->idCurtidas = $idCurtidas;
    }

    function setDtHrCurtida(\DateTime $dtHrCurtida) {
        $this->dtHrCurtida = $dtHrCurtida;
    }

    function setIdAlbum(\AlbumFoto\Entity\AlbumEntity $idAlbum) {
        $this->idAlbum = $idAlbum;
    }

    function setIdCliente(\Cliente\Entity\ClienteEntity $idCliente) {
        $this->idCliente = $idCliente;
    }

//    function setIdComentario(\Comentarios\Entity\ComentarioEntity $idComentario) {
//        $this->idComentario = $idComentario;
//    }

    function setIdFoto(\AlbumFoto\Entity\FotoEntity $idFoto) {
        $this->idFoto = $idFoto;
    }

    function setIdUsuario(\Usuario\Entity\UsuarioEntity $idUsuario) {
        $this->idUsuario = $idUsuario;
    }



}
