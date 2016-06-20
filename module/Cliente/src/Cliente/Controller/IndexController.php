<?php

namespace Cliente\Controller;
//CONTROLLER
use Application\Controller\AbstractController;
//FORMS
use Cliente\Form as ClienteForms;
use Usuario\Form as UsuarioForm;
use Anunciante\Form as AnuncianteForm;
use AlbumFoto\Form as AlbumFotoForms;
use Video\Form as VideoForms;
use Cache\Form as CacheForms;
use Depoimento\Form as DepoimentoForms;
use ConfigPaginaCliente\Form as ConfigPaginaClienteForms;
use Pagamento\Form as PagamentoForms;
//MODEL
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
//SESSION
use Zend\Session\Container;

class IndexController extends AbstractController {

    private $formPsqCliente;
    private $formCadCliente;
    private $formCadUsuario;
    private $formCadAnunciante;
    private $formCadClienteCaracteristica;
    private $formPsqVideo;
    private $formCadVideo;
    private $formPsqCache;
    private $formCadCache;
    private $formPsqAlbum;
    private $formCadAlbum;
    private $formCadFoto;
    private $formCadConfigPaginaCliente;

    function __construct() {
        $this->service = 'Cliente\Service\ClienteService';
        $this->_view = new ViewModel();
    }

    public function indexAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        $this->getEm();
        $config = $this->getServiceLocator()->get('config');

        $sessao = new Container();
        $this->_view->setVariable('sessao', $sessao);
        
        //Instanciar e Setar o Form de Pesquisa
        $sgUfPsq = $config['constsSgUfPsq'];
        $stClientePsq = $config['constsStClientePsq'];
        $tpClientePsq = $config['constsTpClientePsq'];
        $tpSexoPsq = $config['constsTpSexoPsq'];

        //Formulario de Pesquisa de Clientes
        $this->formPsqCliente = new ClienteForms\ClientePsqForm($sgUfPsq, $stClientePsq, $tpClientePsq, $tpSexoPsq);
        $this->_view->setVariable('formPsqCliente', $this->formPsqCliente);

        //Instanciar e Setar o Form de Cadastro
        $sgUfCad = $config['constsSgUfCad'];
        $stClienteCad = $config['constsStClienteCad'];
        $tpClienteCad = $config['constsTpClienteCad'];
        $tpSexoCad = $config['constsTpSexoCad'];

        //Formulario de Cadastro de Cliente
        $this->formCadCliente = new ClienteForms\ClienteCadForm($sgUfCad, $stClienteCad, $tpClienteCad, $tpSexoCad);
        $this->_view->setVariable('formCadCliente', $this->formCadCliente);

        //Formulario Cadastro de Usuario
        $stUsuarioCad = $config['constsStUsuarioCad'];
        $tpUsuarioCad = $config['constsTpUsuarioCad'];
        
        //Instanciar e Setar o Form de Cadastro
        $this->formCadUsuario = new UsuarioForm\UsuarioCadForm($sgUfCad, $stUsuarioCad, $tpUsuarioCad);
        $this->_view->setVariable('formCadUsuario', $this->formCadUsuario);

        //Formulario de Cadastro de Frases Pagina Cliente
        $cidadeCad = $this->carregarSelectCidade(2);
        $tpCabeloCorCad = $config['constsTpCabeloCorCad'];
        $tpAnuncianteCad = $config['constsTpAnuncianteCad'];
        $stAnuncianteCad = $config['constsStAnuncianteCad'];
        $stAceitaCartaoCad = $config['constsSimNaoCad'];
        
        $this->formCadAnunciante = new AnuncianteForm\AnuncianteCadForm($sgUfCad, $cidadeCad, $tpCabeloCorCad, $stAceitaCartaoCad, $stAnuncianteCad, $tpAnuncianteCad);
        $this->_view->setVariable('formCadAnunciante', $this->formCadAnunciante);

