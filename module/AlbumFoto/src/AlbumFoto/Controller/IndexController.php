<?php

namespace AlbumFoto\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Session\Container;

class IndexController extends AbstractController {

    public function __construct() {
        $this->service = 'AlbumFoto\Service\AlbumService';
        $this->_view = new ViewModel();
    }

    public function indexAction() {
        return $this->_view;
    }

    /**
     * Pesquisar Action
     * @return type
     */
    public function pesquisarAlbumAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        $service = $this->getServiceLocator()->get($this->service);
        $pagina = $this->getEvent()->getRouteMatch()->getParam('page');
        
        $post = $this->getRequest()->getPost()->toArray();
        $post['idClientePsq'] = $post['idClientePsqAlbum'];
        
        $sessao = new Container();
        $sessao->idClienteAlbumSession = $post['idClientePsqAlbum'];
        
        unset($post['idClientePsqAlbum']);
        $itens = $this->itemForPage;
        
        $this->_view->setVariable('lista', $service->listarAlbumsPaginado($post, $pagina, $itens));
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
        $param = array('idAlbum' => $post['idAlbum'], 'dsAlbum' => $post['dsAlbum'], 'idCliente' => $post['idCliente']);
        $stNome = $service->verificarNomeExistente($param);
        if (!$stNome) {
            $arrAlbum = $service->salvarAlbum($post);
            if ($arrAlbum) {
                $tipoMsg = "S";
                $textoMsg = $this->exibeMsgSalvar($post['idAlbum']);
            } else {
                $tipoMsg = "E";
                $textoMsg = "Erro ao tentar cadastrar o Album! Tente mais tarde.";
            }
        } else {
            $tipoMsg = "W";
            $textoMsg = "Descrição do Album existente! Por favor informe outro.";
        }
        $dados = array();
        if ($arrAlbum) {
            $dados['idAlbum'] = $arrAlbum->getIdAlbum();
        }
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;

        $result = new JsonModel($dados);
        return $result;
    }

    private function exibeMsgSalvar($idAlbum) {
        if ($idAlbum) {
            $textoMsg = "Album atualizado!";
        } else {
            $textoMsg = "Album cadastrado!";
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
        $repository = $service->selecionarAlbum($id);
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
     * Carregar Dados do Valor do Album
     * @param type $repository
     * @return type
     */
    private function carregarDados($repository) {
        $array['idAlbum'] = $repository->getIdAlbum();
        $array['dsAlbum'] = $repository->getDsAlbum();
        $array['tpAlbum'] = $repository->getTpAlbum();
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
        $repository = $service->selecionarAlbum($post['idAlbum']);
        if ($repository) {
            if ($service->excluirAlbum($repository)) {
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

    /**
     * Pesquisar Action
     * @return type
     */
    public function pesquisarMinhasFotosAction() {
        $service = $this->getServiceLocator()->get('AlbumFoto\Service\FotoService');
        $pagina = $this->getEvent()->getRouteMatch()->getParam('page');
        $post = $this->getRequest()->getPost()->toArray();
        $itens = 20;
        $post['idClientePsq'] = $post['idClientePsqMinhasFotos'];
        $post['tpAlbumPsq'] = array(2,3);
        $this->_view->setVariable('lista', $service->listarMinhasFotosPaginado($post, $pagina, $itens));
        $this->_view->setTerminal(true);

        return $this->_view;
    }

    /**
     * Pesquisar Action
     * @return type
     */
    public function pesquisarMeusAlbunsAction() {
        $service = $this->getServiceLocator()->get('AlbumFoto\Service\AlbumService');
        $pagina = $this->getEvent()->getRouteMatch()->getParam('page');
        $post = $this->getRequest()->getPost()->toArray();
        $itens = 20;
        $post['idClientePsq'] = $post['idClientePsqMeusAlbuns'];
        $post['tpAlbumPsq'] = array(2,3);
        $this->_view->setVariable('lista', $service->listarMeusAlbunsPaginado($post, $pagina, $itens));
        $this->_view->setTerminal(true);

        return $this->_view;
    }

    public function albumAction() {
        return $this->_view;
    }

}
