<?php

namespace Favoritos\Entity;

use Application\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * FavoritosEntity
 *
 * @ORM\Table(name="tb_favoritos", indexes={@ORM\Index(name="fk_tb_favoritos_tb_usuario1_idx", columns={"ID_USUARIO"}), @ORM\Index(name="fk_tb_favoritos_tb_anunciante1_idx", columns={"ID_ANUNCIANTE"})})
 * @ORM\Entity(repositoryClass="Favoritos\Entity\Repository\FavoritosRepository")
 */
class FavoritosEntity extends AbstractEntity {

    /**
     * @var integer
     *
     * @ORM\Column(name="ID_FAVORITOS", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFavoritos;

    /**
     * @var integer
     *
     * @ORM\Column(name="ST_NOTIFICACAO", type="integer", nullable=true)
     */
    private $stNotificacao;

    /**
     * @var \Anunciante\Entity\AnuncianteEntity
     *
     * @ORM\ManyToOne(targetEntity="Anunciante\Entity\AnuncianteEntity")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_ANUNCIANTE", referencedColumnName="ID_ANUNCIANTE")
     * })
     */
    private $idAnunciante;

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

    function getIdFavoritos() {
        return $this->idFavoritos;
    }

    function getStNotificacao() {
        return $this->stNotificacao;
    }

    function getIdAnunciante() {
        return $this->idAnunciante;
    }

    function getIdUsuario() {
        return $this->idUsuario;
    }

    function setIdFavoritos($idFavoritos) {
        $this->idFavoritos = $idFavoritos;
    }

    function setStNotificacao($stNotificacao) {
        $this->stNotificacao = $stNotificacao;
    }

    function setIdAnunciante(\Anunciante\Entity\AnuncianteEntity $idAnunciante) {
        $this->idAnunciante = $idAnunciante;
    }

    function setIdUsuario(\Usuario\Entity\UsuarioEntity $idUsuario) {
        $this->idUsuario = $idUsuario;
    }

}
