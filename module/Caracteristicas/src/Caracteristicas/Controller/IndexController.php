<?php

namespace Caracteristicas\Controller;

use Application\Controller\AbstractController;
use Caracteristicas\Form as Form;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractController {

    function __construct() {
        $this->service = 'Caracteristicas\Service\CaracteristicasService';
        $this->_view = new ViewModel();
    }

    public function indexAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        
        $this->getEm();
        $config = $this->getServiceLocator()->get('config');

        $tpCaracteristicasCad = $config['constsTpCaracteristicaCad'];
        
        //Instanciar e Setar o Form de Cadastro
        $this->formCadCaracteristica = new Form\CaracteristicaCadForm($tpCaracteristicasCad);
        $this->_view->setVariable('formCadCaracteristica', $this->formCadCaracteristica);
        
        return $this->_view;
    }

    /**
     * Pesquisar Action
     * @return type
     */
    public function pesquisarCaracteristicasAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        $service = $this->getServiceLocator()->get($this->service);
        $pagina = $this->getEvent()->getRouteMatch()->getParam('page');
        $post = $this->getRequest()->getPost()->toArray();
        $itens = $this->itemForPage;
        $this->_view->setVariable('lista', $service->listarCaracteristicasPaginados($post, $pagina, $itens));
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
        $stLogin = $service->verificarCaracteristicaExistente($post['noCaracteristica'], $post['idCaracteristica']);
        if (!$stLogin) {
            $arrCaracteristica = $service->salvarCaracteristica($post);

            if ($arrCaracteristica) {
                $tipoMsg = "S";
                if ($post['idCaracteristica']) {
                    $textoMsg = "Característica atualizada com sucesso!";
                } else {
                    $textoMsg = "Característica cadastrada com sucesso!";
                }
            } else {
                $tipoMsg = "E";
                $textoMsg = "Não foi possível realizar esta operação! Tente mais tarde.";
            }
        } else {
            $tipoMsg = "W";
            $textoMsg = "Característica existente! Por favor informe outro.";
        }

        $dados = array();
        if ($arrCaracteristica) {
            $dados['idCaracteristica'] = $arrCaracteristica->getIdCaracteristica();
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
        $repository = $service->selecionarCaracteristica($id);
        if ($repository) {
            $tipoMsg = "S";
            $textoMsg = "Registro encontrado!";
            $dados = $this->carregarDadosCaracteristica($repository);
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
        if ($post['idCaracteristica'] != 1) {
            $service = $this->getServiceLocator()->get($this->service);
            $repository = $service->selecionarCaracteristica($post['idCaracteristica']);
            if ($repository) {
                if ($service->excluirCaracteristica($repository)) {
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
     * Carregar Dados do Característica
     * @param type $repository
     * @return type
     */
    protected function carregarDadosCaracteristica($repository) {
        $array['idCaracteristica'] = $repository->getIdCaracteristica();
        $array['noCaracteristica'] = $repository->getNoCaracteristica();
        $array['tpCaracteristica'] = $repository->getTpCaracteristica();
        return $array;
    }

}
