<?php

namespace Curtidas\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractController {

    public function __construct() {
        $this->service = 'Curtidas\Service\CurtidasService';
        $this->_view = new ViewModel();
    }

    /**
     * Verificar se o Usuário Curtiu a Página
     * @return JsonModel
     */
    public function verificarCurtidasAction() {
        $post = $this->getRequest()->getPost()->toArray();
        $this->getEm();
        $idUsuarioLogado = $this->identity()->getIdUsuario();
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
     * Curtir Página do Curtidas
     * @return JsonModel
     */
    public function curtirPaginaAction() {
        $post = $this->getRequest()->getPost()->toArray();
        
        $idUsuarioLogado = $this->identity()->getIdUsuario();
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
     * Descurtir Página do Curtidas
     * @return JsonModel
     */
    public function descurtirPaginaAction() {
        $post = $this->getRequest()->getPost()->toArray();
        $service = $this->getServiceLocator()->get('Curtidas\Service\CurtidasService');
        $repository = $service->selecionarCurtidas($post['idCurtidas']);
        if ($repository) {
            if ($service->removerCurtidas($repository)) {
                $tipoMsg = "S";
                $textoMsg = "Curtidas removida dos Favoritos com sucesso!";
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
     * Curtir Foto do Curtidas
     * @return JsonModel
     */
    public function curtirFotoAction() {
        $post = $this->getRequest()->getPost()->toArray();
        $idUsuarioLogado = $this->identity()->getIdUsuario();
        $service = $this->getServiceLocator()->get('Curtidas\Service\CurtidasService');
        $param = array('idFoto' => $post['idFoto'], 'idUsuario' => $idUsuarioLogado, 'dtHrCurtida' => new \DateTime("now"));
        $repository = $service->salvarCurtidas($param);
        $qtdeCurtidasFoto = $this->pegarQtdeCurtidasFoto($post['idFoto']);
        
        $dados = array();
        $dados['tipoMsg'] = "S";
        $dados['idCurtidas'] = $repository->getIdCurtidas();
        $dados['qtdeCurtidasFoto'] = $qtdeCurtidasFoto;
        
        $result = new JsonModel($dados);
        return $result;
    }

}
