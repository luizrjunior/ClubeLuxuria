<?php

namespace Perfil\Controller;

use Application\Controller\AbstractController;
//MODEL
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
//FORMS
use Anunciante\Form as AnuncianteForm;
use Cliente\Form as ClienteForm;
use Usuario\Form as UsuarioForm;
use AlbumFoto\Form as AlbumFotoForm;
use Video\Form as VideoForm;
use Cache\Form as CacheForm;
use Banner\Form as BannerForm;
use Depoimento\Form as DepoimentoForm;
use ConfigPaginaCliente\Form as ConfigPaginaClienteForms;
use ConfigPaginaPerfil\Form as ConfigPaginaPerfilForms;
use Pagamento\Form as PagamentoForms;
//VALIDATOR
use Zend\Validator\File\Size;
//SESSION
use Zend\Session\Container;

class IndexController extends AbstractController {

    private $formPsqAnuncianteHome;
    private $formCadCliente;
    private $formCadUsuario;
    private $formCadAnunciante;
    private $formCadClienteCaracteristica;
    private $formPsqVideo;
    private $formCadVideo;
    private $formPsqCache;
    private $formCadCache;
    private $formPsqBanner;
    private $formCadBanner;
    private $formPsqAlbum;
    private $formCadAlbum;
    private $formCadFoto;
    private $idUsuarioPerfil;

    public function __construct() {
        $this->service = 'Cliente\Service\ClienteService';
        $this->_view = new ViewModel();
    }

    private function verificarVencimento($dtVencimento) {
        $dt_atual = date("Y-m-d");
        $timestamp_dt_atual = strtotime($dt_atual);

        $dt_expira = $dtVencimento;
        $timestamp_dt_expira = strtotime($dt_expira);
        if ($timestamp_dt_atual > $timestamp_dt_expira) {
            $stVencimento = FALSE;
        } else {
            $stVencimento = TRUE;
        }
        return $stVencimento;
    }

    public function indexAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        
        $this->idUsuarioPerfil = $this->identity()->getIdUsuario();
        $tpUsuario = $this->identity()->getTpUsuario();
        if ($tpUsuario == 3 || $tpUsuario == 4) {
            $clienteUsuario = $this->pegarIdClienteUsuarioLogado($this->idUsuarioPerfil);
            $idClientePerfil = $clienteUsuario[0]->getIdCliente()->getIdCliente();
            $stVencimento = FALSE;
            if ($clienteUsuario[0]->getIdCliente()->getDtVencimento()) {
                $stVencimento = $this->verificarVencimento($clienteUsuario[0]->getIdCliente()->getDtVencimento()->format('Y-m-d'));
            }
            $clienteLogado = $this->pegarDadosClienteLogado($idClientePerfil);
        } else {
            $idClientePerfil = null;
            $stVencimento = true;
            $clienteLogado = null;
        }
        $this->_view->setVariable('idClientePerfil', $idClientePerfil);
        $this->_view->setVariable('stVencimento', $stVencimento);
        $this->_view->setVariable('clienteLogado', $clienteLogado);
            
        $this->getEm();
        $config = $this->getServiceLocator()->get('config');

        $stPagamentoPsq = $config['constsStPagamentoPsq'];
        $tpPagamentoPsq = $config['constsTpPagamentoPsq'];

        //Formulario de Pesquisa de Pagamentos
        $this->formPsqPagamento = new PagamentoForms\PagamentoPsqForm($stPagamentoPsq, $tpPagamentoPsq);
        $this->_view->setVariable('formPsqPagamento', $this->formPsqPagamento);

        $stPagamento = $config['constsStPagamentoCad'];

        //Formulario de Cadastro de Pagamento
        $this->formCadPagamento = new PagamentoForms\PagamentoCadForm($stPagamento);
        $this->_view->setVariable('formCadPagamento', $this->formCadPagamento);
        
        /* ABA VISÃO GERAL */
        $sgUfPsq = $config['constsSgUfPsq'];
        $cidadePsq = $this->carregarSelectCidade(1);
        
        //Formulario de Pesquisa de Anunciantes
        $this->formPsqAnuncianteHome = new AnuncianteForm\AnunciantePsqHomeForm($sgUfPsq, $cidadePsq);
        $this->_view->setVariable('formPsqAnuncianteHome', $this->formPsqAnuncianteHome);

