<?php

namespace Favoritos\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractController {

    public function __construct() {
        $this->service = 'Favoritos\Service\FavoritosService';
        $this->_view = new ViewModel();
    }

    /**
     * Verificar se a Página já está nos Favoritos do Usuário
     * @return JsonModel
     */
    public function verificarFavoritosAction() {
        $post = $this->getRequest()->getPost()->toArray();
        $this->getEm();
        $idUsuarioLogado = $this->identity()->getIdUsuario();
        $repository = $this->em->getRepository("\Favoritos\Entity\FavoritosEntity");
        $entities = $repository->findBy(array('idAnunciante' => $post['idAnunciante'], 'idUsuario' => $idUsuarioLogado), array('idFavoritos' => 'ASC'));
        $dados = array();
        $dados['tipoMsg'] = "S";
        foreach ($entities as $entity) {
            $dados['idFavoritos'] = $entity->getIdFavoritos();
            $dados['stNotificacao'] = $entity->getStNotificacao();
        }
        
        $result = new JsonModel($dados);
        return $result;
    }
    
    /**
     * Adicionar Pagina aos Favoritos do Usuário
     * @return JsonModel
     */
    public function adicionarFavoritosAction() {
        $post = $this->getRequest()->getPost()->toArray();
        
        $idUsuarioLogado = $this->identity()->getIdUsuario();
        $service = $this->getServiceLocator()->get('Favoritos\Service\FavoritosService');
        $param = array('idAnunciante' => (int) $post['idAnunciante'], 'idUsuario' => $idUsuarioLogado, 'stNotificacao' => 1);
        $repository = $service->salvarFavoritos($param);
        
        $dados = array();
        $dados['tipoMsg'] = "S";
        $dados['idFavoritos'] = $repository->getIdFavoritos();
        $dados['stNotificacao'] = $repository->getStNotificacao();
        
        $result = new JsonModel($dados);
        return $result;
    }

    /**
     * Remover Página dos Favoritos do Usuário
     * @return JsonModel
     */
    public function removerFavoritosAction() {
        $post = $this->getRequest()->getPost()->toArray();
        $service = $this->getServiceLocator()->get('Favoritos\Service\FavoritosService');
        $repository = $service->selecionarFavoritos($post['idFavoritos']);
        if ($repository) {
            if ($service->removerFavoritos($repository)) {
                $tipoMsg = "S";
            } else {
                $tipoMsg = "E";
            }
        } else {
            $tipoMsg = "I";
        }
        
        $dados = array();
        $dados['tipoMsg'] = $tipoMsg;
        
        $result = new JsonModel($dados);
        return $result;
    }
    
    /**
     * Alterar Recebimento de Notificações do Cliente ao Usuário
     * @return JsonModel
     */
    public function alterarNotificacaoAction() {
        $post = $this->getRequest()->getPost()->toArray();
        if ($post['stNotificacao'] == 1) {
            $stNotificacao = 2;
        } else {
            $stNotificacao = 1;
        }
        $idUsuarioLogado = $this->identity()->getIdUsuario();
        $service = $this->getServiceLocator()->get('Favoritos\Service\FavoritosService');
        $param = array('idFavoritos' => (int) $post['idFavoritos'], 'idAnunciante' => (int) $post['idAnunciante'], 'idUsuario' => $idUsuarioLogado, 'stNotificacao' => $stNotificacao);
        $service->salvarFavoritos($param);
        
        $dados = array();
        $dados['tipoMsg'] = "S";
        
        $result = new JsonModel($dados);
        return $result;
    }


}
