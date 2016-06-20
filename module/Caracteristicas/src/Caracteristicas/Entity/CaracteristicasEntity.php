<?php

namespace Caracteristicas\Entity;

use Application\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * CaracteristicasEntity
 *
 * @ORM\Table(name="tb_caracteristica")
 * @ORM\Entity(repositoryClass="Caracteristicas\Entity\Repository\CaracteristicasRepository")
 */
class CaracteristicasEntity extends AbstractEntity {

    /**
     * @var integer
     *
     * @ORM\Column(name="ID_CARACTERISTICA", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCaracteristica;

    /**
     * @var string
     *
     * @ORM\Column(name="NO_CARACTERISTICA", type="string", length=45, nullable=false)
     */
    private $noCaracteristica;

    /**
     * @var integer
     *
     * @ORM\Column(name="TP_CARACTERISTICA", type="integer", nullable=false)
     */
    private $tpCaracteristica;

    /**
     * Get idCaracteristica
     *
     * @return integer 
     */
    public function getIdCaracteristica() {
        return $this->idCaracteristica;
    }

    /**
     * Set noCaracteristica
     *
     * @param string $noCaracteristica
     * @return CaracteristicaEntity
     */
    public function setNoCaracteristica($noCaracteristica) {
        $this->noCaracteristica = $noCaracteristica;

        return $this;
    }

    /**
     * Get noCaracteristica
     *
     * @return string 
     */
    public function getNoCaracteristica() {
        return $this->noCaracteristica;
    }

    /**
     * Set tpCaracteristica
     *
     * @param integer $tpCaracteristica
     * @return CaracteristicaEntity
     */
    public function setTpCaracteristica($tpCaracteristica) {
        $this->tpCaracteristica = $tpCaracteristica;

        return $this;
    }

    /**
     * Get tpCaracteristica
     *
     * @return integer 
     */
    public function getTpCaracteristica() {
        return $this->tpCaracteristica;
    }

    /**
     * @param array $options
     */
    public function __construct(Array $options = array()) {
        parent::__construct($options);
    }

}
