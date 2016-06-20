<?php

namespace ConfigPaginaPerfil\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractController {

    public function __construct() {
        $this->service = 'ConfigPaginaPerfil\Service\ConfigPaginaPerfilService';
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

        $idConfigPaginaPerfil = $this->verificarConfigPaginaPerfil($post, $service);
        if ($idConfigPaginaPerfil) {
            $post['idConfigPaginaPerfil'] = $idConfigPaginaPerfil;
        }
        $post['idUsuario'] = $post['idUsuarioConfigPaginaPerfil'];
        unset($post['idUsuarioConfigPaginaPerfil']);

        $arrConfigPaginaPerfil = $service->salvarConfigPaginaPerfil($post);
        if ($arrConfigPaginaPerfil) {
            $tipoMsg = "S";
            if ($post['idConfigPaginaPerfil']) {
                $textoMsg = "Configurações do LayOut da Página atualizado!";
            } else {
                $textoMsg = "Configurações do LayOut da Página cadastrado!";
            }
        } else {
            $tipoMsg = "E";
            $textoMsg = "Erro ao tentar cadastrar as Configurações do LayOut da Página! Tente mais tarde.";
        }

        $dados = array();
        $dados['idUsuario'] = $post['idUsuario'];
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

        $param = array('idUsuario' => $post['idUsuario']);
        $repository = $service->selecionarConfigPaginaPerfilBy($param);

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
     * Verificar Config Pagina Perfil
     * @param type $post
     * @param type $service
     * @return type $idConfigPaginaPerfil
     */
    private function verificarConfigPaginaPerfil($post, $service) {
        $idConfigPaginaPerfil = NULL;
        $param = array('idUsuario' => $post['idUsuarioConfigPaginaPerfil']);
        $arrConfigPaginaPerfil = $service->selecionarConfigPaginaPerfilBy($param);
        if ($arrConfigPaginaPerfil[0]) {
            $idConfigPaginaPerfil = $arrConfigPaginaPerfil[0]->getIdConfigPaginaPerfil();
        }
        return $idConfigPaginaPerfil;
    }

    /**
     * Carregar Dados do Valor do ConfigPaginaPerfil
     * @param type $repository
     * @return type
     */
    private function carregarDados($repository) {
        $array['idConfigPaginaPerfil'] = $repository->getIdConfigPaginaPerfil();
        $array['idUsuarioConfigPaginaPerfil'] = $repository->getIdUsuario()->getIdUsuario();
        $array['stInfoUsuario'] = $repository->getStInfoUsuario();
        $array['stBannerPrincipal'] = $repository->getStBannerPrincipal();
        $array['stMinhasFavoritas'] = $repository->getStMinhasFavoritas();
        $array['stDestaques'] = $repository->getStDestaques();
        $array['tpPlanoFundo'] = $repository->getTpPlanoFundo();
        return $array;
    }

}