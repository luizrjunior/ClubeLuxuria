<?php

namespace Banner\Service;

use Application\Service\AbstractService;
use Doctrine\ORM\EntityManager;

class BannerService extends AbstractService {

    protected $_repository;

    public function __construct(EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'Banner\Entity\BannerEntity';
        $this->_repository = $this->em->getRepository($this->entity);
    }

    public function verificarNomeExistente($param) {
        $repository = $this->_repository->verificarNomeExistente($param);
        return $repository;
    }
    
    public function selecionarBanner($id) {
        $repository = $this->_repository->selecionarBanner($id);
        return $repository;
    }
    
    public function selecionarBannerBy($param) {
        $repository = $this->_repository->selecionarBannerBy($param);
        return $repository;
    }

    public function listarBannersPaginado($params = array(), $pagina = 1, $range = 10) {
        $result = $this->_repository->listarBannersPaginado($params, $pagina, $range);
        return $result;
    }

    public function salvarBanner($data) {
        $data['idCliente'] = $this->em->getRepository('Cliente\Entity\ClienteEntity')
                ->find($data['idCliente']);
        if (isset($data['idBanner']) && $data['idBanner'] != "") {
            $repository = $this->_repository->editarBanner($data);
        } else {
            $repository = $this->_repository->inserirBanner($data);
        }
        return $repository;
    }

    public function excluirBanner($repository) {
        $entity = $this->_repository->excluirBanner($repository);
        return $entity;
    }
    
}
