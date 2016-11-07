<?php

namespace Agenda\Controller;

use Application\Controller\AbstractController;

//MODEL
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
//FORMS
use ConfigPaginaCliente\Form as ConfigPaginaClienteForms;
use ConfigPaginaPerfil\Form as ConfigPaginaPerfilForms;

//VALIDATOR
use Zend\Validator\File\Size;
//SESSION
use Zend\Session\Container;

class ConfiguracoesController extends AbstractController {
   
    //Variáveis
    private $idUsuarioPerfil;
    private $arrayRandomico;
    private $modelAgenda;

    public function __construct() {
        $this->service = 'Cliente\Service\ClienteService';
               
        $this->_view = new ViewModel();
    }//__construct

    public function indexAction() {
        //Verifica se o Usuário está logado
        if(!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        
        //Buscando a lista de eventos disponíveis
        $agendaEventoEntity = $this->getEm()->getRepository("Agenda\Entity\AgendaEventoEntity");
        $agendaEventoDataEntity = $this->getEm()->getRepository("Agenda\Entity\AgendaEventoDataEntity");
        $agendaEventoFotoEntity = $this->getEm()->getRepository("Agenda\Entity\AgendaEventoFotosEntity");
        
        
        
        
        return $this->_view;
    }//Index
    
    
}//Class
