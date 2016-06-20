<?php

namespace Depoimento\Entity;

use Application\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * DepoimentoEntity
 *
 * @ORM\Table(name="tb_depoimento", indexes={@ORM\Index(name="fk_tb_depoimento_tb_cliente1_idx", columns={"ID_CLIENTE"}), @ORM\Index(name="fk_tb_depoimento_tb_usuario1_idx", columns={"ID_USUARIO"})})
 * @ORM\Entity(repositoryClass="Depoimento\Entity\Repository\DepoimentoRepository")
 */
class DepoimentoEntity extends AbstractEntity {

    /**
     * @var integer
     *
     * @ORM\Column(name="ID_DEPOIMENTO", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idDepoimento;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DT_HR_DEPOIMENTO", type="datetime", nullable=false)
     */
    private $dtHrDepoimento;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_DEPOIMENTO", type="string", length=125, nullable=false)
     */
    private $dsDepoimento;

    /**
     * @var string
     *
     * @ORM\Column(name="ST_DEPOIMENTO", type="string", length=45, nullable=false)
     */
    private $stDepoimento;

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

    function getIdDepoimento() {
        return $this->idDepoimento;
    }

    function getDsDepoimento() {
        return $this->dsDepoimento;
    }

    function getStDepoimento() {
        return $this->stDepoimento;
    }

    function getIdCliente() {
        return $this->idCliente;
    }

    function getIdUsuario() {
        return $this->idUsuario;
    }

    function setIdDepoimento($idDepoimento) {
        $this->idDepoimento = $idDepoimento;
    }

    function setDsDepoimento($dsDepoimento) {
        $this->dsDepoimento = $dsDepoimento;
    }

    function setStDepoimento($stDepoimento) {
        $this->stDepoimento = $stDepoimento;
    }

    function setIdCliente(\Cliente\Entity\ClienteEntity $idCliente) {
        $this->idCliente = $idCliente;
    }

    function setIdUsuario(\Usuario\Entity\UsuarioEntity $idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    function getDtHrDepoimento() {
        return $this->dtHrDepoimento;
    }

    function setDtHrDepoimento(\DateTime $dtHrDepoimento) {
        $this->dtHrDepoimento = $dtHrDepoimento;
    }

}
