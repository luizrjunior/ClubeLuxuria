<?php

namespace Cliente\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\JsonModel;

class ClienteUsuarioController extends AbstractController {

    function __construct() {
        $this->service = 'Cliente\Service\ClienteUsuarioService';
    }

    /**
     * Salvar Action
     * @return JsonModel
     */
    public function salvarAction() {
        $post = $this->getRequest()->getPost()->toArray();
        $serviceClienteUsuario = $this->getServiceLocator()->get($this->service);

        $idClienteUsuario = $this->verificarClienteUsuario($post, $serviceClienteUsuario);
        if ($idClienteUsuario) {
            $data['idClienteUsuario'] = $idClienteUsuario;
        }
        $data['idCliente'] = $post['idCliente'];
        $data['idUsuario'] = $post['idUsuario'];

        $arrClienteUsuario = $serviceClienteUsuario->salvarClienteUsuario($data);
        if ($arrClienteUsuario) {
            $tipoMsg = "S";
            if ($data['idClienteUsuario']) {
                $textoMsg = "Cliente atualizado com sucesso!";
            } else {
                $textoMsg = "Cliente cadastrado com sucesso!";
            }
        } else {
            $tipoMsg = "E";
            $textoMsg = "Erro ao tentar associar o Cliente ao Usuário! Tente mais tarde.";
        }

        $dados = array();
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;

        $result = new JsonModel($dados);
        return $result;
    }

    private function verificarClienteUsuario($post, $serviceClienteUsuario) {
        $idClienteUsuario = NULL;
        $param = array('idCliente' => $post['idCliente'], 'idUsuario' => $post['idUsuario']);
        $arrClienteUsuario = $serviceClienteUsuario->selecionarClienteUsuarioBy($param);
        if ($arrClienteUsuario[0]) {
            $idClienteUsuario = $arrClienteUsuario[0]->getIdClienteUsuario();
        }
        return $idClienteUsuario;
    }

    /**
     * Selecionar Action
     * @return JsonModel
     */
    public function selecionarAction() {
        $post = $this->getRequest()->getPost()->toArray();
        $serviceClienteUsuario = $this->getServiceLocator()->get($this->service);

        $param = array('idCliente' => $post['idCliente']);
        $repository = $serviceClienteUsuario->selecionarClienteUsuarioBy($param);

        if ($repository[0]) {
            $tipoMsg = "S";
            $textoMsg = "Registro encontrado!";
            $dados = $this->carregarDados($repository[0]);
        } else {
            $tipoMsg = "I";
            $textoMsg = "Registro Usuário não encontrado!";
            $dados = NULL;
        }

        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;

        $result = new JsonModel($dados);
        return $result;
    }

    /**
     * Carregar Dados do Cliente Usuario
     * @param type $repository
     * @return type
     */
    protected function carregarDados($repository) {
        $array['idCliente'] = $repository->getIdCliente()->getIdCliente();
        $array['idUsuario'] = $repository->getIdUsuario()->getIdUsuario();
        return $array;
    }

}
