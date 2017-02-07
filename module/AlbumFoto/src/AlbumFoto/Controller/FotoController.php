<?php

namespace AlbumFoto\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Session\Container;
//import Size validator...
use Zend\Validator\File\Size;

class FotoController extends AbstractController {

    public function __construct() {
        $this->service = 'AlbumFoto\Service\FotoService';
        $this->_view = new ViewModel();
    }

    /**
     * Verificar Foto Horizontal Action
     * @return JsonModel
     */
    public function verificarFotoAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        //Verificar se existe Album Principal Cadastrado
        $post = $this->getRequest()->getPost()->toArray();
        $service = $this->getServiceLocator()->get($this->service);
        $param = array('idAlbum' => $post['idAlbumFoto']);
        $entities = $service->verificarFoto($param);
        $i = 1;
        $array = array();
        $array['tipoMsg'] = "";
        foreach ($entities as $entity) {
            $array['tipoMsg'] = "S";
            $array[$i]['idFoto'] = $entity->getIdFoto();
            $array[$i]['idAlbum'] = $entity->getIdAlbum()->getIdAlbum();
            $array[$i]['dsArquivo'] = $entity->getDsArquivo();
            $i++;
        }
        $result = new JsonModel($array);
        return $result;
    }
    
    /**
     * Verificar Foto do Perfil
     * @return type
     */
    public function verificarFotoPerfilAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        //Verificar se existe Album Principal Cadastrado
        $post = $this->getRequest()->getPost()->toArray();
        $service = $this->getServiceLocator()->get($this->service);
        $param = array('idFoto' => $post['idFotoPerfil'], 'tpFoto' => $post['tpFotoPerfil'], 'idAlbum' => $post['idAlbumFotoPerfil']);
        $arrFoto = $service->verificarFotoAlbumPrincipalExitente($param);
        if (!$arrFoto) {
            $tipoMsg = "N";
            $textoMsg = "Salvar Foto Perfil";
        } else {
            $tipoMsg = "S";
            $textoMsg = "Selecionar Foto Perfil";
        }

        $dados = array();
        if ($arrFoto) {
            $dados['idFoto'] = $arrFoto->getIdFoto();
        }
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;

        $result = new JsonModel($dados);
        return $result;
    }

    /**
     * Verificar Foto da Capa
     * @return type
     */
    public function verificarFotoCapaAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        //Verificar se existe Album Principal Cadastrado
        $post = $this->getRequest()->getPost()->toArray();
        $service = $this->getServiceLocator()->get($this->service);
        $param = array('idFoto' => $post['idFotoCapa'], 'tpFoto' => $post['tpFotoCapa'], 'idAlbum' => $post['idAlbumFotoCapa']);
        $arrFoto = $service->verificarFotoAlbumPrincipalExitente($param);
        if (!$arrFoto) {
            $tipoMsg = "N";
            $textoMsg = "Salvar Foto Capa";
        } else {
            $tipoMsg = "S";
            $textoMsg = "Selecionar Foto Capa";
        }

        $dados = array();
        if ($arrFoto) {
            $dados['idFoto'] = $arrFoto->getIdFoto();
        }
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;

        $result = new JsonModel($dados);
        return $result;
    }

    /**
     * Verificar Foto Horizontal Action
     * @return JsonModel
     */
    public function verificarFotoHorizontalAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        //Verificar se existe Album Principal Cadastrado
        $post = $this->getRequest()->getPost()->toArray();
        $service = $this->getServiceLocator()->get($this->service);
        $param = array('tpFoto' => 3, 'idAlbum' => $post['idAlbumFotoHorizontal']);
        $entities = $service->verificarFotoHorizontal($param);
        $i = 1;
        $array = array();
        $array['tipoMsg'] = "";
        foreach ($entities as $entity) {
            $array['tipoMsg'] = "S";
            $array[$i]['idFoto'] = $entity->getIdFoto();
            $array[$i]['idAlbum'] = $entity->getIdAlbum()->getIdAlbum();
            $array[$i]['dsArquivo'] = $entity->getDsArquivo();
            $i++;
        }
        $result = new JsonModel($array);
        return $result;
    }

    /**
     * Verificar Foto Vertical
     * @return JsonModel
     */
    public function verificarFotoVerticalAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        //Verificar se existe Album Principal Cadastrado
        $post = $this->getRequest()->getPost()->toArray();
        $service = $this->getServiceLocator()->get($this->service);
        $param = array('tpFoto' => 4, 'idAlbum' => $post['idAlbumFotoVertical']);
        $entities = $service->verificarFotoVertical($param);
        $i = 1;
        $array = array();
        $array['tipoMsg'] = "";
        foreach ($entities as $entity) {
            $array['tipoMsg'] = "S";
            $array[$i]['idFoto'] = $entity->getIdFoto();
            $array[$i]['idAlbum'] = $entity->getIdAlbum()->getIdAlbum();
            $array[$i]['dsArquivo'] = $entity->getDsArquivo();
            $i++;
        }
        $result = new JsonModel($array);
        return $result;
    }

    /**
     * Salvar Foto do Perfil
     * @return JsonModel
     */
    public function salvarFotoPerfilAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        $post = $this->getRequest()->getPost()->toArray();
        $service = $this->getServiceLocator()->get($this->service);

        $post['idFoto'] = $post['idFotoPerfil'];
        $post['idAlbum'] = $post['idAlbumFotoPerfil'];
        $post['tpFoto'] = $post['tpFotoPerfil'];
        $post['stFoto'] = $post['stFotoPerfil'];
        $post['stComentario'] = $post['stComentarioFotoPerfil'];
        $post['dsLegenda'] = $post['dsLegendaFotoPerfil'];
        $post['dsArquivo'] = $post['dsArquivoFotoPerfil'];
        if (empty($post['idFoto'])) {
            $post['dtFoto'] = new \DateTime("now");
        }

        $arrFoto = $this->salvarGenerico($service, $post);
        $tipoMsg = $arrFoto['tipoMsg'];
        $textoMsg = $arrFoto['textoMsg'];

        $dados = array();
        if ($arrFoto['idFoto']) {
            $dados['idFoto'] = $arrFoto['idFoto'];
        }
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;

        $result = new JsonModel($dados);
        return $result;
    }

    /**
     * Salvar Foto do Perfil
     * @return JsonModel
     */
    public function salvarFotoCapaAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        $post = $this->getRequest()->getPost()->toArray();
        $service = $this->getServiceLocator()->get($this->service);

        $post['idFoto'] = $post['idFotoCapa'];
        $post['idAlbum'] = $post['idAlbumFotoCapa'];
        $post['tpFoto'] = $post['tpFotoCapa'];
        $post['stFoto'] = $post['stFotoCapa'];
        $post['stComentario'] = $post['stComentarioFotoCapa'];
        $post['dsLegenda'] = $post['dsLegendaFotoCapa'];
        $post['dsArquivo'] = $post['dsArquivoFotoCapa'];
        if (empty($post['idFoto'])) {
            $post['dtFoto'] = new \DateTime("now");
        }

        $arrFoto = $this->salvarGenerico($service, $post);
        $tipoMsg = $arrFoto['tipoMsg'];
        $textoMsg = $arrFoto['textoMsg'];

        $dados = array();
        if ($arrFoto['idFoto']) {
            $dados['idFoto'] = $arrFoto['idFoto'];
        }
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;

        $result = new JsonModel($dados);
        return $result;
    }

    /**
     * Salvar Foto Action
     * @return JsonModel
     */
    public function salvarFotoAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        $post = $this->getRequest()->getPost()->toArray();
        $service = $this->getServiceLocator()->get($this->service);

        $post['idAlbum'] = $post['idAlbumFoto'];
        $post['stComentario'] = $post['stComentarioFoto'];
        $post['dsLegenda'] = $post['dsLegendaFoto'];
        $post['dsArquivo'] = $post['dsArquivoFoto'];
        if (empty($post['idFoto'])) {
            $post['dtFoto'] = new \DateTime("now");
        }

        $arrFoto = $this->salvarGenerico($service, $post);
        $tipoMsg = $arrFoto['tipoMsg'];
        $textoMsg = $arrFoto['textoMsg'];

        $dados = array();
        if ($arrFoto['idFoto']) {
            $dados['idFoto'] = $arrFoto['idFoto'];
        }
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;

        $result = new JsonModel($dados);
        return $result;
    }
    
    /**
     * Salvar Foto Horizontal Action
     * @return JsonModel
     */
    public function salvarFotoHorizontalAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        $post = $this->getRequest()->getPost()->toArray();
        $service = $this->getServiceLocator()->get($this->service);

        $post['idFoto'] = $post['idFotoHorizontal'];
        $post['idAlbum'] = $post['idAlbumFotoHorizontal'];
        $post['tpFoto'] = $post['tpFotoHorizontal'];
        $post['stFoto'] = $post['stFotoHorizontal'];
        $post['stComentario'] = $post['stComentarioFotoHorizontal'];
        $post['dsLegenda'] = $post['dsLegendaFotoHorizontal'];
        $post['dsArquivo'] = $post['dsArquivoFotoHorizontal'];
        if (empty($post['idFoto'])) {
            $post['dtFoto'] = new \DateTime("now");
        }

        $arrFoto = $this->salvarGenerico($service, $post);
        $tipoMsg = $arrFoto['tipoMsg'];
        $textoMsg = $arrFoto['textoMsg'];

        $dados = array();
        if ($arrFoto['idFoto']) {
            $dados['idFoto'] = $arrFoto['idFoto'];
        }
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;

        $result = new JsonModel($dados);
        return $result;
    }

    /**
     * Salvar Foto Vertical Action
     * @return JsonModel
     */
    public function salvarFotoVerticalAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        $post = $this->getRequest()->getPost()->toArray();
        $service = $this->getServiceLocator()->get($this->service);

        $post['idFoto'] = $post['idFotoVertical'];
        $post['idAlbum'] = $post['idAlbumFotoVertical'];
        $post['tpFoto'] = $post['tpFotoVertical'];
        $post['stFoto'] = $post['stFotoVertical'];
        $post['stComentario'] = $post['stComentarioFotoVertical'];
        $post['dsLegenda'] = $post['dsLegendaFotoVertical'];
        $post['dsArquivo'] = $post['dsArquivoFotoVertical'];
        if (empty($post['idFoto'])) {
            $post['dtFoto'] = new \DateTime("now");
        }

        $arrFoto = $this->salvarGenerico($service, $post);
        $tipoMsg = $arrFoto['tipoMsg'];
        $textoMsg = $arrFoto['textoMsg'];

        $dados = array();
        if ($arrFoto['idFoto']) {
            $dados['idFoto'] = $arrFoto['idFoto'];
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
        $param = array('idFoto' => $post['idFoto'], 'dsFoto' => $post['dsFoto'], 'idCliente' => $post['idCliente']);
        $stNome = $service->verificarNomeExistente($param);
        if (!$stNome) {
            $arrFoto = $this->salvarGenerico($service, $post);
            $tipoMsg = $arrFoto['tipoMsg'];
            $textoMsg = $arrFoto['textoMsg'];
        } else {
            $tipoMsg = "W";
            $textoMsg = "Descrição do Foto existente! Por favor informe outro.";
        }
        $dados = array();
        if ($arrFoto) {
            $dados['idFoto'] = $arrFoto->getIdFoto();
        }
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;

        $result = new JsonModel($dados);
        return $result;
    }

    private function salvarGenerico($service, $param) {
        if (empty($param['idFoto'])) {
            $param['dtCadastro'] = new \DateTime("now");
            unset($param['idFoto']);
        }
        $arrFoto = $service->salvarFoto($param);
        if ($arrFoto) {
            $tipoMsg = "S";
            $textoMsg = $this->exibeMsgSalvar($param['idFoto']);
        } else {
            $tipoMsg = "E";
            $textoMsg = "Erro ao tentar cadastrar o Foto! Tente mais tarde.";
        }
        if ($arrFoto) {
            $dados['idFoto'] = $arrFoto->getIdFoto();
        }
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;

        return $dados;
    }

    private function exibeMsgSalvar($idFoto) {
        if ($idFoto) {
            $textoMsg = "Foto atualizada com sucesso!";
        } else {
            $textoMsg = "Foto cadastrada com sucesso!";
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
        $repository = $service->selecionarFoto($id);
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
     * Carregar Dados do Valor do Foto
     * @param type $repository
     * @return type
     */
    private function carregarDados($repository) {
        $array['idFoto'] = $repository->getIdFoto();
        $array['idAlbum'] = $repository->getIdAlbum()->getIdAlbum();
        $array['tpFoto'] = $repository->getTpFoto();
        $array['stFoto'] = $repository->getStFoto();
        $array['stComentario'] = $repository->getStComentario();
        $array['dsLegenda'] = $repository->getDsLegenda();
        $array['dsArquivo'] = $repository->getDsArquivo();
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
        $repository = $service->selecionarFoto($post['idFoto']);
        if ($repository) {
            $this->removerArquivo($post);
            if ($service->excluirFoto($repository)) {
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
            'target' => $diretorio . $newName,
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
        $diretorioRoot = $this->Mkdir()->pegarDiretorioRoot($this->getRequest()->getServer('DOCUMENT_ROOT', false));
        $diretorio = $diretorioRoot . "storage/";
        if (!$this->Mkdir()->verificarDiretorio($diretorio)) {
            $this->Mkdir()->criarDiretorio($diretorio);
        }
        $diretorio = $diretorioRoot . "storage/fotos/";
        if (!$this->Mkdir()->verificarDiretorio($diretorio)) {
            $this->Mkdir()->criarDiretorio($diretorio);
        }
        $diretorio = $diretorioRoot . "storage/fotos/" . $sessao->idClienteAlbumSession . "/";
        if (!$this->Mkdir()->verificarDiretorio($diretorio)) {
            $this->Mkdir()->criarDiretorio($diretorio);
        }
        $diretorio = $diretorioRoot . "storage/fotos/" . $sessao->idClienteAlbumSession . "/" . $sessao->idAlbumSessao . "/";
        if (!$this->Mkdir()->verificarDiretorio($diretorio)) {
            $this->Mkdir()->criarDiretorio($diretorio);
        }
        return $diretorio;
    }

    public function removerArquivoAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        $post = $this->getRequest()->getPost()->toArray();
        $status = $this->removerArquivo($post);
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

    private function removerArquivo($param) {
        $sessao = new Container();
        $diretorioRoot = $this->Mkdir()->pegarDiretorioRoot($this->getRequest()->getServer('DOCUMENT_ROOT', false));
        $diretorio = $diretorioRoot . "storage/fotos/" . $sessao->idClienteAlbumSession . "/" . $param['idAlbum'] . "/";
        $status = $this->Mkdir()->removeArquivo($diretorio . $param['nameFile']);
        return $status;
    }

}