        //Formulario de Cadastro Cliente e Caracteristicas
        $this->formCadClienteCaracteristica = new ClienteForms\ClienteCaracteristicaCadForm();
        $this->_view->setVariable('formCadClienteCaracteristica', $this->formCadClienteCaracteristica);

        //Formulario de Cadastro de Configuracoes Pagina Cliente
        $this->formCadConfigPaginaCliente = new ConfigPaginaClienteForms\ConfigPaginaClienteCadForm();
        $this->_view->setVariable('formCadConfigPaginaCliente', $this->formCadConfigPaginaCliente);
        
        //Formulario de Cadastro Album Principal
        $this->formCadAlbumPrincipal = new AlbumFotoForms\AlbumPrincipalCadForm();
        $this->_view->setVariable('formCadAlbumPrincipal', $this->formCadAlbumPrincipal);

        //Formulario de Cadastro Foto do Perfil
        $this->formCadFotoPerfil = new AlbumFotoForms\FotoPerfilCadForm();
        $this->_view->setVariable('formCadFotoPerfil', $this->formCadFotoPerfil);

        //Formulario de Cadastro Foto da Capa
        $this->formCadFotoCapa = new AlbumFotoForms\FotoCapaCadForm();
        $this->_view->setVariable('formCadFotoCapa', $this->formCadFotoCapa);

        //Formulario de Cadastro Foto da Horizontal
        $this->formCadFotoHorizontal = new AlbumFotoForms\FotoHorizontalCadForm();
        $this->_view->setVariable('formCadFotoHorizontal', $this->formCadFotoHorizontal);

        //Formulario de Cadastro Foto da Vertical
        $this->formCadFotoVertical = new AlbumFotoForms\FotoVerticalCadForm();
        $this->_view->setVariable('formCadFotoVertical', $this->formCadFotoVertical);

        $tpVideoPsq = $config['constsTpVideoPsq'];
        
        $this->formPsqVideo = new VideoForms\VideoPsqForm($tpVideoPsq);
        $this->_view->setVariable('formPsqVideo', $this->formPsqVideo);
        
        $tpVideo = $config['constsTpVideoCad'];
        
        $this->formCadVideo = new VideoForms\VideoCadForm($tpVideo);
        $this->_view->setVariable('formCadVideo', $this->formCadVideo);
        
        //Formulario de Pesquisa de Valor Caches
        $this->formPsqCache = new CacheForms\CachePsqForm();
        $this->_view->setVariable('formPsqCache', $this->formPsqCache);
        
        //Formulario de Cadastro de Valor Cache
        $this->formCadCache = new CacheForms\CacheCadForm();
        $this->_view->setVariable('formCadCache', $this->formCadCache);
        
        $situacaoDepoimentoPsq = $config['constsSituacaoDepoimentoPsq'];
        
        //Formulario de Pesquisa de Valor Depoimentos
        $this->formPsqDepoimento = new DepoimentoForms\DepoimentoPsqForm($situacaoDepoimentoPsq);
        $this->_view->setVariable('formPsqDepoimento', $this->formPsqDepoimento);

        $situacaoDepoimentoCad = $config['constsSituacaoDepoimentoCad'];
        
        //Formulario de Cadastro de Valor Depoimento
        $this->formCadDepoimento = new DepoimentoForms\DepoimentoCadForm($situacaoDepoimentoCad);
        $this->_view->setVariable('formCadDepoimento', $this->formCadDepoimento);
        
        $tpAlbumPsq = $config['constsTpAlbumPsq'];
        $stAlbumPsq = $config['constsStAlbumPsq'];
        
        //Formulario de Pesquisa de Valor Depoimentos
        $this->formPsqAlbum = new AlbumFotoForms\AlbumPsqForm($tpAlbumPsq, $stAlbumPsq);
        $this->_view->setVariable('formPsqAlbum', $this->formPsqAlbum);

        $tpAlbumCad = $config['constsTpAlbumCad'];
        $stAlbumCad = $config['constsStAlbumCad'];
        
