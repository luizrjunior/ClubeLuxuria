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

class IndexController extends AbstractController {
   
    //Variáveis
    private $arrayRandomico;

    public function __construct() {
        $this->service = 'Cliente\Service\ClienteService';
        //$this->idUsuarioPerfil = $this->identity()->getIdUsuario();
        $this->arrayRandomico = array(
            0 => 'A',  1 => '0',  2 =>'a', 3 => 'B',  4 => '1',  5 =>'b', 6 => 'C',  7 => '2',  8 =>'c', 9 => 'D', 10 => '3', 11 =>'d',
           12 => 'E', 13 => '4', 14 =>'e',15 => 'F', 16 => '5', 17 =>'f',18 => 'G', 19 => '6', 20 =>'g',21 => 'H', 22 => '7', 23 =>'h',
           24 => 'I', 25 => '8', 26 =>'i',27 => 'J', 28 => '9', 29 =>'j',30 => 'K', 31 => '0', 32 =>'k',33 => 'L', 34 => '1', 35 =>'l',
           36 => 'M', 37 => '2', 38 =>'m',39 => 'N', 40 => '3', 41 =>'n',42 => 'O', 43 => '4', 44 =>'o',45 => 'P', 46 => '5', 47 =>'p',
           48 => 'Q', 49 => '6', 50 =>'q',51 => 'R', 52 => '7', 53 =>'r',54 => 'S', 55 => '8', 56 =>'s',57 => 'T', 58 => '9', 59 =>'t',
           60 => 'U', 61 => '0', 62 =>'u',63 => 'V', 64 => '1', 65 =>'v',66 => 'W', 67 => '2', 68 =>'w',69 => 'X', 70 => '3', 71 =>'x',
           72 => 'Y', 73 => '4', 74 =>'y',75 => 'Z', 76 => '5', 77 =>'z'
        );//Array de caracteres randômicos
        
        $this->_view = new ViewModel();
    }//__construct

    public function indexAction() {
        //Verificando o Estado que o Usuário se encontra
        $sessao = new Container();        
        
        if (!$sessao->sgUfSessionPsq) {
            return $this->redirect()->toRoute('application');
        }else{
            if(!$this->identity()) {
                //Usuário não está logado
                $sgEstado = $sessao->sgUfSessionPsq;
            }else{
                //Usuário está logado
                $dadosUsuarioLogado = $this->identity();                
                $tpUsuario = $dadosUsuarioLogado->getTpUsuario();//1 - Adm / 2 - Cliente (Acp) / 3 Sócio
                if($tpUsuario == 1){
                    //Administrador - Ver todos os eventos de todos os estados
                    $sgEstado = null;
                }else{
                    $sgEstado = $sessao->sgUfSessionPsq;
                }//if tipo usuario
            }//if / else estado evento pelo tipo de usuário
        }//if sigla estado
                     
        //Buscando a lista de eventos disponíveis
        $agendaEventoEntity = $this->getEm()->getRepository("Agenda\Entity\AgendaEventoEntity");
        $agendaEventoDataEntity = $this->getEm()->getRepository("Agenda\Entity\AgendaEventoDataEntity");
        $agendaEventoFotoEntity = $this->getEm()->getRepository("Agenda\Entity\AgendaEventoFotosEntity");
        
        //Array de Eventos
        $arrayEventos = array();
        
        $listaEventosDisponiveis = $agendaEventoEntity->listaEventosDisponiveis(date('Y-m-d'),$sgEstado);
        foreach ($listaEventosDisponiveis as $dadosEventos) {
            $id = $dadosEventos['idEvento'];
            $titulo = utf8_encode($dadosEventos['txTitulo']);
            $descricao = utf8_encode($dadosEventos['txDescricao']);
            $inicio = $this->_dateToUser($dadosEventos['dtInicial']);
            $fim    = $this->_dateToUser($dadosEventos['dtFinal']);
            $txtId  = $dadosEventos['txtIdEvento'];
            
            //Buscando as datas do evento
            $listaDatasEvento = $agendaEventoDataEntity->listaDatas($id);
            $arrayDatas = array();
            foreach ($listaDatasEvento as $dadosData){
                $arrayDatas []= array(
                    'semana'   => $agendaEventoDataEntity->_ds_dia_semana[$dadosData['diaSemana']],
                    'hora_ini' => $dadosData['hrIni'],
                    'hora_fim' => $dadosData['hrFinal'],
                    'mes'      => $this->_dateToUser($dadosData['dtMes'])
                );//Array de datas
            }//foreach data
            
            //Buscando as fotos relativas ao Evento, quando possuir
            $listaFotosEvento = $agendaEventoFotoEntity->listaFotos($id); 
            $arrayFotos = array();
            foreach ($listaFotosEvento as $dadosFoto){
                //Colocando no array de lista apenas a foto de capa.
                if($dadosFoto['tpFoto']==2){//1 - Foto Normal (NÃO) / 2 - Foto de Capa (SIM)
                    $arrayDatas []= array(
                        'capa'    => $dadosFoto['tpFoto'],
                        'nome'    => $dadosFoto['txPath'],
                        'legenda' => $dadosFoto['txLegenda']
                    );//Array de fotos
                }// foto de capa
            }//foreach fotos
            
            //Array de Evento Completo
            $arrayEventos []= array(
                'id'        => $id,
                'titulo'    => $titulo,
                'descricao' => $descricao,
                'dt_inicial'=> $inicio,
                'dt_final'  => $fim,
                'datas'     => $arrayDatas,
                'fotos'     => $arrayFotos,
                'idTxt'     => $txtId
            );//array de eventos completos            
        }//foreach array de eventos disponíveis
        
        $this->_view->setVariable('arrayEventos',$arrayEventos);
        return $this->_view;
    }//Index

    
    //Cadastrar novo evento
    public function novoEventoAction(){
        $config = $this->getServiceLocator()->get('config');
        
        //Verificando se existem dados via POST
        $post = $this->getRequest()->getPost()->toArray();
        if(empty($post)){
            //Não existe requisição Post
            $sgUfSessionPsq = $config['constsSgUfCad'];        
            $form = new Form\NovoEventoForm($sgUfSessionPsq);
            $this->_view->setVariable('dataForm',$form);
        }else{
            //Formulário já enviado com os dados.
            //Validando os dados
            var_dump($post);
        }//if / else dados via post
        
        
        
        return $this->_view;
    }//novo evento action

