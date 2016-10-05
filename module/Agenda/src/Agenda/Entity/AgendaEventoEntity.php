<?php

namespace Agenda\Entity;

use Application\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Agenda de Eventos
 *
 * @ORM\Table(name="tb_agenda_eventos")
 * @ORM\Entity(repositoryClass="Agenda\Entity\Repository\AgendaEventoRepository")
 */
class AgendaEventoEntity extends AbstractEntity {

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
     * @ORM\Column(name="PK_ID_EVENTO", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idEvento;

    /**
     * @var integer
     *
     * @ORM\Column(name="FK_ID_USUARIO", type="integer")
     */
    private $idUsuario;

    /**
     * @var integer
     *
     * @ORM\Column(name="IN_ST_DISPONIVEL", type="integer")
     * 
     * 1 - Não Publicado / 2 - Publicado
     */
    private $stDisp;

    /**
     * @var string
     *
     * @ORM\Column(name="TX_TITULO", type="string")
     */
    private $txTitulo;

    /**
     * @var string
     *
     * @ORM\Column(name="TX_DESC", type="string")
     */
    private $txDescricao;

    function getIdEvento() {
        return $this->idEvento;
    }

    function getIdUsuario() {
        return $this->idUsuario;
    }

    function getStDisp() {
        return $this->stDisp;
    }

    function getTxTitulo() {
        return $this->txTitulo;
    }

    function getTxDescricao() {
        return $this->txDescricao;
    }

    function setIdEvento($idEvento) {
        $this->idEvento = $idEvento;
    }

    function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    function setStDisp($stDisp) {
        $this->stDisp = $stDisp;
    }

    function setTxTitulo($txTitulo) {
        $this->txTitulo = $txTitulo;
    }

    function setTxDescricao($txDescricao) {
        $this->txDescricao = $txDescricao;
    }

}//AgendaEntity