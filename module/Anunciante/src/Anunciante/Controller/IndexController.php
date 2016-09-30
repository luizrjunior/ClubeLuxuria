<?php

namespace Anunciante\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
//FORMS
use Cliente\Form as ClienteForm;
use Usuario\Form as UsuarioForm;
use Anunciante\Form as AnuncianteForm;
use AlbumFoto\Form as AlbumFotoForm;
use Video\Form as VideoForm;
use Cache\Form as CacheForm;
use Depoimento\Form as DepoimentoForm;
use ConfigPaginaCliente\Form as ConfigPaginaClienteForm;
use Pagamento\Form as PagamentoForms;
//SESSION
use Zend\Session\Container;

class IndexController extends AbstractController {

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
    
    public function __construct() {
        $this->service = 'Anunciante\Service\AnuncianteService';
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

        $sessao = new Container();
        $this->_view->setVariable('sessao', $sessao);
        
        //Instanciar e Setar o Form de Pesquisa
        $sgUfPsq = $config['constsSgUfPsq'];
        $stClientePsq = $config['constsStAnunciantePsq'];
        $tpClientePsq = $config['constsTpAnunciantePsq'];

        //Formulario de Pesquisa de Clientes
        $this->formPsqAnunciante = new AnuncianteForm\AnunciantePsqForm($sgUfPsq, $stClientePsq, $tpClientePsq);
        $this->_view->setVariable('formPsqAnunciante', $this->formPsqAnunciante);

        //Instanciar e Setar o Form de Cadastro
        $sgUfCad = $config['constsSgUfCad'];
        $stClienteCad = $config['constsStClienteCad'];
        $tpClienteCad = $config['constsTpClienteCad'];
        $tpSexoCad = $config['constsTpSexoCad'];

        //Formulario de Cadastro de Cliente
        $this->formCadCliente = new ClienteForm\ClienteCadForm($sgUfCad, $stClienteCad, $tpClienteCad, $tpSexoCad);
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
        $this->formCadClienteCaracteristica = new ClienteForm\ClienteCaracteristicaCadForm();
        $this->_view->setVariable('formCadClienteCaracteristica', $this->formCadClienteCaracteristica);

        //Formulario de Cadastro de Configuracoes Pagina Cliente
        $this->formCadConfigPaginaCliente = new ConfigPaginaClienteForm\ConfigPaginaClienteCadForm();
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

        $stPagamentoPsq = $config['constsStPagamentoPsq'];
        $tpPagamentoPsq = $config['constsTpPagamentoPsq'];

        //Formulario de Pesquisa de Pagamentos
        $this->formPsqPagamento = new PagamentoForms\PagamentoPsqForm($stPagamentoPsq, $tpPagamentoPsq);
        $this->_view->setVariable('formPsqPagamento', $this->formPsqPagamento);

        $stPagamento = $config['constsStPagamentoCad'];

        //Formulario de Cadastro de Pagamento
        $this->formCadPagamento = new PagamentoForms\PagamentoCadForm($stPagamento);
        $this->_view->setVariable('formCadPagamento', $this->formCadPagamento);

        return $this->_view;
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

    /**
     * Pesquisar Cliente Action
     * @return type
     */
    public function pesquisarAnuncianteAction() {
        $service = $this->getServiceLocator()->get($this->service);
        $pagina = $this->getEvent()->getRouteMatch()->getParam('page');
        $post = $this->getRequest()->getPost()->toArray();
        $itens = $this->itemForPage;

        $this->_view->setVariable('lista', $service->listarAnunciantesPaginado($post, $pagina, $itens));
        $this->_view->setTerminal(true);

        return $this->_view;
    }

    /**
     * Salvar Action
     * @return JsonModel
     */
    public function salvarAction() {
        $post = $this->getRequest()->getPost()->toArray();
        $service = $this->getServiceLocator()->get($this->service);

        $idAnunciante = $this->verificarAnunciante($post, $service);
        if ($idAnunciante) {
            $post['idAnunciante'] = $idAnunciante;
        }
        $post['idCliente'] = $post['idClienteAnunciante'];
        $post['idCidade'] = $post['idCidadeAnunciante'];
        $post['nuTelefone'] = $post['nuTelefoneAnunciante'];
        unset($post['idClienteAnunciante']);
        unset($post['idCidadeAnunciante']);
        unset($post['nuTelefoneAnunciante']);
        unset($post['sgUfAnunciante']);
        $post['dtAlteracao'] = new \DateTime("now");
        
        $param = array('idAnunciante' => $post['idAnunciante'], 'noArtistico' => $post['noArtistico']);
        $stNomeArtistico = $service->verificarNomeArtisticoExistente($param);
        if (!$stNomeArtistico) {
            $arrAnunciante = $service->salvarAnunciante($post);
            if ($arrAnunciante) {
                $tipoMsg = "S";
                if ($post['idAnunciante']) {
                    $textoMsg = "Dados de Anunciante atualizado com sucesso!";
                } else {
                    $textoMsg = "Dados de Anunciante cadastrado com sucesso!";
                }
            } else {
                $tipoMsg = "E";
                $textoMsg = "Erro ao tentar cadastrar os Dados de Anunciante! Tente mais tarde.";
            }

        } else {
            $tipoMsg = "W";
            $textoMsg = "Nome Artístico já cadastrado no sistema! Por favor informe outro.";
        }

        $dados = array();
        $dados['idCliente'] = $post['idCliente'];
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
        $post = $this->getRequest()->getPost()->toArray();
        $service = $this->getServiceLocator()->get($this->service);

        $param = array('idCliente' => $post['idCliente']);
        $repository = $service->selecionarAnuncianteBy($param);

        if ($repository[0]) {
            $tipoMsg = "S";
            $textoMsg = "Registro encontrado!";
            $dados = $this->carregarDados($repository[0]);
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
     * Verificar Anunciante
     * @param type $post
     * @param type $service
     * @return type $idAnunciante
     */
    private function verificarAnunciante($post, $service) {
        $idAnunciante = NULL;
        $param = array('idCliente' => $post['idClienteAnunciante']);
        $arrAnunciante = $service->selecionarAnuncianteBy($param);
        if ($arrAnunciante[0]) {
            $idAnunciante = $arrAnunciante[0]->getIdAnunciante();
        }
        return $idAnunciante;
    }

    /**
     * Carregar Dados do Cliente Usuario
     * @param type $repository
     * @return type $array
     */
    private function carregarDados($repository) {
        $array['idAnunciante'] = $repository->getIdAnunciante();
        $array['idClienteAnunciante'] = $repository->getIdCliente()->getIdCliente();
        $array['tpAnunciante'] = $repository->getTpAnunciante();
        $array['stAnunciante'] = $repository->getStAnunciante();
        $array['noArtistico'] = $repository->getNoArtistico();
        $array['nuTelefone'] = $repository->getNuTelefone();
        $array['tpCabeloCor'] = $repository->getTpCabeloCor();
        $array['stAceitaCartao'] = $repository->getStAceitaCartao();
        $array['dsUrlSite'] = $repository->getDsUrlSite();
        $array['sgUf'] = $repository->getIdCidade()->getSgUf();
        $array['idCidade'] = $repository->getIdCidade()->getIdCidade();
        $array['nuLatitude'] = $repository->getNuLatitude();
        $array['nuLongitude'] = $repository->getNuLongitude();
        $array['dsIdade'] = $repository->getDsIdade();
        $array['dsApelido'] = $repository->getDsApelido();
        $array['dsCabelos'] = $repository->getDsCabelos();
        $array['dsOlhos'] = $repository->getDsOlhos();
        $array['dsLabios'] = $repository->getDsLabios();
        $array['dsAltura'] = $repository->getDsAltura();
        $array['dsPeso'] = $repository->getDsPeso();
        $array['dsBusto'] = $repository->getDsBusto();
        $array['dsCintura'] = $repository->getDsCintura();
        $array['dsQuadril'] = $repository->getDsQuadril();
        $array['dsHobby'] = $repository->getDsHobby();
        $array['dsComidas'] = $repository->getDsComidas();
        $array['dsBebidas'] = $repository->getDsBebidas();
        $array['dsFrase'] = $repository->getDsFrase();
        $array['dsFrase1'] = $repository->getDsFrase1();
        $array['dsFrase2'] = $repository->getDsFrase2();
        $array['dsFrase3'] = $repository->getDsFrase3();
        return $array;
    }

    /**
     * Pesquisar Anunciantes Home Action
     * @return type
     */
    public function pesquisarAnuncianteHomeAction() {
        $service = $this->getServiceLocator()->get($this->service);
        $pagina = $this->getEvent()->getRouteMatch()->getParam('page');
        $post = $this->getRequest()->getPost()->toArray();
        $post['tpAnunciantePsq'] = 1;//Acompanhante de Luxo
        $post['stAnunciantePsq'] = array(1,3,4);//1-Atividade;3-Viajando;4-Férias;
        $itens = 20;

        $this->_view->setVariable('lista', $service->listarAnunciantesHomePaginado($post, $pagina, $itens));
        $this->_view->setTerminal(true);

        return $this->_view;
    }

}
