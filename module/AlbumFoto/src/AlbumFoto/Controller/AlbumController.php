<?php

namespace AlbumFoto\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Session\Container;

class AlbumController extends AbstractController {

    public function __construct() {
        $this->service = 'AlbumFoto\Service\AlbumService';
        $this->_view = new ViewModel();
    }

    /**
     * Salvar Album Principal
     * @return type
     */
    public function verificarAlbumPrincipalAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        $post = $this->getRequest()->getPost()->toArray();
        $sessao = new Container();
        $sessao->idClienteAlbumSession = $post['idClienteAlbumPrincipal'];
        $service = $this->getServiceLocator()->get($this->service);
        $param = array('idAlbum' => $post['idAlbumPrincipal'], 'tpAlbum' => $post['tpAlbumPrincipal'], 'idCliente' => $post['idClienteAlbumPrincipal']);
        $arrAlbum = $service->verificarAlbumPrincipalExitente($param);
        if (!$arrAlbum) {
            $tipoMsg = "N";
            $textoMsg = "Salvar Album Principal";
        } else {
            $tipoMsg = "S";
            $textoMsg = "Selecionar Album Principal";
        }
        $dados = array();
        if ($arrAlbum) {
            $dados['idAlbum'] = $arrAlbum->getIdAlbum();
            $sessao->idAlbumSessao = $dados['idAlbum'];
        }
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;

        $result = new JsonModel($dados);
        return $result;
    }

    /**
     * Salvar Action
     * @return JsonModel
     */
    public function salvarAlbumPrincipalAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        $post = $this->getRequest()->getPost()->toArray();
        $service = $this->getServiceLocator()->get($this->service);

        $post['idCliente'] = $post['idClienteAlbumPrincipal'];
        $post['idAlbum'] = $post['idAlbumPrincipal'];
        $post['tpAlbum'] = $post['tpAlbumPrincipal'];
        $post['stAlbum'] = $post['stAlbumPrincipal'];
        $post['stComentario'] = $post['stComentarioAlbumPrincipal'];
        $post['noAlbum'] = $post['noAlbumPrincipal'];
        $post['dsAlbum'] = $post['dsAlbumPrincipal'];

        $arrAlbum = $this->salvarGenerico($service, $post);
        $tipoMsg = $arrAlbum['tipoMsg'];
        $textoMsg = $arrAlbum['textoMsg'];

        $dados = array();
        if ($arrAlbum['idAlbum']) {
            $dados['idAlbum'] = $arrAlbum['idAlbum'];
            // Instanciando a sessão
            $sessao = new Container();
            $sessao->idAlbumSessao = $dados['idAlbum'];
        }
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;

        $result = new JsonModel($dados);
        return $result;
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

        $post['idCliente'] = $post['idClienteAlbum'];
        $post['stComentario'] = $post['stComentarioAlbum'];

        $arrAlbum = $this->salvarGenerico($service, $post);
        $tipoMsg = $arrAlbum['tipoMsg'];
        $textoMsg = $arrAlbum['textoMsg'];

        $dados = array();
        if ($arrAlbum['idAlbum']) {
            $dados['idAlbum'] = $arrAlbum['idAlbum'];
            // Instanciando a sessão
            $sessao = new Container();
            $sessao->idAlbumSessao = $dados['idAlbum'];
        }
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;

        $result = new JsonModel($dados);
        return $result;
    }

    private function salvarGenerico($service, $param) {
        if (empty($param['idAlbum'])) {
            $param['dtCriacao'] = new \DateTime("now");
            unset($param['idAlbum']);
        }
        $arrAlbum = $service->salvarAlbum($param);
        if ($arrAlbum) {
            $tipoMsg = "S";
            $textoMsg = $this->exibeMsgSalvar($param['idAlbum']);
        } else {
            $tipoMsg = "E";
            $textoMsg = "Erro ao tentar cadastrar o Album! Tente mais tarde.";
        }
        if ($arrAlbum) {
            $dados['idAlbum'] = $arrAlbum->getIdAlbum();
        }
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;

        return $dados;
    }

    private function exibeMsgSalvar($idAlbum) {
        if ($idAlbum) {
            $textoMsg = "Album atualizado com sucesso!";
        } else {
            $textoMsg = "Album cadastrado com sucesso!";
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
        // Instanciando a sessão
        $sessao = new Container();
        $id = $this->getRequest()->getPost()->toArray();
        $sessao->idAlbumSessao = $id['idAlbum'];
        $service = $this->getServiceLocator()->get($this->service);
        $repository = $service->selecionarAlbum($id['idAlbum']);
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
        $array['tpAlbum'] = $repository->getTpAlbum();
        $array['stAlbum'] = $repository->getStAlbum();
        $array['stComentario'] = $repository->getStComentario();
        $array['noAlbum'] = $repository->getNoAlbum();
        $array['dsAlbum'] = $repository->getDsAlbum();
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

}