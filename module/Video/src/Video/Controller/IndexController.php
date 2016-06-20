<?php

namespace Video\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractController {

    public function __construct() {
        $this->service = 'Video\Service\VideoService';
        $this->_view = new ViewModel();
    }

    /**
     * Pesquisar Action
     * @return type
     */
    public function pesquisarVideoAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        $service = $this->getServiceLocator()->get($this->service);
        $pagina = $this->getEvent()->getRouteMatch()->getParam('page');
        $post = $this->getRequest()->getPost()->toArray();
        $post['idClientePsq'] = $post['idClientePsqVideo'];
        unset($post['idClientePsqVideo']);
        $itens = $this->itemForPage;
        
        $this->_view->setVariable('lista', $service->listarVideosPaginado($post, $pagina, $itens));
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
        $param = array('idVideo' => $post['idVideo'], 'dsVideo' => $post['dsVideo'], 'idCliente' => $post['idClienteVideo']);
        $stNome = $service->verificarNomeExistente($param);
        if (!$stNome) {
            $post['idCliente'] = $post['idClienteVideo'];
            $post['dsArquivo'] = $post['dsArquivoVideo'];
            $arrVideo = $service->salvarVideo($post);
            if ($arrVideo) {
                $tipoMsg = "S";
                $textoMsg = $this->exibeMsgSalvar($post['idVideo']);
            } else {
                $tipoMsg = "E";
                $textoMsg = "Erro ao tentar cadastrar o Video! Tente mais tarde.";
            }
        } else {
            $tipoMsg = "W";
            $textoMsg = "Descrição do Video existente! Por favor informe outro.";
        }
        $dados = array();
        if ($arrVideo) {
            $dados['idVideo'] = $arrVideo->getIdVideo();
        }
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;

        $result = new JsonModel($dados);
        return $result;
    }

    private function exibeMsgSalvar($idVideo) {
        if ($idVideo) {
            $textoMsg = "Video atualizado com sucesso!";
        } else {
            $textoMsg = "Video cadastrado com sucesso!";
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
        $repository = $service->selecionarVideo($id);
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
     * Carregar Dados do Valor do Video
     * @param type $repository
     * @return type
     */
    private function carregarDados($repository) {
        $array['idVideo'] = $repository->getIdVideo();
        $array['idClienteVideo'] = $repository->getIdCliente()->getIdCliente();
        $array['tiVideo'] = $repository->getTiVideo();
        $array['dsVideo'] = $repository->getDsVideo();
        $array['tpVideo'] = $repository->getTpVideo();
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
        $repository = $service->selecionarVideo($post['idVideo']);
        if ($repository) {
            if ($repository->getTpVideo() == 2) {
                $this->removerArquivo($repository->getDsVideo());
            }
            if ($service->excluirVideo($repository)) {
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
