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

class IndexController extends AbstractController {
   
    //Variáveis
    private $idUsuarioPerfil;
    private $modelAgenda;

    public function __construct() {
        $this->service = 'Cliente\Service\ClienteService';
        //$this->idUsuarioPerfil = $this->identity()->getIdUsuario();
        $this->_view = new ViewModel();
    }

    public function indexAction() {
        //Buscando a lista de eventos disponíveis
        $agendaEventoEntity = $this->getEm()->getRepository("Agenda\Entity\AgendaEventoEntity");
        
        $listaEventos = $agendaEventoEntity->listaEventos();
        
        echo '<pre/>';
        var_dump($listaEventos);
        exit;
        
        
        return $this->_view;
    }//Imdex

}//Class
