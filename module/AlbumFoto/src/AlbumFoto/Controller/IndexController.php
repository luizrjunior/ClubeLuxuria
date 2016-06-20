<?php

namespace AlbumFoto\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Session\Container;
//import Size validator...
use Zend\Validator\File\Size;

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
            if ($repository->getTpAlbum() == 2) {
                $this->removerArquivo($repository->getDsAlbum());
            }
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

    public function uploadAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        $File = $this->params()->fromFiles('file');

        // Instanciando a sessão
        $sessao = new Container();

        $size = new Size(array('min' => 10000)); //minimum bytes filesize
//        $sizeMax = new Size(array('max'=>5242880)); //minimum bytes filesize

        $adapter = new \Zend\File\Transfer\Adapter\Http();
        $adapter->setValidators(array($size), $File['name']);
//        $adapter->setValidators(array($sizeMax), $File['name']);
        if (!$adapter->isValid()) {
            $tipoMsg = "E";
            $dataError = $adapter->getMessages();
            $error = array();
            foreach ($dataError as $key => $row) {
                $error[] = $row;
            }
            $textoMsg = $error;
            $name = NULL;
        } else {
            /* Criando a variável que contem o caminho da pasta aonde queremos verificar
             * O metodo $this->getRequest()->getServer('DOCUMENT_ROOT', false) pega o endereco 
             * da pasta root do seu site que aponta para a pasta public.
             */
            $diretorio = $this->getRequest()->getServer('DOCUMENT_ROOT', false) . "storage/videos/" . $sessao->idCliente . "/";
            if (!$this->Mkdir()->verifica($diretorio)) {
                $this->Mkdir()->criarDiretorio($diretorio);
            }
            $adapter->setDestination($diretorio);
            if ($adapter->receive($File['name'])) {
                $tipoMsg = "S";
                $textoMsg = "Arquivo baixado com sucesso!!!";
                $name = $File['name'];
            }
        }
        $dados = array();
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;
        $dados['name'] = $name;

        $result = new JsonModel($dados);
        return $result;
    }

    public function removerArquivoAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        $post = $this->getRequest()->getPost()->toArray();
        $this->removerArquivo($post['nameFile']);
    }

    private function removerArquivo($nameFile) {
        // Instanciando a sessão
        $sessao = new Container();
        $diretorio = $this->getRequest()->getServer('DOCUMENT_ROOT', false) . "storage/videos/" . $sessao->idCliente . "/";
        $status = $this->Mkdir()->removeArquivo($diretorio . $nameFile);
        if ($status) {
            $tipoMsg = "S";
            $textoMsg = "Arquivo removido com sucesso!";
        } else {
            $tipoMsg = "E";
            $textoMsg = "Não foi possível remover o arquivo!";
        }

        $dados = array();
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;

        $result = new JsonModel($dados);
        return $result;
    }

}
