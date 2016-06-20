<?php

namespace AlbumFoto\Entity;

use Application\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * FotoEntity
 *
 * @ORM\Table(name="tb_foto", indexes={@ORM\Index(name="fk_tb_foto_tb_album1_idx", columns={"ID_ALBUM"})})
 * @ORM\Entity(repositoryClass="AlbumFoto\Entity\Repository\FotoRepository")
 */
class FotoEntity extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_FOTO", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFoto;

    /**
     * @var integer
     *
     * @ORM\Column(name="ST_COMENTARIO", type="integer", nullable=false)
     */
    private $stComentario;

    /**
     * @var integer
     *
     * @ORM\Column(name="ST_FOTO", type="integer", nullable=false)
     */
    private $stFoto;

    /**
     * @var integer
     *
     * @ORM\Column(name="TP_FOTO", type="integer", nullable=false)
     */
    private $tpFoto;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_LEGENDA", type="string", length=135, nullable=true)
     */
    private $dsLegenda;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_ARQUIVO", type="string", length=135, nullable=false)
     */
    private $dsArquivo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DT_CADASTRO", type="date", nullable=false)
     */
    private $dtCadastro;

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
     * @param array $options
     */
    public function __construct(Array $options = array())
    {
        parent::__construct($options);
    }    
    
    function getIdFoto() {
        return $this->idFoto;
    }

    function getStComentario() {
        return $this->stComentario;
    }

    function getStFoto() {
        return $this->stFoto;
    }

    function getTpFoto() {
        return $this->tpFoto;
    }

    function getDsLegenda() {
        return $this->dsLegenda;
    }

    function getDsArquivo() {
        return $this->dsArquivo;
    }

    function getDtCadastro() {
        return $this->dtCadastro;
    }

    function getIdAlbum() {
        return $this->idAlbum;
    }

    function setIdFoto($idFoto) {
        $this->idFoto = $idFoto;
    }

    function setStComentario($stComentario) {
        $this->stComentario = $stComentario;
    }

    function setStFoto($stFoto) {
        $this->stFoto = $stFoto;
    }

    function setTpFoto($tpFoto) {
        $this->tpFoto = $tpFoto;
    }

    function setDsLegenda($dsLegenda) {
        $this->dsLegenda = $dsLegenda;
    }

    function setDsArquivo($dsArquivo) {
        $this->dsArquivo = $dsArquivo;
    }

    function setDtCadastro(\DateTime $dtCadastro) {
        $this->dtCadastro = $dtCadastro;
    }

    function setIdAlbum(\AlbumFoto\Entity\AlbumEntity $idAlbum) {
        $this->idAlbum = $idAlbum;
    }


}