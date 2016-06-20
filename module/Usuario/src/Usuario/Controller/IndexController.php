<?php

namespace Usuario\Controller;

use Application\Controller\AbstractController;
use Usuario\Form as Form;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractController {

    function __construct() {
        $this->service = 'Usuario\Service\UsuarioService';
        $this->_view = new ViewModel();
    }

    public function indexAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        $this->getEm();
        $config = $this->getServiceLocator()->get('config');

        //Instanciar e Setar o Form de Pesquisa
        $stUsuarioPsq = $config['constsStUsuarioPsq'];
        $tpUsuarioPsq = $config['constsTpUsuarioPsq'];
        
        //Instanciar e Setar o Form de Pesquisa
        $this->formPsq = new Form\UsuarioPsqForm($stUsuarioPsq,$tpUsuarioPsq);
        $this->_view->setVariable('formPsqUsuario', $this->formPsq);
        
        $sgUfCad = $config['constsSgUfCad'];
        $stUsuarioCad = $config['constsStUsuarioCad'];
        $tpUsuarioCad = $config['constsTpUsuarioCad'];
        
        //Instanciar e Setar o Form de Cadastro
        $this->formCad = new Form\UsuarioCadForm($sgUfCad, $stUsuarioCad,$tpUsuarioCad);
        $this->_view->setVariable('formCadUsuario', $this->formCad);
        
        return $this->_view;
    }

    /**
     * Pesquisar Action
     * @return type
     */
    public function pesquisarUsuarioAction() {
        $service = $this->getServiceLocator()->get($this->service);
        $pagina = $this->getEvent()->getRouteMatch()->getParam('page');
        $post = $this->getRequest()->getPost()->toArray();
        $itens = $this->itemForPage;
        $this->_view->setVariable('lista', $service->listarUsuariosPaginados($post, $pagina, $itens));
        $this->_view->setTerminal(true);
        return $this->_view;
    }

    /**
     * Salvar Action
     * @return JsonModel
     */
    public function salvarAction() {
        $post = $this->getRequest()->getPost()->toArray();
        $data = $this->prepararDadosUsuario($post);
        $service = $this->getServiceLocator()->get($this->service);
        $stLogin = $service->verificarLoginExistente($post['login'], $post['idUsuario']);
        if (!$stLogin) {
            $arrUsuario = $service->salvarUsuario($data);
            if ($arrUsuario) {
                $tipoMsg = "S";
                if ($post['idUsuario']) {
                    $textoMsg = "Usuário atualizado!";
                } else {
                    $textoMsg = "Usuário cadastrado!";
                }
            } else {
                $tipoMsg = "E";
                $textoMsg = "Não foi possível realizar esta operação! Tente mais tarde.";
            }
        } else {
            $tipoMsg = "W";
            $textoMsg = "Login de Usuário existente! Por favor informe outro.";
        }

        $dados = array();
        if ($arrUsuario) {
            $dados['idUsuario'] = $arrUsuario->getIdUsuario();
        }
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
        $id = $this->getRequest()->getPost()->toArray();
        $service = $this->getServiceLocator()->get($this->service);
        $repository = $service->selecionarUsuario($id);
        if ($repository) {
            $tipoMsg = "S";
            $textoMsg = "Registro encontrado!";
            $dados = $this->carregarDadosUsuario($repository);
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
     * Excluir Action
     * @return JsonModel
     */
    public function excluirAction() {
        $post = $this->getRequest()->getPost()->toArray();
        if ($post['idUsuario'] != 1) {
            $service = $this->getServiceLocator()->get($this->service);
            $repository = $service->selecionarUsuario($post['idUsuario']);
            if ($repository) {
                if ($service->excluirUsuario($repository)) {
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
        } else {
            $tipoMsg = "I";
            $textoMsg = "Não é possível excluir este usuário por ser o administrador!";
        }

        $dados = array();
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;

        $result = new JsonModel($dados);
        return $result;
    }

    /**
     * Carregar Dados do Usuário
     * @param type $repository
     * @return type
     */
    protected function carregarDadosUsuario($repository) {
        $array['idUsuario'] = $repository->getIdUsuario();
        $array['login'] = $repository->getLogin();
        $array['email'] = $repository->getEmail();
        $array['sgUfUsuario'] = $repository->getSgUf();
        $array['noUsuario'] = $repository->getNoUsuario();
        $array['stUsuario'] = $repository->getStUsuario();
        $array['tpUsuario'] = $repository->getTpUsuario();
        $array['dtCadastro'] = $repository->getDtCadastro()->format('d/m/Y');
        return $array;
    }

    /**
     * Preparar dados do usuário para Inclusão/Atualização
     * @param type $data
     * @return type
     */
    protected function prepararDadosUsuario($data) {
        $data['sgUf'] = $data['sgUfUsuario'];
        unset($data['sgUfUsuario']);
        if (empty($data['idUsuario'])) {
            $data['dtCadastro'] = new \DateTime("now");
            unset($data['idUsuario']);
        } else {
            unset($data['senha']);
        }
        return $data;
    }

    public function carregarSelectUsuarioAction() {
        $service = $this->getServiceLocator()->get($this->service);
        $param['tpUsuarioPsq'] = "T";
        $param['stUsuarioPsq'] = 1;
        $entities = $service->listarUsuarios($param);
        $array = array();
        foreach ($entities as $entity) {
            $array[$entity['idUsuario']] = utf8_encode($entity['login']);
        }
        $result = new JsonModel($array);
        return $result;
    }

}
