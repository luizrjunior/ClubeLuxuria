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
        $agendaEventoDataEntity = $this->getEm()->getRepository("Agenda\Entity\AgendaEventoDataEntity");
        $agendaEventoFotoEntity = $this->getEm()->getRepository("Agenda\Entity\AgendaEventoFotosEntity");
        
        //Array de Eventos
        $arrayEventos = array();
        
        $listaEventosDisponiveis = $agendaEventoEntity->listaEventos(date('Y-m-d'));
        foreach ($listaEventosDisponiveis as $dadosEventos) {
            $id = $dadosEventos['idEvento'];
            $titulo = utf8_encode($dadosEventos['txTitulo']);
            $descricao = utf8_encode($dadosEventos['txDescricao']);
            $inicio = $this->_dateToUser($dadosEventos['dtInicial']);
            $fim    = $this->_dateToUser($dadosEventos['dtFinal']);
            
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
                'fotos'     => $arrayFotos
            );//array de eventos completos            
        }//foreach array de eventos disponíveis

        $this->_view->setVariable('arrayEventos',$arrayEventos);
        return $this->_view;
    }//Index

}//Class
