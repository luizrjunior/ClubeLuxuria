<?php

namespace Agenda\Entity;

use Application\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Agenda de Eventos
 *
 * @ORM\Table(name="tb_agenda_eventos_data")
 * @ORM\Entity(repositoryClass="Agenda\Entity\Repository\AgendaEventoDataRepository")
 */
class AgendaEventoDataEntity extends AbstractEntity {

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
     * @ORM\Column(name="PK_ID_DATA", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idData;

    /**
     * @var integer
     *
     * @ORM\Column(name="FK_ID_EVENTO", type="integer")
     */
    private $fkIdEventoData;

    /**
     * @var integer
     *
     * @ORM\Column(name="IN_DIA_SEMANA", type="integer")
     * 
     * 1 - Domingo; 2 - Segunda; 3 - Terça; 4 - Quarta; 5 - Quinta; 6 - Sexta; 7 - Sábado;
     */
    private $diaSemana;

    /**
     * @var string
     *
     * @ORM\Column(name="DT_MES", type="string")
     * 
     * Dia do Mês
     */
    private $dtMes;

    /**
     * @var string
     *
     * @ORM\Column(name="HR_INICIAL", type="string")
     * 
     * Hora Inicial do Evento
     */
    private $hrIni;
    
    /**
     * @var string
     *
     * @ORM\Column(name="HR_FINAL", type="string")
     * 
     * Hora Final do Evento
     */
    private $hrFinal;
    
    //Get and Setters
    function getIdData() {
        return $this->idData;
    }

    function getFkIdEventoData() {
        return $this->fkIdEventoData;
    }

    function getDiaSemana() {
        return $this->diaSemana;
    }

    function getDtMes() {
        return $this->dtMes;
    }

    function getHrIni() {
        return $this->hrIni;
    }

    function getHrFinal() {
        return $this->hrFinal;
    }

    function setIdData($idData) {
        $this->idData = $idData;
    }

    function setFkIdEventoData($fkIdEventoData) {
        $this->fkIdEventoData = $fkIdEventoData;
    }

    function setDiaSemana($diaSemana) {
        $this->diaSemana = $diaSemana;
    }

    function setDtMes($dtMes) {
        $this->dtMes = $dtMes;
    }

    function setHrIni($hrIni) {
        $this->hrIni = $hrIni;
    }

    function setHrFinal($hrFinal) {
        $this->hrFinal = $hrFinal;
    }



}//AgendaEventoDataEntity