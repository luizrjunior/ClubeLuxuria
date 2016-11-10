<?php

namespace Agenda\Controller;

use Application\Controller\AbstractController;

use Usuario\Entity\UsuarioEntity;

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
        
        $usuarioEntity = $this->getEm()->getRepository("Usuario\Entity\UsuarioEntity");
        
        //Faz a busca no sistema dos EVENTOS PENDENTES       
        $arrayEventosPendentes = array();
        $listaEventosPendentes = $agendaEventoEntity->listaEventosPendentes(date('Y-m-d'));
        
        if(count($listaEventosPendentes) >0){
            foreach ($listaEventosPendentes as $dadosPendentes) {            
                //Trata Solicitante
                if($dadosPendentes['idUsuario'] == null || $dadosPendentes['idUsuario'] == ''){
                    $solicitante = 'Usuário Externo';
                }else{
                    $dadosUsuario = $usuarioEntity->selecionarUsuario($dadosPendentes['idUsuario']);
                    $solicitante = utf8_encode($dadosUsuario->getNoUsuario());
                }//if / else solicitante                
               
                //Alimentando o array
                $arrayEventosPendentes []= array(
                    'solicitante' => $solicitante,
                    'titulo'      => utf8_encode($dadosPendentes['txTitulo']),
                    'data_inicio' => $this->_dateToUser($dadosPendentes['dtInicial']),
                    'data_final'  => $this->_dateToUser($dadosPendentes['dtFinal']),
                    'id_evento'   => $dadosPendentes['txtIdEvento']
                );//Populando array com os eventos
            }//foreach lista eventos pendentes
        }//lista eventos pendentes
        
        
        $this->_view->setVariable('arrayEventosPendentes',$arrayEventosPendentes);
        
        return $this->_view;
    }//Index
    
    
}//Class
