<?php

namespace Video\Service;

use Application\Service\AbstractService;
use Doctrine\ORM\EntityManager;

class VideoService extends AbstractService {

    protected $_repository;

    public function __construct(EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'Video\Entity\VideoEntity';
        $this->_repository = $this->em->getRepository($this->entity);
    }

    public function verificarNomeExistente($param) {
        $repository = $this->_repository->verificarNomeExistente($param);
        return $repository;
    }
    
    public function selecionarVideo($id) {
        $repository = $this->_repository->selecionarVideo($id);
        return $repository;
    }
    
    public function selecionarVideoBy($param) {
        $repository = $this->_repository->selecionarVideoBy($param);
        return $repository;
    }

    public function listarVideosPaginado($params = array(), $pagina = 1, $range = 10) {
        $result = $this->_repository->listarVideosPaginado($params, $pagina, $range);
        return $result;
    }

    public function salvarVideo($data) {
        $data['idCliente'] = $this->em->getRepository('Cliente\Entity\ClienteEntity')
                ->find($data['idCliente']);
        if (isset($data['idVideo']) && $data['idVideo'] != "") {
            $repository = $this->_repository->editarVideo($data);
        } else {
            $repository = $this->_repository->inserirVideo($data);
        }
        return $repository;
    }

    public function excluirVideo($repository) {
        $entity = $this->_repository->excluirVideo($repository);
        return $entity;
    }
    
}
