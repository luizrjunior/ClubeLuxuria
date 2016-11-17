<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;

abstract class AbstractController extends AbstractActionController {

    protected $em;
    protected $entity;
    protected $controller;
    protected $route;
    protected $service;
    protected $form;
    protected $itemForPage = 10;
    protected $_view;

    abstract function __construct();

    /**
     * Lista Resultados
     *
     * @return array|ViewModel
     */
    public function indexAction() {
        $list = $this->getEm()->getRepository($this->entity)->findAll();

        $page = $this->params()->fromRoute('page');

        $paginator = new Paginator(new ArrayAdapter($list));
        $paginator->setCurrentPageNumber($page)
                ->setDefaultItemCountPerPage(10);

        if ($this->flashMessenger()->hasSuccessMessages()) {
            return new ViewModel(array(
                'data' => $paginator, 'page' => $page,
                'success' => $this->flashMessenger()->getSuccessMessages()));
        }

        if ($this->flashMessenger()->hasErrorMessages()) {
            return new ViewModel(array(
                'data' => $paginator, 'page' => $page,
                'error' => $this->flashMessenger()->getErrorMessages()));
        }


        return new ViewModel(array('data' => $paginator, 'page' => $page));
    }

    /**
     * Inserir Registro
     */
    public function inserirAction() {
        if (is_string($this->form))
            $form = new $this->form;
        else
            $form = $this->form;

        $request = $this->getRequest();

        if ($request->isPost()) {

            $form->setData($request->getPost());

            if ($form->isValid()) {

                $service = $this->getServiceLocator()->get($this->service);

                if ($service->save($request->getPost()->toArray())) {
                    $this->flashMessenger()->addSuccessMessage('Cadastrado com sucesso!');
                } else {
                    $this->flashMessenger()->addErrorMessage('Não foi possivel cadastrar! Tente mais tarde.');
                }

                return $this->redirect()
                                ->toRoute($this->route, array('controller' => $this->controller, 'action' => 'inserir'));
            }
        }

        if ($this->flashMessenger()->hasSuccessMessages()) {
            return new ViewModel(array(
                'form' => $form,
                'success' => $this->flashMessenger()->getSuccessMessages()));
        }

        if ($this->flashMessenger()->hasErrorMessages()) {
            return new ViewModel(array(
                'form' => $form,
                'error' => $this->flashMessenger()->getErrorMessages()));
        }

        $this->flashMessenger()->clearMessages();

        return new ViewModel(array('form' => $form));
    }

    /**
     * Edita um registro
     */
    public function editarAction() {
        if (is_string($this->form))
            $form = new $this->form;
        else
            $form = $this->form;

        $request = $this->getRequest();
        $param = $this->params()->fromRoute('id', 0);

        $repository = $this->getEm()->getRepository($this->entity)->find($param);

        if ($repository) {

            $array = array();
            foreach ($repository->toArray() as $key => $value) {
                if ($value instanceof \DateTime)
                    $array[$key] = $value->format('d/m/Y');
                else
                    $array[$key] = $value;
            }

            $form->setData($array);

            if ($request->isPost()) {

                $form->setData($request->getPost());

                if ($form->isValid()) {

                    $service = $this->getServiceLocator()->get($this->service);

                    $data = $request->getPost()->toArray();
                    $data['id'] = (int) $param;

                    if ($service->save($data)) {
                        $this->flashMessenger()->addSuccessMessage('Atualizado com sucesso!');
                    } else {
                        $this->flashMessenger()->addErrorMessage('Não foi possivel atualizar! Tente mais tarde.');
                    }

                    return $this->redirect()
                                    ->toRoute($this->route, array('controller' => $this->controller,
                                        'action' => 'editar', 'id' => $param));
                }
            }
        } else {
            $this->flashMessenger()->addInfoMessage('Registro não foi encontrado!');
            return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
        }

        if ($this->flashMessenger()->hasSuccessMessages()) {
            return new ViewModel(array(
                'form' => $form,
                'success' => $this->flashMessenger()->getSuccessMessages(),
                'id' => $param
            ));
        }

        if ($this->flashMessenger()->hasErrorMessages()) {
            return new ViewModel(array(
                'form' => $form,
                'error' => $this->flashMessenger()->getErrorMessages(),
                'id' => $param
            ));
        }

        if ($this->flashMessenger()->hasInfoMessages()) {
            return new ViewModel(array(
                'form' => $form,
                'warning' => $this->flashMessenger()->getInfoMessages(),
                'id' => $param
            ));
        }

        $this->flashMessenger()->clearMessages();

        return new ViewModel(array('form' => $form, 'id' => $param));
    }

