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
use Agenda\Form;

//VALIDATOR
use Zend\Validator\File\Size;
//SESSION
use Zend\Session\Container;

class ConfiguracoesController extends AbstractController {
   
    //Variáveis
    
    public function __construct() {
        $this->service = 'Cliente\Service\ClienteService';
        $this->_view = new ViewModel();
    }//__construct

    public function indexAction() {
        //Verifica se o Usuário está logado
        if(!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        
        //Definindo o tipo do usuario
        $dadosUsuarioLogado = $this->identity();                
        $tpUsuario = $dadosUsuarioLogado->getTpUsuario();//1 - Adm / 2 - Funcionário / 3 - Cliente (Acp) / 4 - Cliente (Sócio)
        if($tpUsuario != 1){
            //Funcionário / Cliente 
            $sgUfEvento = $dadosUsuarioLogado->getSgUf();
        }else{
            //Administrador
            $sgUfEvento = null;
        }//if / else tipo usuario

        $config = $this->getServiceLocator()->get('config');
        $post = $this->getRequest()->getPost()->toArray();
        
        //Buscando a lista de eventos disponíveis
        $agendaEventoEntity = $this->getEm()->getRepository("Agenda\Entity\AgendaEventoEntity");
        $agendaEventoDataEntity = $this->getEm()->getRepository("Agenda\Entity\AgendaEventoDataEntity");
        $agendaEventoFotoEntity = $this->getEm()->getRepository("Agenda\Entity\AgendaEventoFotosEntity");
        
        $usuarioEntity = $this->getEm()->getRepository("Usuario\Entity\UsuarioEntity");
        
        //Faz a busca no sistema dos EVENTOS PENDENTES       
        $arrayEventosPendentes = array();
        $listaEventosPendentes = in_array($tpUsuario, array(3,4)) ?  array() : $agendaEventoEntity->listaEventosPendentes(date('Y-m-d'),$sgUfEvento);
        
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
                    'id_evento'   => $dadosPendentes['txtIdEvento'],
                    'sg_evento'   => $dadosPendentes['sgUf']
                );//Populando array com os eventos
            }//foreach lista eventos pendentes
        }//lista eventos pendentes
        
        //Montando FOrmulário para NOVO EVENTO
        $sgUfSessionPsq = $config['constsSgUfCad'];        
        $form = new Form\NovoEventoForm($sgUfSessionPsq);
        
        
        //Definindo os valores das variáveis e enviando para a view
        $this->_view->setVariable('arrayEventosPendentes',$arrayEventosPendentes);
        $this->_view->setVariable('tpUsuario',$tpUsuario);
        $this->_view->setVariable('dataForm',$form);
        
        return $this->_view;
    }//Index
    
    
}//Class
