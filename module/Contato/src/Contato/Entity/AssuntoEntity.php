<?php

namespace Contato\Entity;

use Application\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Assunto
 *
 * @ORM\Table(name="tb_assunto")
 * @ORM\Entity(repositoryClass="Contato\Entity\Repository\AssuntoRepository")
 */
class AssuntoEntity extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="ID_ASSUNTO", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idAssunto;

    /**
     * @var integer
     *
     * @ORM\Column(name="STATUS", type="integer")
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="DESCRICAO", type="string")
     */
    private $descricao;

    /**
     * Get idAssunto
     *
     * @return integer 
     */
    public function getIdAssunto()
    {
        return $this->idAssunto;
    }

    /**
     * Get Status
     * @return integer
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Set Status
     * @param type $status
     * @return \Contato\Entity\AssuntoEntity
     */
    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    /**
     * Get Descricao
     * @return string
     */
    public function getDescricao() {
        return $this->descricao;
    }

    /**
     * Set Descricao
     * @param type $descricao
     * @return \Contato\Entity\AssuntoEntity
     */
    public function setDescricao($descricao) {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * @param array $options
     */
    public function __construct(Array $options = array())
    {
        parent::__construct($options);
    }    
    
}