    //Fução Ajax para verificar as datas quando cadastrar o evento Novo
    public function verificaDatasJsonAction(){
        //Iniciando as Entities de controle
        $agendaEventoEntity = $this->getEm()->getRepository("Agenda\Entity\AgendaEventoEntity");
        $agendaEventoDataEntity = $this->getEm()->getRepository("Agenda\Entity\AgendaEventoDataEntity");
        $agendaEventoFotoEntity = $this->getEm()->getRepository("Agenda\Entity\AgendaEventoFotosEntity");
        
        //Variáveis de controle
        $erro = 0;
        $msg  = '';        
        $dados = array(); 
        
        //Verificando se existem dados via POST
        $post = $this->getRequest()->getPost()->toArray();
        
        if(!empty($post)){
            //Possui requisição via post
            $dtInicial =  $this->_dateToBD(mysql_escape_string($post['dtInicial']));
            $dtFinal   =  $this->_dateToBD(mysql_escape_string($post['dtFinal']));
                        
            $verifDatas = $this->_diferencaDatas($dtFinal, $dtInicial,'d');//Diferença entra as datas em dias.
            
            if($verifDatas['diferenca'] < 0 && $erro == 0){
                $erro = 1;
                $msg  = 'A data de Término do evento NÃO pode ser maior que a dara de Início. Por favor Verificar';
            }//if diferença datas
            if($verifDatas['diferenca'] > 30 && $erro == 0){
                $erro = 1;
                $msg  = 'O intervalo (período) entre a data de Início e a data de Término do Evento não pode ser superior a 30 dias. Período = '.$verifDatas['diferenca'].' dias';
            }//if intervalo maior que 30 dias
            
            //Retornando o array de intervalo de datas
            if($erro == 0){
                $arrayDatas = $this->_retornaDatasIntervalo($dtInicial, $dtFinal);                
                
                //Percorre o array de datas e coloca as datas em formato Brasileiro
                foreach ($arrayDatas as $data) {
                    //Verifica o dia da semana através da data do mês.
                    $idDiaSemana = date('w', strtotime($data));
                    $textoSemana = $agendaEventoDataEntity->_ds_dia_semana[($idDiaSemana+1)];
                    
                    $dados []= array(
                        'data_mes'   => $this->_dateToUser($data),
                        'data_texto' => $textoSemana.($idDiaSemana !=1 && $idDiaSemana !=7 ? '-Feira' :'')
                    );//array com os dados do  horario
                            
                }//foreach array de datas                
            }//if intervado de datas            
        }//if post
                
       //Retornando dados ao AJAX via Json
        $result = new JsonModel(array(
	    'erro' => $erro,
            'msg'  => $msg,
            'dados'=> $dados
        ));//Json variables 
 
        return $result;
    }//verificar datas
    
    
    //Ver evento Detalhado
    public function verEventoAction(){
        
    }//ver evento action
    
    
    
    
    /****************************************************
     ************ FUNÇÕES INTERNAS para agenda **********
     ****************************************************/
    //Função que retorna um conjunto de caracteres aleatórios para cadastrar no BD como Identificador do Evento
    public function _geraIdRandomico($qdeMin=6,$qdeMax=20){
        $agendaEventoEntity = $this->getEm()->getRepository("Agenda\Entity\AgendaEventoEntity");
        $tamArray = count($this->arrayRandomico);
        $retorno = '';
        
        //Estabelecendo a quantidade de caracteres
        if($qdeMin != $qdeMax){
            $qdeCaracteres = rand($qdeMin, $qdeMax);
        }else{
            $qdeCaracteres = $qdeMax;
        }//if / else qde de caracteres
        
        //Gerando os caracteres aleatórios
        for($i=0;$i<$qdeCaracteres; $i++){
            $retorno .= $this->arrayRandomico[rand(0,$tamArray)];
        }//for gera caracteres
               
        //Verifica no BD se já esxiste este ID Cadastrado
        if($agendaEventoEntity->verificaIDRandomico($retorno)){
            return $retorno;
        }else{
            $this->_geraIdRandomico($qdeMin, $qdeMax);
        }//if / else retorno        
    }//gera Id randômico
    
    
}//Class