        //Formulario de Cadastro de Valor Depoimento
        $this->formCadAlbum = new AlbumFotoForms\AlbumCadForm($tpAlbumCad, $stAlbumCad);
        $this->_view->setVariable('formCadAlbum', $this->formCadAlbum);
        
        //Formulario de Cadastro de Valor Depoimento
        $this->formCadFoto = new AlbumFotoForms\FotoCadForm();
        $this->_view->setVariable('formCadFoto', $this->formCadFoto);

        $stPagamentoPsq = $config['constsStPagamentoPsq'];
        $tpPagamentoPsq = $config['constsTpPagamentoPsq'];
        $tpPlanoPsq = $config['constsTpPlanoPsq'];

        //Formulario de Pesquisa de Pagamentos
        $this->formPsqPagamento = new PagamentoForms\PagamentoPsqForm($stPagamentoPsq, $tpPagamentoPsq, $tpPlanoPsq);
        $this->_view->setVariable('formPsqPagamento', $this->formPsqPagamento);

        $stPagamento = $config['constsStPagamentoCad'];

        //Formulario de Cadastro de Pagamento
        $this->formCadPagamento = new PagamentoForms\PagamentoCadForm($stPagamento);
        $this->_view->setVariable('formCadPagamento', $this->formCadPagamento);

