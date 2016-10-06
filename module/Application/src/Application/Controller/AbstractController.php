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

    
}//Classe abstract 