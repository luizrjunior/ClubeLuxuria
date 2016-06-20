<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use Application\Form;
use Anunciante\Form as AnuncianteForm;
use Cliente\Form as ClienteForm;
use Usuario\Form as UsuarioForm;
//SESSION
use Zend\Session\Container;

class IndexController extends AbstractController {

    private $formAcessoHome;
    private $formPsqAnunciantes;

    public function __construct() {
        $this->service = 'Cliente\Service\ClienteService';
        $this->_view = new ViewModel();
    }

    public function indexAction() {
        $this->getEm();
        $config = $this->getServiceLocator()->get('config');
        $sgUfSessionPsq = $config['constsSgUfSessionPsq'];
        $this->formAcessoHome = new Form\AcessoHomeForm($sgUfSessionPsq);
            
        $sessao = new Container();
        $post = $this->getRequest()->getPost()->toArray();
        if (empty($post)) {
            $sessao->sgUfSessionPsq = null;
        } else {
            $sessao->sgUfSessionPsq = $post['sgUfSessionPsq'];
        }
        
        $this->_view->setVariable('formAcessoHome', $this->formAcessoHome);
        $this->_view->setVariable('sgUfPsq', $sessao->sgUfSessionPsq);
        $this->_view->setTerminal(true);
        return $this->_view;
    }


    public function homeAction() {
        $sessao = new Container();
        if ($sessao->sgUfSessionPsq == null) {
            return $this->redirect()->toRoute('application');
        }
        $this->getEm();
        $config = $this->getServiceLocator()->get('config');

        //Instanciar e Setar o Form de Pesquisa
        $sgUfPsq = $config['constsSgUfPsq'];
        $cidadePsq = $this->carregarSelectCidade(1);

        //Formulario de Pesquisa de Anunciantes
        $this->formPsqAnunciantes = new AnuncianteForm\AnunciantePsqHomeForm($sgUfPsq, $cidadePsq, NULL, NULL);
        $this->_view->setVariable('formPsqAnunciantes', $this->formPsqAnunciantes);

        $post = $this->getRequest()->getPost()->toArray();
        $post['tpAnunciantePsq'] = 1;//Acompanhante de Luxo
        $post['stAnunciantePsq'] = array(1,3,4);//1-Atividade;3-Viajando;4-Férias;
        if (!$post['sgUfPsq']) {
            $post['sgUfPsq'] = $sessao->sgUfSessionPsq;
        }
        $listaAnunciantes = $this->listarAnunciantesHome($post);
        $this->_view->setVariable('lista', $listaAnunciantes);

        $listaNovidades = $this->listarAnunciantesNovidades($post);
        $this->_view->setVariable('listaNovidades', $listaNovidades);

        $this->_view->setVariable('sgUfPsq', $sessao->sgUfSessionPsq);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $this->_view->setVariable('idCidadePsq', $post['idCidadePsq']);
            $this->_view->setVariable('sgUfPsq', $post['sgUfPsq']);
        }
        return $this->_view;
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

    protected function listarAnunciantesNovidades($post) {
        $service = $this->getServiceLocator()->get('Anunciante\Service\AnuncianteService');
        $result = $service->listarAnunciantesNovidades($post);
        return $result;
    }

    protected function listarAnunciantesHome($post) {
        $service = $this->getServiceLocator()->get('Anunciante\Service\AnuncianteService');
        $result = $service->listarAnunciantesHome($post);
        return $result;
    }

    public function diariosAction() {
        $sessao = new Container();
        if ($sessao->sgUfSessionPsq == null) {
            return $this->redirect()->toRoute('application', array('controller' => 'index', 'action' => 'index'));
        }
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
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
        
        return $this->_view;
    }

    public function mapaAction() {
        $sessao = new Container();
        if ($sessao->sgUfSessionPsq == null) {
            return $this->redirect()->toRoute('application', array('controller' => 'index', 'action' => 'index'));
        }
        
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        
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
        
        $this->getEm();
        $config = $this->getServiceLocator()->get('config');

        //Instanciar e Setar o Form de Pesquisa
        $sgUfPsq = $config['constsSgUfPsq'];
        $cidadePsq = $this->carregarSelectCidade(1);

        //Formulario de Pesquisa de Anunciantes
        $this->formPsqAnunciantes = new AnuncianteForm\AnunciantePsqHomeForm($sgUfPsq, $cidadePsq, NULL, NULL);
        $this->_view->setVariable('formPsqAnunciantes', $this->formPsqAnunciantes);

        $post = $this->getRequest()->getPost()->toArray();
        $post['tpAnunciantePsq'] = 1;//Acompanhante de Luxo
        $post['stAnunciantePsq'] = array(1,3,4);//1-Atividade;3-Viajando;4-Férias;
        if (!$post['sgUfPsq']) {
            $post['sgUfPsq'] = $sessao->sgUfSessionPsq;
        }
        $listaAnunciantes = $this->listarAnunciantesHome($post);
        $this->_view->setVariable('lista', $listaAnunciantes);

        $this->_view->setVariable('sessao', $sessao);
        
        return $this->_view;
    }

    protected function pegarIdClienteUsuarioLogado($idUsuario) {
        $service = $this->getServiceLocator()->get('Cliente\Service\ClienteUsuarioService');
        $param = array('idUsuario' => $idUsuario);
        $repository = $service->selecionarClienteUsuarioBy($param);
        return $repository;
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
    
    public function guiaAction() {
        $sessao = new Container();
        if ($sessao->sgUfSessionPsq == null) {
            return $this->redirect()->toRoute('application', array('controller' => 'index', 'action' => 'index'));
        }
        
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        
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
        
        return $this->_view;
    }

    public function anuncieAction() {
        return $this->_view;
    }
    
    public function cadastreSeAction() {
        $this->getEm();
        $config = $this->getServiceLocator()->get('config');

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
        
        return $this->_view;
    }

    public function regrasPublicidadeAction() {
        return $this->_view;
    }

    public function politicaPrivacidadeAction() {
        return $this->_view;
    }

    public function termosServicoAction() {
        return $this->_view;
    }

}
