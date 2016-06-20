<?php

namespace Banner\Controller;

use Application\Controller\AbstractController;
use Banner\Form as BannerForms;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Session\Container;
use Zend\Validator\File\Size;

class IndexController extends AbstractController {

    private $formPsqBanner;
    private $formCadBanner;

    public function __construct() {
        $this->service = 'Banner\Service\BannerService';
        $this->_view = new ViewModel();
    }

    /**
     * Index Action
     * @return type
     */
    public function indexAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        $this->getEm();
        $config = $this->getServiceLocator()->get('config');

        $tpBannerPsq = $config['constsTpBannerPsq'];

        //Formulario de Pesquisa de Valor Banners
        $this->formPsqBanner = new BannerForms\BannerPsqForm($tpBannerPsq);
        $this->_view->setVariable('formPsqBanner', $this->formPsqBanner);

        $tpBanner = $config['constsTpBannerCad'];

        //Formulario de Cadastro de Valor Banner
        $this->formCadBanner = new BannerForms\BannerCadForm($tpBanner);
        $this->_view->setVariable('formCadBanner', $this->formCadBanner);

        return $this->_view;
    }

    /**
     * Abrir Banner Action
     * @return type
     */
    public function abrirModelosBannersAction() {
        return $this->_view;
    }

    /**
     * Visualizar Banner
     * @return type
     */
    public function visualizarBannerAction() {
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        $service = $this->getServiceLocator()->get($this->service);
        $repository = $service->selecionarBanner($id);
        $dados = $this->carregarDados($repository);
        $this->_view->setVariable('dsBanner', $dados['dsBanner']);
        return $this->_view;
    }

    /**
     * Pesquisar Action
     * @return type
     */
    public function pesquisarBannerAction() {
        $service = $this->getServiceLocator()->get($this->service);
        $pagina = $this->getEvent()->getRouteMatch()->getParam('page');
        $post = $this->getRequest()->getPost()->toArray();
        $itens = $this->itemForPage;

        $this->_view->setVariable('lista', $service->listarBannersPaginado($post, $pagina, $itens));
        $this->_view->setTerminal(true);

        return $this->_view;
    }

    /**
     * Salvar Action
     * @return JsonModel
     */
    public function salvarAction() {
        $post = $this->getRequest()->getPost()->toArray();
        $post['stBanner'] = 1;
        $post['dtInicio'] = \DateTime::createFromFormat('d/m/Y', $post['dtInicio']);
        $post['dtFim'] = \DateTime::createFromFormat('d/m/Y', $post['dtFim']);
        $service = $this->getServiceLocator()->get($this->service);
        $arrBanner = $service->salvarBanner($post);
        if ($arrBanner) {
            $tipoMsg = "S";
            $textoMsg = $this->exibeMsgSalvar($post['idBanner']);
        } else {
            $tipoMsg = "E";
            $textoMsg = "Erro ao tentar cadastrar o Banner! Tente mais tarde.";
        }
        $dados = array();
        if ($arrBanner) {
            $dados['idBanner'] = $arrBanner->getIdBanner();
        }
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;

        $result = new JsonModel($dados);
        return $result;
    }

    /**
     * Exibe Mensagem Salvar
     * @param type $idBanner
     * @return string
     */
    private function exibeMsgSalvar($idBanner) {
        if ($idBanner) {
            $textoMsg = "Banner atualizado com sucesso!";
        } else {
            $textoMsg = "Banner cadastrado com sucesso!";
        }
        return $textoMsg;
    }

    /**
     * Selecionar Action
     * @return JsonModel
     */
    public function selecionarAction() {
        $sessao = new Container();
        $id = $this->getRequest()->getPost()->toArray();
        $service = $this->getServiceLocator()->get($this->service);
        $repository = $service->selecionarBanner($id);
        if ($repository) {
            $tipoMsg = "S";
            $textoMsg = "Registro encontrado!";
            $dados = $this->carregarDados($repository);
            $sessao->idClienteBannerSession = $dados['idCliente'];
        } else {
            $tipoMsg = "I";
            $textoMsg = "Registro não encontrado!";
            $dados = NULL;
            $sessao->idClienteBannerSession = $dados;
        }
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;

        $result = new JsonModel($dados);
        return $result;
    }

    /**
     * Carregar Dados do Valor do Banner
     * @param type $repository
     * @return type
     */
    private function carregarDados($repository) {
        $array['idBanner'] = $repository->getIdBanner();
        $array['idCliente'] = $repository->getIdCliente()->getIdCliente();
        $array['dsBanner'] = $repository->getDsBanner();
        $array['tpBanner'] = $repository->getTpBanner();
        $array['dtInicio'] = $repository->getDtInicio()->format('d/m/Y');
        $array['dtFim'] = $repository->getDtFim()->format('d/m/Y');
        return $array;
    }

    /**
     * Excluir Action
     * @return JsonModel
     */
    public function excluirAction() {
        $post = $this->getRequest()->getPost()->toArray();

        $service = $this->getServiceLocator()->get($this->service);
        $repository = $service->selecionarBanner($post['idBanner']);
        if ($repository) {
            if ($repository->getTpBanner() == 2) {
                $this->removerArquivo($repository->getDsBanner());
            }
            if ($service->excluirBanner($repository)) {
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
        $file = $this->params()->fromFiles('file');
        $diretorio = $this->verificarDiretorio();
        $dados = $this->validarUpload($file, $diretorio);
        $result = new JsonModel($dados);
        return $result;
    }

    private function validarUpload($file, $diretorio) {
        $size = new Size(array('min' => 1000)); //minimum bytes filesize
        $adapter = new \Zend\File\Transfer\Adapter\Http();
        $adapter->setValidators(array($size), $file['name']);
        if (!$adapter->isValid()) {
            $dados["tipoMsg"] = "E";
            $dataError = $adapter->getMessages();
            $error = array();
            foreach ($dataError as $key => $row) {
                $error[] = $key . " - " . $row;
            }
            $dados["textoMsg"] = $error;
            $dados["name"] = NULL;
        } else {
            $dados = $this->upload($adapter, $file, $diretorio);
        }
        return $dados;
    }

    private function upload($adapter, $file, $diretorio) {
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newName = md5(rand() . $file['name']) . '.' . $ext;
        $adapter->addFilter('File\Rename', array(
            'target' => $diretorio . '/' . $newName,
        ));
        if ($adapter->receive($file['name'])) {
            $dados["tipoMsg"] = "S";
            $dados["textoMsg"] = "Arquivo baixado com sucesso!!!";
        }
        $dados["name"] = $newName;
        return $dados;
    }

    private function verificarDiretorio() {
        // Instanciando a sessão
        $sessao = new Container();
        $diretorio = $this->getRequest()->getServer('DOCUMENT_ROOT', false) . "storage/banners/" . $sessao->idClienteBannerSession . "/";
        if (!$this->Mkdir()->verifica($diretorio)) {
            $this->Mkdir()->criarDiretorio($diretorio);
        }
        return $diretorio;
    }

    /**
     * Remover Arquivo
     * @return JsonModel
     */
    public function removerArquivoAction() {
        $post = $this->getRequest()->getPost()->toArray();
        $status = $this->removerArquivo($post['nameFile']);
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

    /**
     * Remover Arquivo
     * @param type $nameFile
     * @return type
     */
    private function removerArquivo($nameFile) {
        // Instanciando a sessão
        $sessao = new Container();
        $diretorio = $this->getRequest()->getServer('DOCUMENT_ROOT', false) . "storage/banners/" . $sessao->idClienteBannerSession . "/";
        $status = $this->Mkdir()->removeArquivo($diretorio . $nameFile);
        return $status;
    }

    /**
     * Verificar Arquivos Banners Cliente Action
     * @return JsonModel
     */
    public function verificarArquivosBannerAction() {
        // Instanciando a sessão
        $sessao = new Container();
        $path = $this->getRequest()->getServer('DOCUMENT_ROOT', false) . "storage/banners/" . $sessao->idClienteBannerSession . "/";
        $diretorio = dir($path);
        $i = 1;
        $array = array();
        $array['tipoMsg'] = "";
        while ($arquivo = $diretorio->read()) {
            if ($arquivo != "." && $arquivo != "..") {
                $array['tipoMsg'] = "S";
                $array[$i]['dsArquivo'] = $arquivo;
                $i++;
            }
        }
        $diretorio->close();

        $result = new JsonModel($array);
        return $result;
    }

    /**
     * Selecionar Action
     * @return JsonModel
     */
    public function alterarClienteBannerAction() {
        $sessao = new Container();
        unset($sessao->idClienteBannerSession);
        $post = $this->getRequest()->getPost()->toArray();
        $sessao->idClienteBannerSession = $post['idCliente'];
        
        $dados['tipoMsg'] = "S";
        $dados['idCliente'] = $sessao->idClienteBannerSession;

        $result = new JsonModel($dados);
        return $result;
    }

}
