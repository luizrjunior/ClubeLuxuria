<?php

namespace Cliente\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\JsonModel;

class ClienteCaracteristicaController extends AbstractController {

    public function __construct() {
        $this->service = 'Cliente\Service\ClienteCaracteristicaService';
    }

    /**
     * Salvar Action
     * @return JsonModel
     */
    public function salvarAction() {
        $post = $this->getRequest()->getPost()->toArray();
        $post['idCliente'] = $post['idClienteCaracteristica'];
        unset($post['idClienteCaracteristica']);

        //SALVAR CARACTERISTICAS CARTOES
        $this->salvarCaracteristicas($post['idCliente'],1,$post['caracteristicaCartoes']);
        //SALVAR CARACTERISTICAS SERVICOS
        $this->salvarCaracteristicas($post['idCliente'],2,$post['caracteristicaServico']);
        //SALVAR CARACTERISTICAS ATENDIMENTO
        $this->salvarCaracteristicas($post['idCliente'],3,$post['caracteristicaAtendimento']);            

        $tipoMsg = "S";
        $textoMsg = "Características registradas com sucesso!";

        $dados = array();
        $dados['idCliente'] = $post['idCliente'];
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;

        $result = new JsonModel($dados);
        return $result;
    }

    /**
     * Salvar Caracteristicas do Cliente
     * @param type $idCliente
     * @param type $tpCaracteristica
     * @param type $param
     */
    private function salvarCaracteristicas($idCliente, $tpCaracteristica, $param) {
        $service = $this->getServiceLocator()->get("Cliente\Service\ClienteCaracteristicaService");
        /*
         * Remover as Caracteristicas do Cliente
         */
        $service->desativarClienteCaracteristica($idCliente, $tpCaracteristica);
        /*
         * Cadastrar as caracteristicas marcadas
         */
        if (is_array($param) || is_object($values)) {
            foreach ($param as $idCaracteristica) {
                $service->salvarClienteCaracteristica($idCliente, $idCaracteristica);
            }
        }
    }

    /**
     * Carregar Caracteristicas
     * @return JsonModel
     */
    public function carregarCaracteristicasAction() {
        $this->getEm();
        $post = $this->getRequest()->getPost()->toArray();
        $repository = $this->em->getRepository("\Caracteristicas\Entity\CaracteristicasEntity");
        $entities = $repository->findBy(array('tpCaracteristica' => $post['tpCaracteristica']), array('noCaracteristica' => 'ASC'));
        $serviceClienteCaracteristica = $this->getServiceLocator()->get("Cliente\Service\ClienteCaracteristicaService");
        $array = array();
        foreach ($entities as $entity) {
            if ($entity->getIdCaracteristica() != "") {
                $post['idCaracteristica'] = $entity->getIdCaracteristica();
                $stChecked = $this->verificarClienteCaracteristica($post, $serviceClienteCaracteristica);
                $array[$entity->getIdCaracteristica()]['stChecked'] = $stChecked;
                $array[$entity->getIdCaracteristica()]['dsCaracteristicaServico'] = $entity->getNoCaracteristica();
            }
        }
        $result = new JsonModel($array);
        return $result;
    }
    
    private function verificarClienteCaracteristica($post, $serviceClienteCaracteristica) {
        $dsChecked = "";
        $param = array('idCliente' => $post['idCliente'], 'idCaracteristica' => $post['idCaracteristica']);
        $arrClienteCaracteristica = $serviceClienteCaracteristica->selecionarClienteCaracteristicaBy($param);
        if ($arrClienteCaracteristica[0]) {
            $dsChecked = "checked";
        }
        return $dsChecked;
    }
    
}