        $post = $this->getRequest()->getPost()->toArray();
        $post['tpAnunciantePsq'] = 1;//Acompanhante de Luxo
        $post['stAnunciantePsq'] = array(1,3,4);//1-Atividade;3-Viajando;4-Férias;
        $sgUfSessionPsq = $post['sgUfSessionPsq'];
        if (!$post['sgUfPsq']) {
            $post['sgUfPsq'] = $this->identity()->getSgUf();
            $sgUfSessionPsq = $post['sgUfPsq'];
        }
        $sessao = new Container();
        $sessao->sgUfSessionPsq = $sgUfSessionPsq;
        
        $listaClientesFavoritos = $this->listarAnunciantesFavoritos($this->idUsuarioPerfil);
        $this->_view->setVariable('listaFavoritos', $listaClientesFavoritos);
        
        $this->_view->setVariable('sgUfPsq', $this->identity()->getSgUf());
        $request = $this->getRequest();
        if ($request->isPost()) {
            $this->_view->setVariable('idCidadePsq', $post['idCidadePsq']);
            $this->_view->setVariable('sgUfPsq', $post['sgUfPsq']);
        }
        /* /ABA VISÃO GERAL */
        
        
        $sgUfCad = $config['constsSgUfCad'];
        /* ABA MINHA CONTA */
        if ($idClientePerfil) {
            $sgUfCad = $config['constsSgUfCad'];
            $stClienteCad = $config['constsStClienteCad'];
            $tpClienteCad = $config['constsTpClienteCad'];
            $tpSexoCad = $config['constsTpSexoCad'];

            //Formulario de Cadastro de Cliente
            $this->formCadCliente = new ClienteForm\ClienteCadForm($sgUfCad, $stClienteCad, $tpClienteCad, $tpSexoCad);
            $this->_view->setVariable('formCadCliente', $this->formCadCliente);
        }
        
        //Formulario Cadastro de Usuario
        $stUsuarioCad = $config['constsStUsuarioCad'];
        $tpUsuarioCad = $config['constsTpUsuarioCad'];
        
        //Instanciar e Setar o Form de Cadastro
        $this->formCadUsuario = new UsuarioForm\UsuarioCadForm($sgUfCad, $stUsuarioCad, $tpUsuarioCad);
        $this->_view->setVariable('formCadUsuario', $this->formCadUsuario);
        
        //Formulario de Cadastro de Configuracoes Pagina Cliente
        $this->formCadConfigPaginaPerfil = new ConfigPaginaPerfilForms\ConfigPaginaPerfilCadForm();
        $this->_view->setVariable('formCadConfigPaginaPerfil', $this->formCadConfigPaginaPerfil);
        
        $configPaginaPerfil = $this->selecionarConfigPaginaPerfil($this->idUsuarioPerfil);
        $this->_view->setVariable('configPaginaPerfil', $configPaginaPerfil);
            
