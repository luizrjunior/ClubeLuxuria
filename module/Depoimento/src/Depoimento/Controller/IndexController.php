<?php

namespace Depoimento\Controller;

use Application\Controller\AbstractController;
use Depoimento\Form as DepoimentoForms;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Session\Container;

class IndexController extends AbstractController {

    private $formPsq;
    private $formCad;

    public function __construct() {
        $this->service = 'Depoimento\Service\DepoimentoService';
        $this->_view = new ViewModel();
    }

    public function indexAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        // Instanciando a sessão
        $sessao = new Container();
        $this->_view->setVariable('idCliente', $sessao->idCliente);
        $this->_view->setVariable('idUsuario', $sessao->idUsuario);

        $this->getEm();
        $config = $this->getServiceLocator()->get('config');
                
        $situacaoPsq = $config['constsSituacaoDepoimentoPsq'];
        
        //Formulario de Pesquisa de Valor Depoimentos
        $this->formPsq = new DepoimentoForms\DepoimentoPsqForm($situacaoPsq);
        $this->_view->setVariable('formPsq', $this->formPsq);

        $situacaoCad = $config['constsSituacaoDepoimentoCad'];
        
        //Formulario de Cadastro de Valor Depoimento
        $this->formCad = new DepoimentoForms\DepoimentoCadForm($situacaoCad);
        $this->_view->setVariable('formCad', $this->formCad);

        return $this->_view;
    }

    /**
     * Pesquisar Action
     * @return type
     */
    public function pesquisarDepoimentoAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        $service = $this->getServiceLocator()->get($this->service);
        $pagina = $this->getEvent()->getRouteMatch()->getParam('page');
        $post = $this->getRequest()->getPost()->toArray();
        $post['idClientePsq'] = $post['idClientePsqDepoimento'];
        unset($post['idClientePsqDepoimento']);
        $itens = $this->itemForPage;
        
        $this->_view->setVariable('lista', $service->listarDepoimentosPaginado($post, $pagina, $itens));
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
        if ($post['idDepoimento'] == "") {
            if ($post['dtHrDepoimento'] == "") {
                $post['dtHrDepoimento'] = new \DateTime("now");
            }
        }
        $service = $this->getServiceLocator()->get($this->service);
        $post['idCliente'] = $post['idClienteDepoimento'];
        $post['idUsuario'] = $post['idUsuarioDepoimento'];
        $arrDepoimento = $service->salvarDepoimento($post);
        if ($arrDepoimento) {
            $tipoMsg = "S";
            $textoMsg = $this->exibeMsgSalvar($post['idDepoimento']);
        } else {
            $tipoMsg = "E";
            $textoMsg = "Erro ao tentar cadastrar o Depoimento! Tente mais tarde.";
        }
        $dados = array();
        if ($arrDepoimento) {
            $dados['idDepoimento'] = $arrDepoimento->getIdDepoimento();
        }
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;

        $result = new JsonModel($dados);
        return $result;
    }

    private function exibeMsgSalvar($idDepoimento) {
        if ($idDepoimento) {
            $textoMsg = "Depoimento atualizado!";
        } else {
            $textoMsg = "Depoimento cadastrado!";
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
        $repository = $service->selecionarDepoimento($id['idDepoimento']);
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
     * Carregar Dados do Valor do Depoimento
     * @param type $repository
     * @return type
     */
    private function carregarDados($repository) {
        $array['idDepoimento'] = $repository->getIdDepoimento();
        $array['idCliente'] = $repository->getIdCliente()->getIdCliente();
        $array['idUsuario'] = $repository->getIdUsuario()->getIdUsuario();
        $array['dsDepoimento'] = $repository->getDsDepoimento();
        $array['stDepoimento'] = $repository->getStDepoimento();
        $array['dtHrDepoimento'] = $repository->getDtHrDepoimento()->format('d/m/Y H:i:s');
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
        $repository = $service->selecionarDepoimento($post['idDepoimento']);
        if ($repository) {
            if ($service->excluirDepoimento($repository)) {
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

    public function registrarDepoimentoAction() {
        $post = $this->getRequest()->getPost()->toArray();
        
        $idUsuarioLogado = $this->identity()->getIdUsuario();
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

}
