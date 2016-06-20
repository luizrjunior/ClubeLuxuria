<?php

namespace Visualizacao\Entity;

use Application\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * VisualizacaoEntity
 *
 * @ORM\Table(name="tb_visualizacao", indexes={@ORM\Index(name="fk_tb_visualizacao_tb_usuario1_idx", columns={"ID_USUARIO"}), @ORM\Index(name="fk_tb_visualizacao_tb_cliente1_idx", columns={"ID_CLIENTE"})})
 * @ORM\Entity(repositoryClass="Visualizacao\Entity\Repository\VisualizacaoRepository")
 */
class VisualizacaoEntity extends AbstractEntity {

    /**
     * @var integer
     *
     * @ORM\Column(name="ID_VISUALIZACAO", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idVisualizacao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DT_HR_VISUALIZACAO", type="datetime", nullable=false)
     */
    private $dtHrVisualizacao;

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

    function getIdVisualizacao() {
        return $this->idVisualizacao;
    }

    function getDtHrVisualizacao() {
        return $this->dtHrVisualizacao;
    }

    function getIdCliente() {
        return $this->idCliente;
    }

    function getIdUsuario() {
        return $this->idUsuario;
    }

    function setIdVisualizacao($idVisualizacao) {
        $this->idVisualizacao = $idVisualizacao;
    }

    function setDtHrVisualizacao(\DateTime $dtHrVisualizacao) {
        $this->dtHrVisualizacao = $dtHrVisualizacao;
    }

    function setIdCliente(\Cliente\Entity\ClienteEntity $idCliente) {
        $this->idCliente = $idCliente;
    }

    function setIdUsuario(\Usuario\Entity\UsuarioEntity $idUsuario) {
        $this->idUsuario = $idUsuario;
    }

}