        if ($idClientePerfil) {
            //Formulario de Cadastro de Frases Pagina Cliente
            $cidadeCad = $this->carregarSelectCidade(2);
            $tpCabeloCorCad = $config['constsTpCabeloCorCad'];
            $tpAnuncianteCad = $config['constsTpAnuncianteCad'];
            $stAnuncianteCad = $config['constsStAnuncianteCad'];
            $stAceitaCartaoCad = $config['constsSimNaoCad'];

            $this->formCadAnunciante = new AnuncianteForm\AnuncianteCadForm($sgUfCad, $cidadeCad, $tpCabeloCorCad, $stAceitaCartaoCad, $stAnuncianteCad, $tpAnuncianteCad);
            $this->_view->setVariable('formCadAnunciante', $this->formCadAnunciante);

            //Formulario de Cadastro Cliente e Caracteristicas
            $this->formCadClienteCaracteristica = new ClienteForm\ClienteCaracteristicaCadForm();
            $this->_view->setVariable('formCadClienteCaracteristica', $this->formCadClienteCaracteristica);

            //Formulario de Cadastro de Configuracoes Pagina Cliente
            $this->formCadConfigPaginaCliente = new ConfigPaginaClienteForms\ConfigPaginaClienteCadForm();
            $this->_view->setVariable('formCadConfigPaginaCliente', $this->formCadConfigPaginaCliente);
            
            //Formulario de Cadastro Album Principal
            $this->formCadAlbumPrincipal = new AlbumFotoForm\AlbumPrincipalCadForm();
            $this->_view->setVariable('formCadAlbumPrincipal', $this->formCadAlbumPrincipal);

            //Formulario de Cadastro Foto do Perfil
            $this->formCadFotoPerfil = new AlbumFotoForm\FotoPerfilCadForm();
            $this->_view->setVariable('formCadFotoPerfil', $this->formCadFotoPerfil);

            //Formulario de Cadastro Foto da Capa
            $this->formCadFotoCapa = new AlbumFotoForm\FotoCapaCadForm();
            $this->_view->setVariable('formCadFotoCapa', $this->formCadFotoCapa);

            //Formulario de Cadastro Foto da Horizontal
            $this->formCadFotoHorizontal = new AlbumFotoForm\FotoHorizontalCadForm();
            $this->_view->setVariable('formCadFotoHorizontal', $this->formCadFotoHorizontal);

            //Formulario de Cadastro Foto da Vertical
            $this->formCadFotoVertical = new AlbumFotoForm\FotoVerticalCadForm();
            $this->_view->setVariable('formCadFotoVertical', $this->formCadFotoVertical);

            $tpVideoPsq = $config['constsTpVideoPsq'];

            $this->formPsqVideo = new VideoForm\VideoPsqForm($tpVideoPsq);
            $this->_view->setVariable('formPsqVideo', $this->formPsqVideo);

            $tpVideo = $config['constsTpVideoCad'];

            $this->formCadVideo = new VideoForm\VideoCadForm($tpVideo);
            $this->_view->setVariable('formCadVideo', $this->formCadVideo);

            //Formulario de Pesquisa de Valor Caches
            $this->formPsqCache = new CacheForm\CachePsqForm();
            $this->_view->setVariable('formPsqCache', $this->formPsqCache);

            //Formulario de Cadastro de Valor Cache
            $this->formCadCache = new CacheForm\CacheCadForm();
            $this->_view->setVariable('formCadCache', $this->formCadCache);

            $tpBannerPsq = $config['constsTpBannerPsq'];

            //Formulario de Pesquisa de Valor Banners
            $this->formPsqBanner = new BannerForm\BannerPsqForm($tpBannerPsq);
            $this->_view->setVariable('formPsqBanner', $this->formPsqBanner);

            $tpBanner = $config['constsTpBannerCad'];

            //Formulario de Cadastro de Valor Banner
            $this->formCadBanner = new BannerForm\BannerCadForm($tpBanner);
            $this->_view->setVariable('formCadBanner', $this->formCadBanner);

            $situacaoDepoimentoPsq = $config['constsSituacaoDepoimentoPsq'];

            //Formulario de Pesquisa de Valor Depoimentos
            $this->formPsqDepoimento = new DepoimentoForm\DepoimentoPsqForm($situacaoDepoimentoPsq);
            $this->_view->setVariable('formPsqDepoimento', $this->formPsqDepoimento);

            $situacaoDepoimentoCad = $config['constsSituacaoDepoimentoCad'];

            //Formulario de Cadastro de Valor Depoimento
            $this->formCadDepoimento = new DepoimentoForm\DepoimentoCadForm($situacaoDepoimentoCad);
            $this->_view->setVariable('formCadDepoimento', $this->formCadDepoimento);

            $tpAlbumPsq = $config['constsTpAlbumPsq'];
            $stAlbumPsq = $config['constsStAlbumPsq'];

            //Formulario de Pesquisa de Valor Depoimentos
            $this->formPsqAlbum = new AlbumFotoForm\AlbumPsqForm($tpAlbumPsq, $stAlbumPsq);
            $this->_view->setVariable('formPsqAlbum', $this->formPsqAlbum);

            $tpAlbumCad = $config['constsTpAlbumCad'];
            $stAlbumCad = $config['constsStAlbumCad'];

            //Formulario de Cadastro de Valor Depoimento
            $this->formCadAlbum = new AlbumFotoForm\AlbumCadForm($tpAlbumCad, $stAlbumCad);
            $this->_view->setVariable('formCadAlbum', $this->formCadAlbum);

            //Formulario de Cadastro de Valor Depoimento
            $this->formCadFoto = new AlbumFotoForm\FotoCadForm();
            $this->_view->setVariable('formCadFoto', $this->formCadFoto);
        }
        /* /ABA MINHA CONTA */
        
        
        /* ABA MEU DIARIO */
        /* /ABA MEU DIARIO */
        
