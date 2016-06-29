<?php

namespace AlbumFoto\Service;

use Application\Service\AbstractService;
use Doctrine\ORM\EntityManager;

class AlbumService extends AbstractService {

    protected $_repository;

    public function __construct(EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'AlbumFoto\Entity\AlbumEntity';
        $this->_repository = $this->em->getRepository($this->entity);
    }

    public function verificarAlbumPrincipalExitente($param) {
        $repository = $this->_repository->verificarAlbumPrincipalExitente($param);
        return $repository;
    }
    
    public function verificarNomeExistente($param) {
        $repository = $this->_repository->verificarNomeExistente($param);
        return $repository;
    }
    
    public function selecionarAlbum($id) {
        $repository = $this->_repository->selecionarAlbum($id);
        return $repository;
    }
    
    public function selecionarAlbumBy($param) {
        $repository = $this->_repository->selecionarAlbumBy($param);
        return $repository;
    }

    public function listarAlbumsPaginado($params = array(), $pagina = 1, $range = 10) {
        $result = $this->_repository->listarAlbumsPaginado($params, $pagina, $range);
        return $result;
    }

    public function listarMeusAlbunsPaginado($params = array(), $pagina = 1, $range = 10) {
        $result = $this->_repository->listarMeusAlbunsPaginado($params, $pagina, $range);
        return $result;
    }

    public function listarAlbums($params = array()) {
        $result = $this->_repository->listarAlbums($params);
        return $result;
    }

    public function salvarAlbum($data) {
        $data['idCliente'] = $this->em->getRepository('Cliente\Entity\ClienteEntity')
                ->find($data['idCliente']);
        if (isset($data['idAlbum']) && $data['idAlbum'] != "") {
            $repository = $this->_repository->editarAlbum($data);
        } else {
            $repository = $this->_repository->inserirAlbum($data);
        }
        return $repository;
    }

    public function excluirAlbum($repository) {
        $entity = $this->_repository->excluirAlbum($repository);
        return $entity;
    }
    
}
