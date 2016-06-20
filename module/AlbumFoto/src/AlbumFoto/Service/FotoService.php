<?php

namespace AlbumFoto\Service;

use Application\Service\AbstractService;
use Doctrine\ORM\EntityManager;

class FotoService extends AbstractService {

    protected $_repository;

    public function __construct(EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'AlbumFoto\Entity\FotoEntity';
        $this->_repository = $this->em->getRepository($this->entity);
    }

    public function verificarFotoAlbumPrincipalExitente($param) {
        $repository = $this->_repository->verificarFotoAlbumPrincipalExitente($param);
        return $repository;
    }
    
    public function verificarFoto($param) {
        $repository = $this->_repository->selecionarFotoBy($param);
        return $repository;
    }
    
    public function verificarFotoHorizontal($param) {
        $repository = $this->_repository->selecionarFotoBy($param);
        return $repository;
    }
    
    public function verificarFotoVertical($param) {
        $repository = $this->_repository->selecionarFotoBy($param);
        return $repository;
    }
    
    public function verificarNomeExistente($param) {
        $repository = $this->_repository->verificarNomeExistente($param);
        return $repository;
    }
    
    public function selecionarFoto($id) {
        $repository = $this->_repository->selecionarFoto($id);
        return $repository;
    }
    
    public function selecionarFotoBy($param) {
        $repository = $this->_repository->selecionarFotoBy($param);
        return $repository;
    }

    public function listarFotos($params = array()) {
        $result = $this->_repository->listarFotos($params);
        return $result;
    }
    
    public function listarFotosPaginado($params = array(), $pagina = 1, $range = 10) {
        $result = $this->_repository->listarFotosPaginado($params, $pagina, $range);
        return $result;
    }
    
    public function salvarFoto($data) {
        $data['idAlbum'] = $this->em->getRepository('AlbumFoto\Entity\AlbumEntity')
                ->find($data['idAlbum']);
        if (isset($data['idFoto']) && $data['idFoto'] != "") {
            $repository = $this->_repository->editarFoto($data);
        } else {
            $repository = $this->_repository->inserirFoto($data);
        }
        return $repository;
    }

    public function excluirFoto($repository) {
        $entity = $this->_repository->excluirFoto($repository);
        return $entity;
    }
    
}
