<?php

namespace Cidade\Entity;

use Application\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Cidade
 *
 * @ORM\Table(name="tb_cidade")
 * @ORM\Entity(repositoryClass="Cidade\Entity\Repository\CidadeRepository")
 */
class CidadeEntity extends AbstractEntity {

    /**
     * @var integer
     *
     * @ORM\Column(name="ID_CIDADE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCidade;

    /**
     * @var string
     *
     * @ORM\Column(name="SG_UF", type="string", length=2, nullable=false)
     */
    private $sgUf;

    /**
     * @var string
     *
     * @ORM\Column(name="NO_CIDADE", type="string", length=45, nullable=false)
     */
    private $noCidade;

    /**
     * Get idCidade
     *
     * @return integer
     */
    public function getIdCidade() {
        return $this->idCidade;
    }

    /**
     * Set sgUf
     *
     * @param string $sgUf
     *
     * @return \Cidade\Entity\Cidade
     */
    public function setSgUf($sgUf) {
        $this->sgUf = $sgUf;

        return $this;
    }

    /**
     * Get sgUf
     *
     * @return string
     */
    public function getSgUf() {
        return $this->sgUf;
    }

    /**
     * Set noCidade
     * @param string $noCidade
     * @return \Cidade\Entity\Cidade
     */
    public function setNoCidade($noCidade) {
        $this->noCidade = $noCidade;

        return $this;
    }

    /**
     * Get noCidade
     *
     * @return string
     */
    public function getNoCidade() {
        return $this->noCidade;
    }

    /**
     * @param array $options
     */
    public function __construct(Array $options = array()) {
        parent::__construct($options);
    }

}
