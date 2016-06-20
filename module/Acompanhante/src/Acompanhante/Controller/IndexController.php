<?php

namespace Acompanhante\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
//SESSION
use Zend\Session\Container;
use Pagamento\Form as PagamentoForms;

class IndexController extends AbstractController {

    public function __construct() {
        $this->service = 'Cliente\Service\ClienteService';
        $this->_view = new ViewModel();
    }

    /**
     * Index
     * @return type
     */
    public function indexAction() {
        $idUsuarioPerfil = NULL;
        $tpUsuario = NULL;
        if ($this->identity()) {
            $idUsuarioPerfil = $this->identity()->getIdUsuario();
            $tpUsuario = $this->identity()->getTpUsuario();
        }
        if ($tpUsuario == 3 || $tpUsuario == 4) {
            $clienteUsuario = $this->pegarIdClienteUsuarioLogado($idUsuarioPerfil);
            $stVencimento = FALSE;
            if ($clienteUsuario[0]->getIdCliente()->getDtVencimento()) {
                $stVencimento = $this->verificarVencimento($clienteUsuario[0]);
            }
            if (!$stVencimento) {
                return $this->redirect()->toRoute('perfil');
            }
        }
        
        $sessao = new Container();
        if (!$sessao->sgUfSessionPsq) {
            return $this->redirect()->toRoute('application');
        }
        $idCliente = $this->getEvent()->getRouteMatch()->getParam('id');
        $arCliente = $this->pegarDadosCliente($idCliente);
        $stCliente = $this->verificarVencimento($arCliente->getDtVencimento()->format('Y-m-d'));
        $this->_view->setVariable('stCliente', $stCliente);
        if ($stCliente) {
            $idUsuarioLogado = $this->pegarIdUsuarioLogado();
            $this->adicionarVisualizacaoPagina($idCliente, $idUsuarioLogado);
            $anunciante = $this->pegarDadosAnunciante($idCliente);
            $this->_view->setVariable('idAnunciante', $anunciante[0]->getIdAnunciante());
            $cliente = $this->selecionarCliente($idCliente);
            $this->_view->setVariables($cliente);
        }
        return $this->_view;
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

    protected function pegarDadosClienteLogado($idCliente) {
        $service = $this->getServiceLocator()->get($this->service);
        $result = $service->selecionarCliente($idCliente);
        return $result;
    }
    
    protected function pegarIdClienteUsuarioLogado($idUsuario) {
        $service = $this->getServiceLocator()->get('Cliente\Service\ClienteUsuarioService');
        $param = array('idUsuario' => $idUsuario);
        $repository = $service->selecionarClienteUsuarioBy($param);
        return $repository;
    }

    protected function pegarDadosAnunciante($idCliente) {
        $service = $this->getServiceLocator()->get('Anunciante\Service\AnuncianteService');
        $param = array('idCliente' => $idCliente);
        $repository = $service->selecionarAnuncianteBy($param);
        return $repository;
    }

    protected function pegarDadosCliente($idCliente) {
        $service = $this->getServiceLocator()->get($this->service);
        $result = $service->selecionarCliente($idCliente);
        return $result;
    }
    
    /**
     * Pegar IdUsuario Logado
     * @return type
     */
    protected function pegarIdUsuarioLogado() {
        if ($this->identity()) {
            $idUsuarioLogado = $this->identity()->getIdUsuario();
        } else {
            $idUsuarioLogado = null;
        }
        return $idUsuarioLogado;
    }

    /**
     * Selecionar Cliente
     * @param type $idCliente
     * @return type
     */
    protected function selecionarCliente($idCliente) {
        $service = $this->getServiceLocator()->get($this->service);
        $repository = $service->selecionarCliente($idCliente);
        if ($repository) {
            $dados = $this->carregarDadosCliente($repository);
            return $dados;
        } else {
            return $this->redirect()->toRoute('application', array('controller' => 'index', 'action' => 'home'));
        }
    }

    /**
     * Selecionar Frases do Cliente
     * @param type $idCliente
     * @return type
     */
    protected function selecionarConfigPaginaCliente($idCliente) {
        $service = $this->getServiceLocator()->get('ConfigPaginaCliente\Service\ConfigPaginaClienteService');
        $param = array('idCliente' => $idCliente);
        $repository = $service->selecionarConfigPaginaClienteBy($param);
        $dados = array();
        if ($repository) {
            $dados = $this->carregarConfigPaginaCliente($repository[0]);
        }
        return $dados;
    }

    /**
     * Carregar Dados do Cliente Usuario
     * @param type $repository
     * @return type $array
     */
    private function carregarConfigPaginaCliente($repository) {
        $array['stInfoCliente'] = $repository->getStInfoCliente();
        $array['stFrase1'] = $repository->getStFrase1();
        $array['stFrase2'] = $repository->getStFrase2();
        $array['stFrase3'] = $repository->getStFrase3();
        $array['stServico'] = $repository->getStServico();
        $array['stAtendimento'] = $repository->getStAtendimento();
        $array['stCartoes'] = $repository->getStCartoes();
        $array['stUrlSite'] = $repository->getStUrlSite();
        $array['stDepoimentos'] = $repository->getStDepoimentos();
        $array['stCaches'] = $repository->getStCaches();
        $array['stVideos'] = $repository->getStVideos();
        $array['stRota'] = $repository->getStRota();
        return $array;
    }

    /**
     * Selecionar Frases do Cliente
     * @param type $idCliente
     * @return type
     */
    protected function selecionarAnunciante($idCliente) {
        $service = $this->getServiceLocator()->get('Anunciante\Service\AnuncianteService');
        $param = array('idCliente' => $idCliente);
        $repository = $service->selecionarAnuncianteBy($param);
        $dados = array();
        if ($repository) {
            $dados = $this->carregarAnunciante($repository[0]);
        }
        return $dados;
    }

    /**
     * Carregar Dados do Anunciante
     * @param type $repository
     * @return type $array
     */
    private function carregarAnunciante($repository) {
        $array['idAnunciante'] = $repository->getIdAnunciante();
        $array['tpAnunciante'] = $repository->getTpAnunciante();
        $array['stAnunciante'] = $repository->getStAnunciante();
        $array['noArtistico'] = $repository->getNoArtistico();
        $array['nuTelefone'] = $repository->getNuTelefone();
        $array['tpCabeloCor'] = $repository->getTpCabeloCor();
        $array['stAceitaCartao'] = $repository->getStAceitaCartao();
        $array['dsUrlSite'] = $repository->getDsUrlSite();
        $array['sgUf'] = $repository->getIdCidade()->getSgUf();
        $array['noCidade'] = $repository->getIdCidade()->getNoCidade();
        $array['nuLatitude'] = $repository->getNuLatitude();
        $array['nuLongitude'] = $repository->getNuLongitude();
        $array['dsFrase1'] = $repository->getDsFrase1();
        $array['dsFrase2'] = $repository->getDsFrase2();
        $array['dsFrase3'] = $repository->getDsFrase3();
        return $array;
    }

    /**
     * Carregar Caracteristicas
     * @return JsonModel
     */
    private function carregarCaracteristicas($idCliente, $tpCaracteristica) {
        $this->getEm();
        $post['idCliente'] = $idCliente;
        $repository = $this->em->getRepository("\Caracteristicas\Entity\CaracteristicasEntity");
        $entities = $repository->findBy(array('tpCaracteristica' => $tpCaracteristica), array('noCaracteristica' => 'ASC'));
        $serviceClienteCaracteristica = $this->getServiceLocator()->get("Cliente\Service\ClienteCaracteristicaService");
        $array = array();
        foreach ($entities as $entity) {
            if ($entity->getIdCaracteristica() != "") {
                $post['idCaracteristica'] = $entity->getIdCaracteristica();
                $stChecked = $this->verificarClienteCaracteristica($post, $serviceClienteCaracteristica);
                if ($stChecked != "") {
                    $array[] = $entity->getNoCaracteristica();
                }
            }
        }
        return $array;
    }

    /**
     * Verificar Cliente Caracteristica
     * @param type $post
     * @param type $serviceClienteCaracteristica
     * @return string
     */
    private function verificarClienteCaracteristica($post, $serviceClienteCaracteristica) {
        $dsChecked = "";
        $param = array('idCliente' => $post['idCliente'], 'idCaracteristica' => $post['idCaracteristica']);
        $arrClienteCaracteristica = $serviceClienteCaracteristica->selecionarClienteCaracteristicaBy($param);
        if ($arrClienteCaracteristica[0]) {
            $dsChecked = "checked";
        }
        return $dsChecked;
    }

    /**
     * Carregar Caches
     * @param type $idCliente
     * @return type
     */
    private function carregarCaches($idCliente) {
        $this->getEm();
        $repository = $this->em->getRepository("\Cache\Entity\CacheEntity");
        $entities = $repository->findBy(array('idCliente' => $idCliente), array('idCache' => 'ASC'));
        $i = 1;
        $array = array();
        foreach ($entities as $entity) {
            $array[$i]['noCache'] = $entity->getNoCache();
            $array[$i]['dsCache'] = $entity->getDsCache();
            $array[$i]['dsValor'] = $entity->getDsValor();
            $i++;
        }

        return $array;
    }

    /**
     * Carregar Videos
     * @param type $idCliente
     * @return string
     */
    private function carregarVideos($idCliente) {
        $this->getEm();
        $repository = $this->em->getRepository("\Video\Entity\VideoEntity");
        $entities = $repository->findBy(array('idCliente' => $idCliente), array('idVideo' => 'ASC'));
        $i = 1;
        $array = array();
        foreach ($entities as $entity) {
            $array[$i]['tiVideo'] = $entity->getTiVideo();
            $array[$i]['tpVideo'] = $entity->getTpVideo();
            $array[$i]['dsVideo'] = $entity->getDsVideo();
            $i++;
        }

        return $array;
    }

    /**
     * Pegar ID Album Principal
     * @param type $idCliente
     * @return type
     */
    private function pegarIdAlbumPrincipal($idCliente) {
        $this->getEm();
        $repository = $this->em->getRepository("\AlbumFoto\Entity\AlbumEntity");
        $entities = $repository->findBy(array('idCliente' => $idCliente, 'tpAlbum' => 1), array('idAlbum' => 'ASC'));
        $i = 1;
        $array = array();
        foreach ($entities as $entity) {
            $array['idAlbum'] = $entity->getIdAlbum();
            $i++;
        }
        return $array;
    }

    /**
     * Carregar Fotos Horizontais
     * @param type $idCliente
     * @return string
     */
    private function carregarFotosHorizontais($idCliente) {
        $idAlbum = $this->pegarIdAlbumPrincipal($idCliente);
        $this->getEm();
        $repository = $this->em->getRepository("\AlbumFoto\Entity\FotoEntity");
        $entities = $repository->findBy(array('idAlbum' => $idAlbum['idAlbum'], 'tpFoto' => 3), array('idFoto' => 'ASC'));
        $i = 1;
        $array = array();
        foreach ($entities as $entity) {
            $diretorio = "/storage/fotos/" . $idCliente . "/" . $idAlbum['idAlbum'] . "/";
            $array[$i]['dsArquivo'] = $diretorio . $entity->getDsArquivo();
            $i++;
        }
        return $array;
    }

    /**
     * Carregar Galeria de Fotos
     * @param type $idCliente
     * @return string
     */
    private function carregarGaleriaFotos($idCliente) {
        $param = array();
        $param['idClientePsq'] = $idCliente;
        $param['tpAlbumPsq'] = 2;
        $service = $this->getServiceLocator()->get('AlbumFoto\Service\FotoService');
        $listaFotos = $service->listarFotos($param);
        
        return $listaFotos;
    }

    /**
     * Carregar Fotos Verticais
     * @param type $idCliente
     * @return string
     */
    private function carregarFotosVerticais($idCliente) {
        $idAlbum = $this->pegarIdAlbumPrincipal($idCliente);
        $this->getEm();
        $repository = $this->em->getRepository("\AlbumFoto\Entity\FotoEntity");
        $entities = $repository->findBy(array('idAlbum' => $idAlbum['idAlbum'], 'tpFoto' => 4), array('idFoto' => 'ASC'));
        $i = 1;
        $array = array();
        foreach ($entities as $entity) {
            $diretorio = "/storage/fotos/" . $idCliente . "/" . $idAlbum['idAlbum'] . "/";
            $array[$i]['idFoto'] = $entity->getIdFoto();
            $array[$i]['dsArquivo'] = $diretorio . $entity->getDsArquivo();
            $i++;
        }
        return $array;
    }

    /**
     * Adicionar Visualizacao Pagina
     * @param type $idCliente
     * @param type $idUsuario
     */
    private function adicionarVisualizacaoPagina($idCliente, $idUsuario) {
        $service = $this->getServiceLocator()->get('Visualizacao\Service\VisualizacaoService');
        $param = array('idCliente' => $idCliente, 'idUsuario' => $idUsuario, 'dtHrVisualizacao' => new \DateTime("now"));
        $service->salvarVisualizacao($param);
    }
    
    /**
     * Verificar se a Página já está nos Favoritos do Usuário
     * @return JsonModel
     */
    public function verificarFavoritosAction() {
        $post = $this->getRequest()->getPost()->toArray();
        $this->getEm();
        $idUsuarioLogado = $this->pegarIdUsuarioLogado();
        $repository = $this->em->getRepository("\Favoritos\Entity\FavoritosEntity");
        $entities = $repository->findBy(array('idAnunciante' => $post['idAnunciante'], 'idUsuario' => $idUsuarioLogado), array('idFavoritos' => 'ASC'));
        $dados = array();
        $dados['tipoMsg'] = "S";
        foreach ($entities as $entity) {
            $dados['idFavoritos'] = $entity->getIdFavoritos();
            $dados['stNotificacao'] = $entity->getStNotificacao();
        }
        
        $result = new JsonModel($dados);
        return $result;
    }
    
    /**
     * Adicionar Pagina aos Favoritos do Usuário
     * @return JsonModel
     */
    public function adicionarFavoritosAction() {
        $post = $this->getRequest()->getPost()->toArray();
        
        $idUsuarioLogado = $this->pegarIdUsuarioLogado();
        $service = $this->getServiceLocator()->get('Favoritos\Service\FavoritosService');
        $param = array('idAnunciante' => (int) $post['idAnunciante'], 'idUsuario' => $idUsuarioLogado, 'stNotificacao' => 1);
        $repository = $service->salvarFavoritos($param);
        
        $dados = array();
        $dados['tipoMsg'] = "S";
        $dados['idFavoritos'] = $repository->getIdFavoritos();
        $dados['stNotificacao'] = $repository->getStNotificacao();
        
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
    
    /**
     * Alterar Recebimento de Notificações do Cliente ao Usuário
     * @return JsonModel
     */
    public function alterarNotificacaoAction() {
        $post = $this->getRequest()->getPost()->toArray();
        if ($post['stNotificacao'] == 1) {
            $stNotificacao = 2;
        } else {
            $stNotificacao = 1;
        }
        $idUsuarioLogado = $this->pegarIdUsuarioLogado();
        $service = $this->getServiceLocator()->get('Favoritos\Service\FavoritosService');
        $param = array('idFavoritos' => (int) $post['idFavoritos'], 'idAnunciante' => (int) $post['idAnunciante'], 'idUsuario' => $idUsuarioLogado, 'stNotificacao' => $stNotificacao);
        $service->salvarFavoritos($param);
        
        $dados = array();
        $dados['tipoMsg'] = "S";
        
        $result = new JsonModel($dados);
        return $result;
    }

    /**
     * Verificar se o Usuário Curtiu a Página
     * @return JsonModel
     */
    public function verificarCurtidasAction() {
        $post = $this->getRequest()->getPost()->toArray();
        $this->getEm();
        $idUsuarioLogado = $this->pegarIdUsuarioLogado();
        $repository = $this->em->getRepository("\Curtidas\Entity\CurtidasEntity");
        $entities = $repository->findBy(array('idCliente' => $post['idCliente'], 'idUsuario' => $idUsuarioLogado), array('idCurtidas' => 'ASC'));
        $dados = array();
        $dados['tipoMsg'] = "S";
        foreach ($entities as $entity) {
            $dados['idCurtidas'] = $entity->getIdCurtidas();
        }
        $result = new JsonModel($dados);
        return $result;
    }
    
    /**
     * Curtir Página do Cliente
     * @return JsonModel
     */
    public function curtirPaginaAction() {
        $post = $this->getRequest()->getPost()->toArray();
        
        $idUsuarioLogado = $this->pegarIdUsuarioLogado();
        $service = $this->getServiceLocator()->get('Curtidas\Service\CurtidasService');
        $param = array('idCliente' => (int) $post['idCliente'], 'idUsuario' => $idUsuarioLogado, 'dtHrCurtida' => new \DateTime("now"));
        $repository = $service->salvarCurtidas($param);
        
        $dados = array();
        $dados['tipoMsg'] = "S";
        $dados['idCurtidas'] = $repository->getIdCurtidas();
        
        $result = new JsonModel($dados);
        return $result;
    }

    /**
     * Descurtir Página do Cliente
     * @return JsonModel
     */
    public function descurtirPaginaAction() {
        $post = $this->getRequest()->getPost()->toArray();
        $service = $this->getServiceLocator()->get('Curtidas\Service\CurtidasService');
        $repository = $service->selecionarCurtidas($post['idCurtidas']);
        if ($repository) {
            if ($service->removerCurtidas($repository)) {
                $tipoMsg = "S";
                $textoMsg = "Acompanhante removida dos Favoritos com sucesso!";
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
     * Verificar se o Usuário Curtiu a Página
     * @return JsonModel
     */
    private function pegarQtdeCurtidasFoto($idFoto) {
        $this->getEm();
        $repository = $this->em->getRepository("\Curtidas\Entity\CurtidasEntity");
        $entities = $repository->findBy(array('idFoto' => $idFoto), array('idCurtidas' => 'ASC'));
        return count($entities);
    }
    
    /**
     * Verificar se o Usuário Curtiu a Página
     * @return JsonModel
     */
    public function carregarCurtidasFotoAction() {
        $post = $this->getRequest()->getPost()->toArray();
        $this->getEm();
        $repository = $this->em->getRepository("\Curtidas\Entity\CurtidasEntity");
        $entities = $repository->findBy(array('idFoto' => $post['idFoto']), array('idCurtidas' => 'ASC'));
        
        $dados = array();
        $dados['tipoMsg'] = "S";
        
        foreach ($entities as $entity) {
            $dados[]['noUsuario'] = $entity->getIdUsuario()->getNoUsuario() . " - " . $entity->getDtHrCurtida()->format("d/m/Y H:i:s");
        }
        
        $result = new JsonModel($dados);
        return $result;
    }
    
    /**
     * Curtir Foto do Cliente
     * @return JsonModel
     */
    public function curtirFotoAction() {
        $post = $this->getRequest()->getPost()->toArray();
        $idUsuarioLogado = $this->pegarIdUsuarioLogado();
        $service = $this->getServiceLocator()->get('Curtidas\Service\CurtidasService');
        $param = array('idFoto' => (int) $post['idFoto'], 'idUsuario' => $idUsuarioLogado, 'dtHrCurtida' => new \DateTime("now"));
        $repository = $service->salvarCurtidas($param);
        $qtdeCurtidasFoto = $this->pegarQtdeCurtidasFoto($post['idFoto']);
        
        $dados = array();
        $dados['tipoMsg'] = "S";
        $dados['idCurtidas'] = $repository->getIdCurtidas();
        $dados['qtdeCurtidasFoto'] = $qtdeCurtidasFoto;
        
        $result = new JsonModel($dados);
        return $result;
    }

    public function registrarDepoimentoAction() {
        $post = $this->getRequest()->getPost()->toArray();
        
        $idUsuarioLogado = $this->pegarIdUsuarioLogado();
        $service = $this->getServiceLocator()->get('Depoimento\Service\DepoimentoService');
        $param = array(
            'dsDepoimento' => $post['dsDepoimento'], 
            'stDepoimento' => (int) $post['stDepoimento'], 
            'idCliente' => (int) $post['idCliente'], 
            'idUsuario' => $idUsuarioLogado, 
            'dtHrDepoimento' => new \DateTime("now")
        );
        
        $depoimento = $service->verificarDepoimentoExistente($param);
        if (!$depoimento) {
            $repository = $service->salvarDepoimento($param);
            $idDepoimento = $repository->getIdDepoimento();
            $tipoMsg = "S";
            $textoMsg = "Depoimento registrado com sucesso!!!<br />"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Por favor aguarde a aprovação da Anunciante e/ou 15 dias para fazer outro depoimento.<br />";
        } else {
            $tipoMsg = "W";
            $textoMsg = "Você já tem um Depoimento registrado!<br />"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Por favor aguarde um período de 15 dias.<br />";
            $idDepoimento = NULL;
        }
        
        $dados = array();
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;
        $dados['idDepoimento'] = $idDepoimento;
        
        $result = new JsonModel($dados);
        return $result;
    }

    /**
     * Carregar Fotos Verticais
     * @param type $idCliente
     * @return string
     */
    private function carregarDepoimentos($idCliente) {
        $this->getEm();
        $repository = $this->em->getRepository("\Depoimento\Entity\DepoimentoEntity");
        $entities = $repository->findBy(array('idCliente' => $idCliente, 'stDepoimento' => 2), array('idDepoimento' => 'ASC'));
        $i = 1;
        $array = array();
        foreach ($entities as $entity) {
            $array[$i]['dsComentario'] = $entity->getDsDepoimento();
            $array[$i]['noAutor'] = $entity->getIdUsuario()->getLogin();
            $array[$i]['tpAutor'] = $entity->getIdUsuario()->getTpUsuario();
            $i++;
        }
        $depoimentosCapa = array_slice($array, 0, 3);
        $depoimentosMural = array_slice($array, 3, 5);
        
        $dados = array();
        $dados['depoimentosCapa'] = $depoimentosCapa;
        $dados['depoimentosMural'] = $depoimentosMural;
        
        return $dados;
    }

    /**
     * Carregar Dados do Cliente
     * @param type $repository
     * @return type
     */
    protected function carregarDadosCliente($repository) {
        $idCliente = $repository->getIdCliente();

        $configPaginaCliente = $this->selecionarConfigPaginaCliente($idCliente);
        $anunciante = $this->selecionarAnunciante($idCliente);

        $americaExpress = 2;
        $visaCard = 2;
        $masterCard = 2;
        $maestroCard = 2;
        $payPal = 2;
        $cirrus = 2;
        $dinersClub = 2;

        //Cartões de Crédito
        $caracteristicaCartoes = $this->carregarCaracteristicas($idCliente, 1);
        foreach ($caracteristicaCartoes as $value) {
            switch ($value) {
                case "American Express":
                    $americaExpress = 1;
                    break;
                case "Cirrus":
                    $cirrus = 1;
                    break;
                case "Diners Club":
                    $dinersClub = 1;
                    break;
                case "Visa":
                    $visaCard = 1;
                    break;
                case "MasterCard":
                    $masterCard = 1;
                    break;
                case "Maestro":
                    $maestroCard = 1;
                    break;
                case "Pay Pal":
                    $payPal = 1;
                    break;
            }
        }
        //Caracteristicas do Serviço
        $caracteristicaServico = $this->carregarCaracteristicas($idCliente, 2);
        //Caracteristicas do Atendimento
        $caracteristicaAtendimento = $this->carregarCaracteristicas($idCliente, 3);
        //Fotos Horizontais
        $fotosHorizontais = $this->carregarFotosHorizontais($idCliente);
        //Fotos Verticais
        $fotosVerticais = $this->carregarFotosVerticais($idCliente);
        //Valor dos Cachês
        $valorCache = $this->carregarCaches($idCliente);
        //Videos do Cliente
        $videos = $this->carregarVideos($idCliente);
        
        $depoimentos = $this->carregarDepoimentos($idCliente);
        $countCapa = count($depoimentos['depoimentosCapa']);
        if ($countCapa < 3) {
            $depoimentos['depoimentosCapa'][$countCapa] = array(
                    'dsComentario' => 'Caro <strong>Sócio Clube Luxúria</strong>, deixe o seu depoimento sobre <strong>' . $anunciante["noArtistico"] . "</strong>. Ele pode ser visto aqui nesta capa.<br />&nbsp;<br />&nbsp;<br />&nbsp;",
                    'noAutor' => 'Clube Luxúria',
                    'tpAutor' => 1
                );
        }
        $comentariosOutDoor = $depoimentos['depoimentosCapa'];

        $countMural = count($depoimentos['depoimentosMural']);
        if ($countMural < 5) {
            $depoimentos['depoimentosMural'][$countMural] = array(
                    'dsComentario' => 'Caro <strong>Sócio Clube Luxúria</strong>, deixe o seu depoimento sobre <strong>' . $anunciante["noArtistico"] . "</strong>. Ele pode ser visto aqui neste mural ou na capa da página. ",
                    'noAutor' => 'Clube Luxúria',
                    'tpAutor' => 1
                );
        }
        $comentariosMural = $depoimentos['depoimentosMural'];
        
        $galeriaFotosCliente = $this->carregarGaleriaFotos($idCliente);
        
        $dados = array(
            'idCliente' => $repository->getIdCliente(),
            'stAnunciante' => $anunciante["stAnunciante"],
            'noArtistico' => $anunciante["noArtistico"],
            'nuTelefone' => $anunciante["nuTelefone"],
            'noCidade' => $anunciante["noCidade"],
            'sgUf' => $anunciante["sgUf"],
            'nuLatitude' => $anunciante["nuLatitude"],
            'nuLongitude' => $anunciante["nuLongitude"],
            'dsUrlSite' => $anunciante["dsUrlSite"],
            'stAceitaCartao' => $anunciante["stAceitaCartao"],
            'americanExpress' => $americaExpress,
            'cirrus' => $cirrus,
            'dinersClub' => $dinersClub,
            'visa' => $visaCard,
            'masterCard' => $masterCard,
            'maestro' => $maestroCard,
            'payPal' => $payPal,
            'chamadaOutDoor' => $anunciante["dsFrase1"],
            'chamadaCliente' => $anunciante["dsFrase2"],
            'descricaoCliente' => $anunciante["dsFrase3"],
            'configPaginaCliente' => $configPaginaCliente,
            'caracteristicaServico' => $caracteristicaServico,
            'caracteristicaAtendimento' => $caracteristicaAtendimento,
            'comentariosOutDoor' => $comentariosOutDoor,
            'comentariosMural' => $comentariosMural,
            'fotosHorizontais' => $fotosHorizontais,
            'fotosVerticais' => $fotosVerticais,
            'valorCache' => $valorCache,
            'videos' => $videos,
            'galeriaFotosCliente' => $galeriaFotosCliente,
        );

        return $dados;
    }

}
