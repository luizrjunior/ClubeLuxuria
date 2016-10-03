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

    public function __construct() {
        $this->service = 'Cliente\Service\ClienteService';
        $this->_view = new ViewModel();
    }

    public function indexAction() {
          

        
        
       return $this->_view;
    }//Imdex

}//Class
