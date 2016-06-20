<?php

namespace Cache\Controller;

use Application\Controller\AbstractController;
use Cache\Form as CacheForms;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Session\Container;

class IndexController extends AbstractController {

    private $formPsq;
    private $formCad;

    public function __construct() {
        $this->service = 'Cache\Service\CacheService';
        $this->_view = new ViewModel();
    }

    public function indexAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        // Instanciando a sessão
        $sessao = new Container();
        $this->_view->setVariable('idCliente', $sessao->idCliente);

        //Formulario de Pesquisa de Valor Caches
        $this->formPsq = new CacheForms\CachePsqForm();
        $this->_view->setVariable('formPsq', $this->formPsq);

        //Formulario de Cadastro de Valor Cache
        $this->formCad = new CacheForms\CacheCadForm();
        $this->_view->setVariable('formCad', $this->formCad);

        return $this->_view;
    }

    /**
     * Pesquisar Action
     * @return type
     */
    public function pesquisarCacheAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        $service = $this->getServiceLocator()->get($this->service);
        $pagina = $this->getEvent()->getRouteMatch()->getParam('page');
        $post = $this->getRequest()->getPost()->toArray();
        $post['idClientePsq'] = $post['idClientePsqCache'];
        unset($post['idClientePsqCache']);
        $itens = $this->itemForPage;

        $this->_view->setVariable('lista', $service->listarCachesPaginado($post, $pagina, $itens));
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
        $param = array('idCache' => $post['idCache'], 'noCache' => $post['noCache'], 'idCliente' => $post['idClienteCache']);
        $stNome = $service->verificarNomeExistente($param);
        if (!$stNome) {
            $post['idCliente'] = $post['idClienteCache'];
            $arrCache = $service->salvarCache($post);
            if ($arrCache) {
                $tipoMsg = "S";
                $textoMsg = $this->exibeMsgSalvar($post['idCache']);
            } else {
                $tipoMsg = "E";
                $textoMsg = "Erro ao tentar cadastrar o Valor do Cachê! Tente mais tarde.";
            }
        } else {
            $tipoMsg = "W";
            $textoMsg = "Nome do Valor do Cachê existente! Por favor informe outro.";
        }
        $dados = array();
        if ($arrCache) {
            $dados['idCache'] = $arrCache->getIdCache();
        }
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;

        $result = new JsonModel($dados);
        return $result;
    }

    private function exibeMsgSalvar($idCache) {
        if ($idCache) {
            $textoMsg = "Cachê atualizado com sucesso!";
        } else {
            $textoMsg = "Cachê cadastrado com sucesso!";
        }
        return $textoMsg;
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
        $repository = $service->selecionarCache($id);
        if ($repository) {
            $tipoMsg = "S";
            $textoMsg = "Registro encontrado!";
            $dados = $this->carregarDados($repository);
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
     * Carregar Dados do Valor do Cache
     * @param type $repository
     * @return type
     */
    private function carregarDados($repository) {
        $array['idCache'] = $repository->getIdCache();
        $array['idClienteCache'] = $repository->getIdCliente()->getIdCliente();
        $array['noCache'] = $repository->getNoCache();
        $array['dsCache'] = $repository->getDsCache();
        $array['dsValor'] = $repository->getDsValor();
        return $array;
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

        $service = $this->getServiceLocator()->get($this->service);
        $repository = $service->selecionarCache($post['idCache']);
        if ($repository) {
            if ($service->excluirCache($repository)) {
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

        $dados = array();
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;

        $result = new JsonModel($dados);
        return $result;
    }

}
