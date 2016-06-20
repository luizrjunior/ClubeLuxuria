<?php

namespace Contato\Controller;

use Application\Controller\AbstractController;
use Contato\Form as Form;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractController {

    protected $em;

    function __construct() {
        $this->controller = 'contato';
        $this->route = 'contato/default';
        $this->form = 'Contato\Form\ContatoForm';
        $this->entity = 'Contato\Entity\ContatoEntity';
        $this->service = 'Contato\Service\ContatoService';
        $this->_view = new ViewModel();
    }

    public function indexAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        parent::getEm();
        //Instanciar e Setar o Form de Pesquisa
        $this->formPsq = new Form\PesquisarForm();
        $this->_view->setVariable('formPsq', $this->formPsq);
        //Instanciar e Setar o Form de Cadastro
        $this->formCad = new Form\CadastrarForm($this->carregarSelectAssunto());
        $this->_view->setVariable('formCad', $this->formCad);
        $this->_view->setVariable('stBannerPrincipal', FALSE);
        return $this->_view;
    }

    public function formularioAction() {
        //Instanciar e Setar o Form de Cadastro
        $this->formCad = new Form\ContatoForm();
        $this->_view->setVariable('formCad', $this->formCad);
        return $this->_view;
    }

    protected function carregarSelectAssunto() {
        $repository = $this->em->getRepository("\Contato\Entity\AssuntoEntity");
        $entities = $repository->findBy(array('status' => 1), array('descricao' => 'ASC'));
        $array[NULL] = " - - Selecione o Assunto - - ";
        foreach ($entities as $entity) {
            $array[$entity->getIdAssunto()] = strtoupper(mb_strtoupper($entity->getDescricao(), 'UTF-8'));
        }
        return($array);
    }

    /**
     * Pesquisar Action
     * @return type
     */
    public function pesquisarAction() {
        $service = $this->getServiceLocator()->get($this->service);
        $pagina = $this->getEvent()->getRouteMatch()->getParam('page');
        $post = $this->getRequest()->getPost()->toArray();
        $itens = 10;
        $this->_view->setVariable('lista', $service->listarContatos($post, $pagina, $itens));
        $this->_view->setTerminal(true);
        return $this->_view;
    }

    /**
     * Salvar Action
     * @return JsonModel
     */
    public function salvarAction() {
        $post = $this->getRequest()->getPost()->toArray();
        $data = $this->prepararDadosContato($post);
        $service = $this->getServiceLocator()->get($this->service);
        $arrContato = $service->salvarContato($data);
        if ($arrContato) {
            $tipoMsg = "S";
            if ($post['idContato']) {
                $textoMsg = "Contato atualizado!";
            } else {
                $textoMsg = "Obrigado pelo Contato! Em breve respondemos...";
            }
        } else {
            $tipoMsg = "E";
            $textoMsg = "Não foi possível realizar esta operação! Tente mais tarde.";
        }

        $dados = array();
        $dados['idContato'] = $arrContato->getIdContato();
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
        $repository = $service->selecionarContato($id['idContato']);
        if ($repository) {
            $tipoMsg = "S";
            $textoMsg = "Registro encontrado!";
            $dados = $this->carregarDadosContato($repository);
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
        $service = $this->getServiceLocator()->get($this->service);
        $repository = $service->selecionarContato($post['idContato']);
        if ($repository) {
            if ($service->excluirContato($repository)) {
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

    /**
     * Carregar Dados do Usuário
     * @param type $repository
     * @return type
     */
    protected function carregarDadosContato($repository) {
        $array['idContato'] = $repository->getIdContato();
        $array['nome'] = $repository->getNome();
        $array['email'] = $repository->getEmail();
//        $array['idAssunto'] = $repository->getIdAssunto()->getIdAssunto();
        $array['assunto'] = $repository->getAssunto();
        $array['mensagem'] = $repository->getMensagem();
        $array['status'] = $repository->getStatus();
        $array['registrado'] = $repository->getRegistrado()->format('d/m/Y');
        return $array;
    }

    /**
     * Preparar dados do usuário para Inclusão/Atualização
     * @param type $data
     * @return type
     */
    protected function prepararDadosContato($data) {
        if (empty($data['idContato'])) {
            $data['status'] = 0;
            $data['idAssunto'] = 1;
            $data['registrado'] = new \DateTime("now");
            unset($data['idContato']);
        }
        return $data;
    }

}
