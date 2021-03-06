<?php

namespace Acompanhante\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
//SESSION
use Zend\Session\Container;
use AlbumFoto\Form as AlbumFotoForm;

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
        $sgUfSessionPsq = NULL;
        if ($this->identity()) {
            $idUsuarioPerfil = $this->identity()->getIdUsuario();
            $tpUsuario = $this->identity()->getTpUsuario();
            $sgUfSessionPsq = $this->identity()->getSgUf();
        }
        if ($tpUsuario == 3 || $tpUsuario == 4) {
            $clienteUsuario = $this->pegarIdClienteUsuarioLogado($idUsuarioPerfil);
            $stVencimento = FALSE;
            if ($clienteUsuario[0]->getIdCliente()->getDtVencimento()) {
                $stVencimento = $this->verificarVencimento($clienteUsuario[0]->getIdCliente()->getDtVencimento()->format('Y-m-d'));
            }
            if (!$stVencimento) {
                return $this->redirect()->toRoute('perfil');
            }
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
        
        $sessao = new Container();
        if (!$sessao->sgUfSessionPsq) {
            $sessao->sgUfSessionPsq = $sgUfSessionPsq;
            if (!$sessao->sgUfSessionPsq) {
                $sessao->sgUfSessionPsq = $anunciante[0]->getIdCidade()->getSgUf();
            }
        }
        $this->_view->setVariable('sgUfSessionPsq', $sessao->sgUfSessionPsq);

        //Formulario de Pesquisa de Valor Depoimentos
        $this->formPsqMinhasFotos = new AlbumFotoForm\MinhasFotosPsqForm();
        $this->_view->setVariable('formPsqMinhasFotos', $this->formPsqMinhasFotos);

        //Formulario de Pesquisa de Valor Depoimentos
        $this->formPsqMeusAlbuns = new AlbumFotoForm\MeusAlbunsPsqForm();
        $this->_view->setVariable('formPsqMeusAlbuns', $this->formPsqMeusAlbuns);

        //Formulario de Pesquisa de Valor Depoimentos
        $this->formPsqGaleriaFotos = new AlbumFotoForm\GaleriaFotosPsqForm();
        $this->_view->setVariable('formPsqGaleriaFotos', $this->formPsqGaleriaFotos);
        
        return $this->_view;
    }
    
    /**
     * Visualizar
     * @return type
     */
    public function visualizarAction() {
        $idUsuarioPerfil = NULL;
        $tpUsuario = NULL;
        $sgUfSessionPsq = NULL;
        if ($this->identity()) {
            $idUsuarioPerfil = $this->identity()->getIdUsuario();
            $tpUsuario = $this->identity()->getTpUsuario();
            $sgUfSessionPsq = $this->identity()->getSgUf();
        }
        if ($tpUsuario == 3 || $tpUsuario == 4) {
            $clienteUsuario = $this->pegarIdClienteUsuarioLogado($idUsuarioPerfil);
            $stVencimento = FALSE;
            if ($clienteUsuario[0]->getIdCliente()->getDtVencimento()) {
                $stVencimento = $this->verificarVencimento($clienteUsuario[0]->getIdCliente()->getDtVencimento()->format('Y-m-d'));
            }
            if (!$stVencimento) {
                return $this->redirect()->toRoute('perfil');
            }
        }
        
        $idCliente = $this->getEvent()->getRouteMatch()->getParam('id');
        $arCliente = $this->pegarDadosCliente($idCliente);
        $stCliente = $this->verificarVencimento($arCliente->getDtVencimento()->format('Y-m-d'));
        $this->_view->setVariable('stCliente', $stCliente);
        if ($stCliente) {
            $anunciante = $this->pegarDadosAnunciante($idCliente);
            $this->_view->setVariable('idAnunciante', $anunciante[0]->getIdAnunciante());
            $cliente = $this->selecionarCliente($idCliente);
            $this->_view->setVariables($cliente);
        }
        
        $sessao = new Container();
        if (!$sessao->sgUfSessionPsq) {
            $sessao->sgUfSessionPsq = $sgUfSessionPsq;
            if (!$sessao->sgUfSessionPsq) {
                $sessao->sgUfSessionPsq = $anunciante[0]->getIdCidade()->getSgUf();
            }
        }
        $this->_view->setVariable('sgUfSessionPsq', $sessao->sgUfSessionPsq);

        //Formulario de Pesquisa de Valor Depoimentos
        $this->formPsqMinhasFotos = new AlbumFotoForm\MinhasFotosPsqForm();
        $this->_view->setVariable('formPsqMinhasFotos', $this->formPsqMinhasFotos);

        //Formulario de Pesquisa de Valor Depoimentos
        $this->formPsqMeusAlbuns = new AlbumFotoForm\MeusAlbunsPsqForm();
        $this->_view->setVariable('formPsqMeusAlbuns', $this->formPsqMeusAlbuns);

        //Formulario de Pesquisa de Valor Depoimentos
        $this->formPsqGaleriaFotos = new AlbumFotoForm\GaleriaFotosPsqForm();
        $this->_view->setVariable('formPsqGaleriaFotos', $this->formPsqGaleriaFotos);
        
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
        
        $dados = array(
            'idCliente' => $repository->getIdCliente(),
            'stAnunciante' => $anunciante["stAnunciante"],
            'noArtistico' => $anunciante["noArtistico"],
            'nuTelefone' => $anunciante["nuTelefone"],
            'noCidade' => $anunciante["noCidade"],
            'sgUf' => $anunciante["sgUf"],
            'nuLatitude' => $anunciante["nuLatitude"],
            'nuLongitude' => $anunciante["nuLongitude"],
            
            'dsIdade' => $anunciante["dsIdade"],
            'dsApelido' => $anunciante["dsApelido"],
            
            'dsCabelos' => $anunciante["dsCabelos"],
            'dsOlhos' => $anunciante["dsOlhos"],
            
            'dsLabios' => $anunciante["dsLabios"],
            'dsAltura' => $anunciante["dsAltura"],
            
            'dsPeso' => $anunciante["dsPeso"],
            'dsBusto' => $anunciante["dsBusto"],
            
            'dsCintura' => $anunciante["dsCintura"],
            'dsQuadril' => $anunciante["dsQuadril"],
            
            'dsHobby' => $anunciante["dsHobby"],
            'dsComidas' => $anunciante["dsComidas"],
            
            'dsBebidas' => $anunciante["dsBebidas"],
            'dsFrase' => $anunciante["dsFrase"],
            
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
        );

        return $dados;
    }

}
