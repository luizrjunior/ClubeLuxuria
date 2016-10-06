<?php

namespace Agenda\Entity;

use Application\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Agenda de Eventos
 *
 * @ORM\Table(name="tb_agenda_eventos_fotos")
 * @ORM\Entity(repositoryClass="Agenda\Entity\Repository\AgendaEventoFotoRepository")
 */
class AgendaEventoFotosEntity extends AbstractEntity {

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
     * @ORM\Column(name="PK_ID_FOTO", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idFoto;

    /**
     * @var integer
     *
     * @ORM\Column(name="FK_ID_EVENTO", type="integer")
     */
    private $fkIdEvento;

    /**
     * @var integer
     *
     * @ORM\Column(name="IN_TP_FOTO", type="integer")
     * 
     * 1 - Normal / 2 - Foto de Capa
     */
    private $tpFoto;

    /**
     * @var string
     *
     * @ORM\Column(name="TX_PATH", type="string")
     * 
     * Caminho da Foto
     */
    private $txPath;

    /**
     * @var string
     *
     * @ORM\Column(name="TX_LEGENDA", type="string")
     * 
     * Legenda da Foto
     */
    private $txLegenda;
    
    function getIdFoto() {
        return $this->idFoto;
    }

    function getFkIdEvento() {
        return $this->fkIdEvento;
    }

    function getTpFoto() {
        return $this->tpFoto;
    }

    function getTxPath() {
        return $this->txPath;
    }

    function getTxLegenda() {
        return $this->txLegenda;
    }

    function setIdFoto($idFoto) {
        $this->idFoto = $idFoto;
    }

    function setFkIdEvento($fkIdEvento) {
        $this->fkIdEvento = $fkIdEvento;
    }

    function setTpFoto($tpFoto) {
        $this->tpFoto = $tpFoto;
    }

    function setTxPath($txPath) {
        $this->txPath = $txPath;
    }

    function setTxLegenda($txLegenda) {
        $this->txLegenda = $txLegenda;
    }



}//AgendaEventoFotosEntity