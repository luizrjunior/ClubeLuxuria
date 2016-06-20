<?php

namespace Cliente\Entity;

use Application\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * ClienteUsuarioEntity
 *
 * @ORM\Table(name="tb_cliente_usuario", indexes={@ORM\Index(name="fk_tb_cliente_usuario_tb_cliente1_idx", columns={"ID_CLIENTE"}), @ORM\Index(name="fk_tb_cliente_usuario_tb_usuario1_idx", columns={"ID_USUARIO"})})
 * @ORM\Entity(repositoryClass="Cliente\Entity\Repository\ClienteUsuarioRepository")
 */
class ClienteUsuarioEntity extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_CLIENTE_USUARIO", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idClienteUsuario;

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
     * Get idClienteUsuario
     *
     * @return integer
     */
    public function getIdClienteUsuario()
    {
        return $this->idClienteUsuario;
    }

    /**
     * Set idCliente
     *
     * @param \Cliente\Entity\ClienteEntity $idCliente
     *
     * @return ClienteUsuario
     */
    public function setIdCliente(\Cliente\Entity\ClienteEntity $idCliente = null)
    {
        $this->idCliente = $idCliente;
    
        return $this;
    }

    /**
     * Get idCliente
     *
     * @return \Cliente\Entity\ClienteEntity
     */
    public function getIdCliente()
    {
        return $this->idCliente;
    }

    /**
     * Set idUsuario
     *
     * @param \Usuario\Entity\UsuarioEntity $idUsuario
     *
     * @return ClienteUsuario
     */
    public function setIdUsuario(\Usuario\Entity\UsuarioEntity $idUsuario = null)
    {
        $this->idUsuario = $idUsuario;
    
        return $this;
    }

    /**
     * Get idUsuario
     *
     * @return \Usuario\Entity\UsuarioEntity
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }
    
    /**
     * @param array $options
     */
    public function __construct(Array $options = array())
    {
        parent::__construct($options);
    }    
}
