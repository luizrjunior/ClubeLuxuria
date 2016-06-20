<?php

namespace Cliente\Entity;

use Application\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * ClienteCaracteristicaEntity
 *
 * @ORM\Table(name="tb_cliente_caracteristica", indexes={@ORM\Index(name="fk_tb_cliente_caracteristica_tb_cliente1_idx", columns={"ID_CLIENTE"}), @ORM\Index(name="fk_tb_cliente_caracteristica_tb_caracteristica1_idx", columns={"ID_CARACTERISTICA"})})
 * @ORM\Entity(repositoryClass="Cliente\Entity\Repository\ClienteCaracteristicaRepository")
 */
class ClienteCaracteristicaEntity extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_CLIENTE_CARACTERISTICA", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idClienteCaracteristica;

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
     * @var \Caracteristicas\Entity\CaracteristicasEntity
     *
     * @ORM\ManyToOne(targetEntity="Caracteristicas\Entity\CaracteristicasEntity")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_CARACTERISTICA", referencedColumnName="ID_CARACTERISTICA")
     * })
     */
    private $idCaracteristica;

    /**
     * @var integer
     *
     * @ORM\Column(name="ST_CLIENTE_CARACTERISTICA", type="integer", nullable=false)
     */
    private $stClienteCaracteristica;



    /**
     * Get idClienteCaracteristica
     *
     * @return integer 
     */
    public function getIdClienteCaracteristica()
    {
        return $this->idClienteCaracteristica;
    }

    /**
     * Set idCliente
     *
     * @param \Cliente\Entity\ClienteEntity $idCliente
     * @return ClienteCaracteristicaEntity
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
     * Set idCaracteristica
     *
     * @param \Caracteristicas\Entity\CaracteristicasEntity $idCaracteristica
     * @return ClienteCaracteristicaEntity
     */
    public function setIdCaracteristica(\Caracteristicas\Entity\CaracteristicasEntity $idCaracteristica = null)
    {
        $this->idCaracteristica = $idCaracteristica;
    
        return $this;
    }

    /**
     * Get idCaracteristica
     *
     * @return \Caracteristicas\Entity\CaracteristicaEntity
     */
    public function getIdCaracteristica()
    {
        return $this->idCaracteristica;
    }

    /**
     * Get stClienteCaracteristica
     *
     * @return integer 
     */
    function getStClienteCaracteristica() {
        return $this->stClienteCaracteristica;
    }

    /**
     * Set stClienteCaracteristica
     *
     * @param integer $stClienteCaracteristica
     * @return ClienteCaracteristicaEntity
     */
    function setStClienteCaracteristica($stClienteCaracteristica) {
        $this->stClienteCaracteristica = $stClienteCaracteristica;
    }

    /**
     * @param array $options
     */
    public function __construct(Array $options = array())
    {
        parent::__construct($options);
    }    

}
