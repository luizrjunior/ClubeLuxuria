<?php

namespace Login\Entity;

use Application\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Código Promocional
 *
 * @ORM\Table(name="tb_cod_promocional")
 * @ORM\Entity(repositoryClass="Login\Entity\Repository\CodPromoRepository")
 */
class CodPromoEntity extends AbstractEntity {

    /**
     * @param array $options
     */
    public function __construct(Array $options = array()) {
        parent::__construct($options);
    }

//__construct

    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="ID_COD_PROMO", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idCod;

    /**
     * @var integer
     *
     * @ORM\Column(name="ST_COD", type="integer")
     */
    private $stCod;

    /**
     * @var string
     *
     * @ORM\Column(name="NO_COD", type="string")
     */
    private $noCod;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_COD", type="string")
     */
    private $dsCod;

    /**
     * @var integer
     *
     * @ORM\Column(name="NU_DIAS_CONTRATO", type="integer")
     */
    private $nuDiasContrato;

    /**
     * @var string
     *
     * @ORM\Column(name="DT_EXPIRA", type="string")
     */
    private $dtExpira;

    /**
     * @var integer
     *
     * @ORM\Column(name="QDE_ATUAL", type="integer")
     */
    private $qdAtual;

    /**
     * @var integer
     *
     * @ORM\Column(name="QDE_MAX", type="integer")
     */
    private $qdMax;

    /**
     * @var string
     *
     * @ORM\Column(name="VL_DESCONTO", type="string")
     */
    private $vlDesconto;
    

    //GETTERS AND SETTERS
    function getIdCod() {
        return $this->idCod;
    }

    function getStCod() {
        return $this->stCod;
    }

    function getNoCod() {
        return $this->noCod;
    }

    function getDsCod() {
        return $this->dsCod;
    }

    function getNuDiasContrato() {
        return $this->nuDiasContrato;
    }

    function getDtExpira() {
        return $this->dtExpira;
    }

    function getQdAtual() {
        return $this->qdAtual;
    }

    function getQdMax() {
        return $this->qdMax;
    }

    function getVlDesconto() {
        return $this->vlDesconto;
    }

    
    
    
    function setIdCod($idCod) {
        $this->idCod = $idCod;
    }

    function setStCod($stCod) {
        $this->stCod = $stCod;
    }

    function setNoCod($noCod) {
        $this->noCod = $noCod;
    }

    function setDsCod($dsCod) {
        $this->dsCod = $dsCod;
    }

    function setNuDiasContrato($nuDiasContrato) {
        $this->nuDiasContrato = $nuDiasContrato;
    }

    function setDtExpira($dtExpita) {
        $this->dtExpira = $dtExpita;
    }

    function setQdAtual($qdAtual) {
        $this->qdAtual = $qdAtual;
    }

    function setQdMax($qdMax) {
        $this->qdMax = $qdMax;
    }

    function setVlDesconto($vlDesconto) {
        $this->vlDesconto = $vlDesconto;
    }


}//CodPromoEntity