        return $this->_view;
    }

    /**
     * Pesquisar Cliente Action
     * @return type
     */
    public function pesquisarClienteAction() {
        $service = $this->getServiceLocator()->get($this->service);
        $pagina = $this->getEvent()->getRouteMatch()->getParam('page');
        $post = $this->getRequest()->getPost()->toArray();
        $itens = $this->itemForPage;

        $this->_view->setVariable('lista', $service->listarClientes($post, $pagina, $itens));
        $this->_view->setTerminal(true);

        return $this->_view;
    }

    /**
     * Salvar Action
     * @return JsonModel
     */
    public function salvarAction() {
        $post = $this->getRequest()->getPost()->toArray();
        $data = $this->prepararDados($post);
        $service = $this->getServiceLocator()->get($this->service);
        $stDadosCliente = $this->validarDadosCliente($post, $service);
        if ($stDadosCliente['tipoMsg'] === "S") {
            $arrCliente = $service->salvarCliente($data);
            if ($arrCliente) {
                $tipoMsg = "S";
                $textoMsg = $this->exibirMsg($post);
            } else {
                $tipoMsg = "E";
                $textoMsg = "Erro ao tentar cadastrar o Cliente! Tente mais tarde.";
            }
        } else {
            $tipoMsg = $stDadosCliente['tipoMsg'];
            $textoMsg = $stDadosCliente['textoMsg'];
        }

        $dados = array();
        if ($arrCliente) {
            $dados['idCliente'] = $arrCliente->getIdCliente();
        }
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;

        $result = new JsonModel($dados);
        return $result;
    }
    
    /**
     * Salvar Li Concordo Action
     * @return JsonModel
     */
    public function salvarLiConcordoAction() {
        $post = $this->getRequest()->getPost()->toArray();
        if ($post['stLiConcordo'] == "on") {
            $post['stLiConcordo'] = 1;
        } else {
            $post['stLiConcordo'] = NULL;
        }
        $service = $this->getServiceLocator()->get($this->service);
        $arrCliente = $service->salvarCliente($post);
        if ($arrCliente) {
            $tipoMsg = "S";
            $textoMsg = $this->exibirMsg($post);
        } else {
            $tipoMsg = "E";
            $textoMsg = "Erro ao tentar cadastrar o Cliente! Tente mais tarde.";
        }

        $dados = array();
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;

        $result = new JsonModel($dados);
        return $result;
    }
    
    /**
     * Salvar Li Concordo Action
     * @return JsonModel
     */
    public function salvarDataVencimentoAction() {
        $post = $this->getRequest()->getPost()->toArray();
        $service = $this->getServiceLocator()->get($this->service);
        if ($post['dtVencimento'] != "") {
            $post['dtVencimento'] = \DateTime::createFromFormat('d/m/Y', $post['dtVencimento']);
        }
        $arrCliente = $service->salvarCliente($post);
        if ($arrCliente) {
            $tipoMsg = "S";
            $textoMsg = $this->exibirMsg($post);
        } else {
            $tipoMsg = "E";
            $textoMsg = "Erro ao tentar cadastrar o Cliente! Tente mais tarde.";
        }

        $dados = array();
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;

        $result = new JsonModel($dados);
        return $result;
    }

    /**
     * Validade Dados do Cliente
     * 
     * @param type $post
     * @param type $service
     * @return string
     */
    private function validarDadosCliente($post, $service) {
        $tipoMsg = "S";
        $textoMsg = "Dados do Cliente validado com sucesso!!!";
        $param = array('idCliente' => $post['idCliente'], 'noCliente' => $post['noCliente']);
        $stNomeCliente = $service->verificarNomeClienteExistente($param);
        if (!$stNomeCliente) {
            $stValidaCpf = $this->Documento()->validarCpf($post['nuCpf']);
            if ($stValidaCpf) {
                $param = array('idCliente' => $post['idCliente'], 'nuCpf' => $post['nuCpf']);
                $stCpfExistente = $service->verificarCpfClienteExistente($param);
                if (!$stCpfExistente) {
                    $stDtNascimento = $this->Data()->validarData($post['dtNascimento']);
                    if ($stDtNascimento) {
                        $dtNascimento = $this->Data()->dateToDB($post['dtNascimento'], FALSE);
                        $nuIdadeCliente = $this->Data()->getAge(strtotime($dtNascimento),strtotime(date('Y-m-d')));
                        if ($nuIdadeCliente < 18) {
                            $tipoMsg = "W";
                            $textoMsg = "Data de Nascimento menor que 18 anos! Tente mais tarde.";
                        }
                        
                    } else {
                        $tipoMsg = "W";
                        $textoMsg = "Data de Nascimento inválida! Por favor informe outro.";
                    }
                        
                } else {
                    $tipoMsg = "W";
                    $textoMsg = "Nº do CPF já cadastrado no sistema! Por favor informe outro.";
                }
            } else {
                $tipoMsg = "W";
                $textoMsg = "Nº do CPF inválido! Por favor informe outro.";
            }
        } else {
            $tipoMsg = "W";
            $textoMsg = "Nome do Cliente já cadastrado no sistema! Por favor informe outro.";
        }

        $dados = array();
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;

        return $dados;
    }
    
    private function exibirMsg($post) {
        if ($post['idCliente']) {
            $textoMsg = "Cliente atualizado com sucesso!";
        } else {
            $textoMsg = "Cliente cadastrado com sucesso!";
        }
        return $textoMsg;
    }

    /**
     * Selecionar Action
     * @return JsonModel
     */
    public function selecionarAction() {
        $id = $this->getRequest()->getPost()->toArray();
        $service = $this->getServiceLocator()->get($this->service);
        $repository = $service->selecionarCliente($id);
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
     * Carregar Dados do Cliente
     * @param type $repository
     * @return type
     */
    private function carregarDados($repository) {
        $array['idCliente'] = $repository->getIdCliente();
        $array['tpCliente'] = $repository->getTpCliente();
        $array['stCliente'] = $repository->getStCliente();
        $array['stLiConcordo'] = $repository->getStLiConcordo();
        $array['stExclusividade'] = $repository->getStExclusividade();
        $array['noCliente'] = $repository->getNoCliente();
        $array['nuCpf'] = $repository->getNuCpf();
        $array['tpSexo'] = $repository->getTpSexo();
        $array['nuCep'] = $repository->getNuCep();
        $array['dsEndereco'] = $repository->getDsEndereco();
        $array['sgUf'] = $repository->getSgUf();
        $array['noCidade'] = $repository->getNoCidade();
        $array['nuTelefone'] = $repository->getNuTelefone();
        $array['dtHrCadastro'] = $repository->getDtHrCadastro()->format('d/m/Y');
        if ($repository->getDtVencimento()) {
            $array['dtVencimento'] = $repository->getDtVencimento()->format('d/m/Y');
            $stVencimento = $this->verificarVencimento($repository);
        } else {
            $array['dtVencimento'] = NULL;
            $stVencimento = FALSE;
        }
        if ($repository->getDtNascimento()) {
            $array['dtNascimento'] = $repository->getDtNascimento()->format('d/m/Y');
        } else {
            $array['dtNascimento'] = NULL;
        }
        $array['stVencimento'] = $stVencimento;
        return $array;
    }
    
    private function verificarVencimento($repository) {
        $dt_atual = date("Y-m-d");
        $timestamp_dt_atual = strtotime($dt_atual);

        $dt_expira = $repository->getDtVencimento()->format('Y-m-d');
        $timestamp_dt_expira = strtotime($dt_expira);
        if ($timestamp_dt_atual > $timestamp_dt_expira) {
            $stVencimento = FALSE;
        } else {
            $stVencimento = TRUE;
        }
        return $stVencimento;
    }

    /**
     * Preparar dados do usuário para Inclusão/Atualização
     * @param type $data
     * @return type
     */
    private function prepararDados($data) {
        $data['dsEndereco'] = $data['dsEnderecoCliente'];
        $data['nuTelefone'] = $data['nuTelefoneCliente'];
        $data['sgUf'] = $data['sgUfCliente'];
        $data['noCidade'] = $data['noCidadeCliente'];
        if ($data['dtVencimentoCliente'] != "") {
            $data['dtVencimento'] = \DateTime::createFromFormat('d/m/Y', $data['dtVencimentoCliente']);
        }
        if ($data['dtNascimento'] != "") {
            $data['dtNascimento'] = \DateTime::createFromFormat('d/m/Y', $data['dtNascimento']);
        } else {
            unset($data['dtNascimento']);
        }
        if (empty($data['idCliente'])) {
            $data['dtHrCadastro'] = new \DateTime("now");
            unset($data['idCliente']);
        }
        return $data;
    }

    private function carregarSelectCidade($tpForm) {
        $repository = $this->em->getRepository("\Cidade\Entity\CidadeEntity");
        $entities = $repository->findBy(array('sgUf' => 'DF'), array('noCidade' => 'ASC'));
        if ($tpForm == 1) {
            $valor = "-- Todas --";
        } else {
            $valor = "-- Selecione --";
        }
        $array[NULL] = $valor;
        foreach ($entities as $entity) {
            if ($entity->getIdCidade() != "") {
                $array[$entity->getIdCidade()] = utf8_encode($entity->getNoCidade());
            }
        }
        return $array;
    }

    public function carregarSelectClienteAction() {
        $service = $this->getServiceLocator()->get($this->service);
        $serviceAnunciante = $this->getServiceLocator()->get("\Anunciante\Service\AnuncianteService");
        $param['tpClientePsq'] = "T";
        $param['stClientePsq'] = "T";
        $param['tpSexoPsq'] = "T";
        $entities = $service->listarClientesHome($param);
        $array = array();
        foreach ($entities as $entity) {
            $idCliente = $entity['idCliente'];
            $noCliente = $entity['noCliente'];
            $dsTpCliente = "Sócio Clube Luxúria";
            if ($entity['tpCliente'] == 1) {
                $anunciante = $serviceAnunciante->pegarNomeAnuncianteCliente($idCliente);
                $noCliente = $anunciante['noArtistico'];
                $dsTpCliente = "Anunciante Clube Luxúria";
            }
            $array[$entity['idCliente']] = $noCliente . " - " . $dsTpCliente;
        }
        $result = new JsonModel($array);
        return $result;
    }

}