    /**
     * Exclui um registro
     *
     * @return \Zend\Http\Response
     */
    public function excluirAction() {
        $service = $this->getServiceLocator()->get($this->service);
        $id = $this->params()->fromRoute('id', 0);

        if ($service->remove(array('id' => $id)))
            $this->flashMessenger()->addSuccessMessage('Resistro deletado com sucesso!');
        else
            $this->flashMessenger()->addErrorMessage('Não foi possivel deletar o registro!');

        return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEm() {
        if ($this->em == null) {
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }

        return $this->em;
    }

    
    /*
     * Funções Internas a todos os Controllers
     */
    //Função _dateDoBD - Recebe a data on formato brasileiro e retorna para o formato do BD.
    //Parâmetro de Entrada: $data em formato (DD/MM/AAAA)
    //Retorno: AAAA-MM-DD  ou  AAAA-MM-DD HH:II:SS
    public function _dateToBD($data,$tpHora=false){
        if($tpHora != false){
            $strData = substr($data,0,10);
            
            $arrayData = explode('/', $strData);
            $hora = ' '.substr($data,10);
        }else{
            $arrayData = explode('/', $data);
            $hora = '';
        }//if / else hora
                
        return $arrayData[2].'-'.$arrayData[1].'-'.$arrayData[0].$hora;
    }//_dateToBD
    
    //Função _dateToUser - Recebe a data direto do BD e retorna no formato Brasileiro
    //Parâmetro de Entrada: $data em formato (AAAA-MM-DD)
    //Retorno: DD/MM/AAAA  ou  DD/MM/AAAA HH:II:SS
    public function _dateToUser($data,$tpHora=false){
        if($tpHora != false){
            $strData = substr($data,0,10);
            
            $arrayData = explode('-', $strData);
            $hora = ' '.substr($data,10);
        }else{
            $arrayData = explode('-', $data);
            $hora = '';
        }//if / else hora
                
        return $arrayData[2].'/'.$arrayData[1].'/'.$arrayData[0].$hora;
    }//_dateToUser

    //Função que retorna a diferença entre duas datas
    //Variáveis da função: 
    //    - $dataMaior - A data FINAL a ser comparada. Formato de entrada: 'AAAA-MM-DD' ou 'AAAA-MM-DD HH:ii:ss'
    //    - $dataMenor - A data INICIAL a ser comparada. Formato de entrada: 'AAAA-MM-DD' ou 'AAAA-MM-DD HH:ii:ss'
    //    - $tipoRetorno - é o retorno que será dado das datas, padrão de retorno em dias (d). 
    //                   -'s' = retorno em segundos / 'i' = retorno em minutos / 'h' = retorno em horas / 'd' = Retorno em dias / 'm' = retorno em meses / 'a' = retorno em anos
    //   ***** OBSERVAÇÃO: O retorno quando for dado em meses é feito o cálculo baseado em 1 mês = 30 dias    
    public function _diferencaDatas($dataMaior,$dataMenor,$tipoRetorno='d'){
        //Variáveis de controle
        $erro = false; //False = Não possui erros / True = Possui erro.
        $msg  = ''; //Mensagem de Erro. Apenas terá conteúdo quando existir o erro ($erro = True).        
        $diferenca = 0;//Diferença entre as duas datas        
        
        //Validando os dados
        if(($dataMaior == '' || $dataMaior == null) && $erro == false){
            $erro = true;
            $msg  = 'Deve ser informado o valor da MAIOR Data.';
        }//if data maior
        if(($dataMenor == '' || $dataMenor == null)  && $erro == false){
            $erro = true;
            $msg  = 'Deve ser informado o valor da MENOR Data.';
        }//if data Menor
        
        //Não contendo erros executa a função
        if($erro == false){
            //Tratando a data maior
            $arrayDataMaior = explode(' ', trim($dataMaior));
            $dataMaiorStr   = $arrayDataMaior[0];
            $dataMaiorHora  = isset($arrayDataMaior[1]) ? $arrayDataMaior[1] : '00:00:00';

            //Tratando a data menor
            $arrayDataMenor = explode(' ', trim($dataMenor));
            $dataMenorStr   = $arrayDataMenor[0];
            $dataMenorHora  = isset($arrayDataMenor[1]) ? $arrayDataMenor[1] : '00:00:00';

            //Array de tipo do retorno
            $retorno = array(
                's' => 1, //segundos
                'i' => 60, //Minutos
                'h' => 3600, //Horas
                'd' => 86400, //dias
                'm' => 2592000, //mês
                'a' => 31104000, //ano
            );//array retorno
            
            $diferenca = round((strtotime($dataMaiorStr.' '.$dataMaiorHora) - strtotime($dataMenorStr.' '.$dataMenorHora)) / $retorno[$tipoRetorno]);
            
            if($diferenca < 0){
                $erro = true;
                $msg  = 'As datas devem estar em ordem contrárias, informe a data MAIOR primeiramente e em seguida a data MENOR.';
            }//if diferença
        }//if função sem erros
        
        //Saída da Função
        return array(
            'erro' => $erro,
            'msg'  => $msg,
            'diferenca' => $diferenca
        );//retornando array de dados
    }//direferença de datas
    
    //Função que retorna todas as datas do Intervalo entre elas
    //Parâmetros:
    //      - $dataInicial : Primeira data a ser listada e retornada no array. Formato: YYYY-MM-DD
    //      - $dataFinal : Última data da lista a ser colocada no array. Array será retornado da data Inicial a Final. Formato: YYYY-MM-DD
    //Retorna um array com as datas desde a data inicial a Final, nesta ordem. arrayRetorno = array(YYYY-MM-DD, YYYY-MM-DD+1, YYYY-MM-DD+2,...)
    public function _retornaDatasIntervalo($dataInicial,$dataFinal){
        $primeiraData = new \DateTime($dataInicial);
        $ultimaData   = new \DateTime($dataFinal);
        
        $arrayDatas = array();//array para guardar o intervalo de datas
        
        //Montando o array de datas
        while($primeiraData <= $ultimaData){
            $arrayDatas []= $primeiraData->format('Y-m-d');
            $primeiraData = $primeiraData->modify('+1day');
        }//while array datas
        
        //Retornando o array com as datas
        return $arrayDatas;
    }//retorno de datas em array
    
}//Classe abstract 