        /* ABA DIARIOS */
        /* /ABA DIARIOS */
        
        return $this->_view;
    }
    
    protected function pegarIdClienteUsuarioLogado($idUsuario) {
        $service = $this->getServiceLocator()->get('Cliente\Service\ClienteUsuarioService');
        $param = array('idUsuario' => $idUsuario);
        $repository = $service->selecionarClienteUsuarioBy($param);
        return $repository;
    }

    protected function pegarDadosClienteLogado($idCliente) {
        $service = $this->getServiceLocator()->get($this->service);
        $result = $service->selecionarCliente($idCliente);
        return $result;
    }
    
    /**
     * Selecionar Configuracoes da Pagina de Perfil do Usuario
     * @param type $idUsuario
     * @return type
     */
    protected function selecionarConfigPaginaPerfil($idUsuario) {
        $service = $this->getServiceLocator()->get('ConfigPaginaPerfil\Service\ConfigPaginaPerfilService');
        $param = array('idUsuario' => $idUsuario);
        $repository = $service->selecionarConfigPaginaPerfilBy($param);
        $dados = array();
        if ($repository) {
            $dados = $this->carregarConfigPaginaPerfil($repository[0]);
        }
        return $dados;
    }

    /**
     * Carregar Dados do Cliente Usuario
     * @param type $repository
     * @return type $array
     */
    private function carregarConfigPaginaPerfil($repository) {
        $array['stInfoUsuario'] = $repository->getStInfoUsuario();
        $array['stBannerPrincipal'] = $repository->getStBannerPrincipal();
        $array['stMinhasFavoritas'] = $repository->getStMinhasFavoritas();
        $array['stDestaques'] = $repository->getStDestaques();
        $array['tpPlanoFundo'] = $repository->getTpPlanoFundo();
        return $array;
    }

    /**
     * Carregar Select de Cidades
     * @param type $tpForm
     * @return type
     */
    private function carregarSelectCidade($tpForm) {
        $repository = $this->em->getRepository("\Cidade\Entity\CidadeEntity");
        $entities = $repository->findBy(array('sgUf' => 'DF'), array('noCidade' => 'ASC'));
        if ($tpForm == 1) {
            $valor = " - - Todas - - ";
        } else {
            $valor = " - - Selecione - - ";
        }
        $array[NULL] = $valor;
        foreach ($entities as $entity) {
            if ($entity->getIdCidade() != "") {
                $array[$entity->getIdCidade()] = utf8_encode($entity->getNoCidade());
            }
        }
        return $array;
    }

    protected function listarAnunciantesFavoritos($idUsuario) {
        $service = $this->getServiceLocator()->get("Favoritos\Service\FavoritosService");
        $listaClientes = $service->listarAnunciantesFavoritos($idUsuario);
        
        return $listaClientes;
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
        $post['dsArquivo'] = $post['dsArquivoFotoPerfilUsuario'];
        $tipoMsg = "S";
        $textoMsg = "Foto do Perfil cadastrada com sucesso!!";

        $dados = array();
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;

        $result = new JsonModel($dados);
        return $result;
    }

    /**
     * Mostrar Foto Perfil Action
     * @return JsonModel
     */
    public function mostrarFotoPerfilAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        $diretorioRoot = $this->Mkdir()->pegarDiretorioRoot($this->getRequest()->getServer('DOCUMENT_ROOT', false));
        // Instanciando a sessão
        $this->idUsuarioPerfil = $this->identity()->getIdUsuario();
        $path = $diretorioRoot . "storage/usuarios/" . $this->idUsuarioPerfil . "/foto-perfil/";
        $array = array();
        $array['tipoMsg'] = "";
        if ($this->Mkdir()->verificarDiretorio($path)) {
            $diretorio = dir($path);
            while($arquivo = $diretorio -> read()) {
                if ($arquivo != "." && $arquivo != "..") {
                    $array['tipoMsg'] = "S";
                    $array['dsArquivo'] = $arquivo;
                }
            }
            $diretorio->close();  
        }
        $result = new JsonModel($array);
        return $result;
    }
    
    public function uploadFotoPerfilAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        $file = $this->params()->fromFiles('file');
        $diretorio = $this->verificarDiretorio();
        $dados = $this->validarUpload($file, $diretorio);
        $result = new JsonModel($dados);
        return $result;
    }
    
    private function validarUpload($file,$diretorio) {
        $size = new Size(array('min'=>1000)); //minimum bytes filesize
        $adapter = new \Zend\File\Transfer\Adapter\Http(); 
        $adapter->setValidators(array($size), $file['name']);
        if (!$adapter->isValid()){
            $dados["tipoMsg"] = "E";
            $dataError = $adapter->getMessages();
            $error = array();
            foreach($dataError as $key => $row) {
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
        $newName = md5(rand(). $file['name']) . '.' . $ext;
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
        $diretorioRoot = $this->Mkdir()->pegarDiretorioRoot($this->getRequest()->getServer('DOCUMENT_ROOT', false));
        $this->idUsuarioPerfil = $this->identity()->getIdUsuario();
        $diretorio = $diretorioRoot . "storage/";
        if (!$this->Mkdir()->verificarDiretorio($diretorio)) {
            $this->Mkdir()->criarDiretorio($diretorio);
        }
        $diretorio = $diretorioRoot . "storage/usuarios/";
        if (!$this->Mkdir()->verificarDiretorio($diretorio)) {
            $this->Mkdir()->criarDiretorio($diretorio);
        }
        $diretorio = $diretorioRoot . "storage/usuarios/" . $this->idUsuarioPerfil . "/";
        if (!$this->Mkdir()->verificarDiretorio($diretorio)) {
            $this->Mkdir()->criarDiretorio($diretorio);
        }
        $diretorio = $diretorioRoot . "storage/usuarios/" . $this->idUsuarioPerfil . "/foto-perfil/";
        if (!$this->Mkdir()->verificarDiretorio($diretorio)) {
            $this->Mkdir()->criarDiretorio($diretorio);
        }
        return $diretorio;
    }
    
    /**
     * Remover Arquivo
     * @return JsonModel
     */
    public function removerArquivoAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
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
        $diretorioRoot = $this->Mkdir()->pegarDiretorioRoot($this->getRequest()->getServer('DOCUMENT_ROOT', false));
        // Instanciando a sessão
        $this->idUsuarioPerfil = $this->identity()->getIdUsuario();
        $diretorio = $diretorioRoot . "storage/usuarios/" . $this->idUsuarioPerfil . "/foto-perfil/";
        $status = $this->Mkdir()->removeArquivo($diretorio . $nameFile);
        return $status;
    }
    
    public function alterarSenhaAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        $this->idUsuarioPerfil = $this->identity()->getIdUsuario();
        $post = $this->getRequest()->getPost()->toArray();
        $post['idUsuario'] = $this->idUsuarioPerfil;
        $post['senha'] = $post['senhaNova'];
        $service = $this->getServiceLocator()->get('Usuario\Service\UsuarioService');
        $repository = $service->selecionarUsuario($post['idUsuario']);
        $senha = $repository->getSenha();
        $senhaAtual = md5($post['senhaAtual']);
        if ($senha == $senhaAtual) {
            $arrUsuario = $service->salvarUsuario($post);
            if ($arrUsuario) {
                $tipoMsg = "S";
                $textoMsg = "Senha Alterada com sucesso!";
            } else {
                $tipoMsg = "E";
                $textoMsg = "Não foi possível realizar esta operação! Tente mais tarde.";
            }
        } else {
            $tipoMsg = "W";
            $textoMsg = "Senha Atual divergente da senha cadastrada!";
        }

        $dados = array();
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;

        $result = new JsonModel($dados);
        return $result;
    }
    
    /**
     * Remover Página dos Favoritos do Usuário
     * @return JsonModel
     */
    public function removerFavoritosAction() {
        $post = $this->getRequest()->getPost()->toArray();
        $service = $this->getServiceLocator()->get('Favoritos\Service\FavoritosService');
        $repository = $service->selecionarFavoritos($post['idFavoritos']);
        if ($repository) {
            if ($service->removerFavoritos($repository)) {
                $tipoMsg = "S";
            } else {
                $tipoMsg = "E";
            }
        } else {
            $tipoMsg = "I";
        }
        
        $dados = array();
        $dados['tipoMsg'] = $tipoMsg;
        
        $result = new JsonModel($dados);
        return $result;
    }
    
}
