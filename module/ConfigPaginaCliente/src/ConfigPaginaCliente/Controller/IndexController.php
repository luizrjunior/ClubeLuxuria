<?php

namespace ConfigPaginaCliente\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractController {

    public function __construct() {
        $this->service = 'ConfigPaginaCliente\Service\ConfigPaginaClienteService';
        $this->_view = new ViewModel();
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

        $idConfigPaginaCliente = $this->verificarConfigPaginaCliente($post, $service);
        if ($idConfigPaginaCliente) {
            $post['idConfigPaginaCliente'] = $idConfigPaginaCliente;
        }
        $post['idCliente'] = $post['idClienteConfigPaginaCliente'];
        unset($post['idClienteConfigPaginaCliente']);

        $arrConfigPaginaCliente = $service->salvarConfigPaginaCliente($post);
        if ($arrConfigPaginaCliente) {
            $tipoMsg = "S";
            if ($post['idConfigPaginaCliente']) {
                $textoMsg = "Configurações do LayOut da Página atualizado!";
            } else {
                $textoMsg = "Configurações do LayOut da Página cadastrado!";
            }
        } else {
            $tipoMsg = "E";
            $textoMsg = "Erro ao tentar cadastrar as Configurações do LayOut da Página! Tente mais tarde.";
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
        $repository = $service->selecionarConfigPaginaClienteBy($param);

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
     * Verificar Config Pagina Cliente
     * @param type $post
     * @param type $service
     * @return type $idConfigPaginaCliente
     */
    private function verificarConfigPaginaCliente($post, $service) {
        $idConfigPaginaCliente = NULL;
        $param = array('idCliente' => $post['idClienteConfigPaginaCliente']);
        $arrConfigPaginaCliente = $service->selecionarConfigPaginaClienteBy($param);
        if ($arrConfigPaginaCliente[0]) {
            $idConfigPaginaCliente = $arrConfigPaginaCliente[0]->getIdConfigPaginaCliente();
        }
        return $idConfigPaginaCliente;
    }

    /**
     * Carregar Dados do Valor do ConfigPaginaCliente
     * @param type $repository
     * @return type
     */
    private function carregarDados($repository) {
        $array['idConfigPaginaCliente'] = $repository->getIdConfigPaginaCliente();
        $array['idClienteConfigPaginaCliente'] = $repository->getIdCliente()->getIdCliente();
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

}