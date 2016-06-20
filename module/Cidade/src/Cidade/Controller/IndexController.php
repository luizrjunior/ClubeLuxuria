<?php

namespace Cidade\Controller;

use Application\Controller\AbstractController;
use Cidade\Form as Form;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractController {

    function __construct() {
        $this->service = 'Cidade\Service\CidadeService';
        $this->_view = new ViewModel();
    }

    public function indexAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        
        $this->getEm();
        $config = $this->getServiceLocator()->get('config');

        $sgUfCad = $config['constsSgUfFormCad'];
        
        //Instanciar e Setar o Form de Cadastro
        $this->formCadCidade = new Form\CidadeCadForm($sgUfCad);
        $this->_view->setVariable('formCadCidade', $this->formCadCidade);
        
        return $this->_view;
    }

    /**
     * Pesquisar Action
     * @return type
     */
    public function pesquisarCidadeAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        $service = $this->getServiceLocator()->get($this->service);
        $pagina = $this->getEvent()->getRouteMatch()->getParam('page');
        $post = $this->getRequest()->getPost()->toArray();
        $itens = $this->itemForPage;
        $this->_view->setVariable('lista', $service->listarCidadePaginados($post, $pagina, $itens));
        $this->_view->setTerminal(true);
        return $this->_view;
    }

    /**
     * Salvar Action
     * @return JsonModel
     */
    public function salvarAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        $post = $this->getRequest()->getPost()->toArray();
        $service = $this->getServiceLocator()->get($this->service);
        $stLogin = $service->verificarCidadeExistente($post['noCidade'], $post['idCidade']);
        if (!$stLogin) {
            $arrCidade = $service->salvarCidade($post);

            if ($arrCidade) {
                $tipoMsg = "S";
                if ($post['idCidade']) {
                    $textoMsg = "Cidade atualizada com sucesso!";
                } else {
                    $textoMsg = "Cidade cadastrada com sucesso!";
                }
            } else {
                $tipoMsg = "E";
                $textoMsg = "Não foi possível realizar esta operação! Tente mais tarde.";
            }
        } else {
            $tipoMsg = "W";
            $textoMsg = "Cidade existente! Por favor informe outro.";
        }

        $dados = array();
        if ($arrCidade) {
            $dados['idCidade'] = $arrCidade->getIdCidade();
        }
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;

        $result = new JsonModel($dados);
        return $result;
    }

    /**
     * Selecionar Action
     * @return JsonModel
     */
    public function selecionarAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        $id = $this->getRequest()->getPost()->toArray();
        $service = $this->getServiceLocator()->get($this->service);
        $repository = $service->selecionarCidade($id);
        if ($repository) {
            $tipoMsg = "S";
            $textoMsg = "Registro encontrado!";
            $dados = $this->carregarDadosCidade($repository);
        } else {
            $tipoMsg = "I";
            $textoMsg = "Registro não encontrado!";
            $dados = NULL;
        }
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;
        
        $result = new JsonModel($dados);
        return $result;
    }

    /**
     * Excluir Action
     * @return JsonModel
     */
    public function excluirAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        $post = $this->getRequest()->getPost()->toArray();
        if ($post['idCidade'] != 1) {
            $service = $this->getServiceLocator()->get($this->service);
            $repository = $service->selecionarCidade($post['idCidade']);
            if ($repository) {
                if ($service->excluirCidade($repository)) {
                    $tipoMsg = "S";
                    $textoMsg = "Registro deletado com sucesso!";
                } else {
                    $tipoMsg = "E";
                    $textoMsg = "Não foi possível deletar o registro!";
                }
            } else {
                $tipoMsg = "I";
                $textoMsg = "Registro não foi encontrado!";
            }
        } else {
            $tipoMsg = "I";
            $textoMsg = "Não é possível excluir este usuário por ser o administrador!";
        }

        $dados = array();
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;

        $result = new JsonModel($dados);
        return $result;
    }

    /**
     * Carregar Dados do Cidade
     * @param type $repository
     * @return type
     */
    protected function carregarDadosCidade($repository) {
        $array['idCidade'] = $repository->getIdCidade();
        $array['noCidade'] = $repository->getNoCidade();
        $array['sgUf'] = $repository->getSgUf();
        return $array;
    }

}
