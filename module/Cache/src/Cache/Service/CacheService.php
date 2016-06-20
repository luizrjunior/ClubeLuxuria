<?php

namespace Cache\Service;

use Application\Service\AbstractService;
use Doctrine\ORM\EntityManager;

class CacheService extends AbstractService {

    protected $_repository;

    public function __construct(EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'Cache\Entity\CacheEntity';
        $this->_repository = $this->em->getRepository($this->entity);
    }

    public function verificarNomeExistente($param) 
    {
        $repository = $this->_repository->verificarNomeExistente($param);
        return $repository;
    }
    
    public function selecionarCache($id) 
    {
        $repository = $this->_repository->selecionarCache($id);
        return $repository;
    }
    
    public function selecionarCacheBy($param) {
        $repository = $this->_repository->selecionarCacheBy($param);
        return $repository;
    }

    public function listarCachesPaginado($params = array(), $pagina = 1, $range = 10) {
        $result = $this->_repository->listarCachesPaginado($params, $pagina, $range);
        return $result;
    }

    public function salvarCache($data) {
        $data['idCliente'] = $this->em->getRepository('Cliente\Entity\ClienteEntity')
                ->find($data['idCliente']);
        if (isset($data['idCache']) && $data['idCache'] != "") {
            $repository = $this->_repository->editarCache($data);
        } else {
            $repository = $this->_repository->inserirCache($data);
        }
        return $repository;
    }

    public function excluirCache($repository) {
        $entity = $this->_repository->excluirCache($repository);
        return $entity;
    }
    
}
