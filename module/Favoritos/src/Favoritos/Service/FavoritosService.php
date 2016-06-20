<?php

namespace Favoritos\Service;

use Application\Service\AbstractService;
use Doctrine\ORM\EntityManager;

class FavoritosService extends AbstractService {

    protected $_repository;

    public function __construct(EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'Favoritos\Entity\FavoritosEntity';
        $this->_repository = $this->em->getRepository($this->entity);
    }

    public function selecionarFavoritos($id) {
        $repository = $this->_repository->selecionarFavoritos($id);
        return $repository;
    }

    public function selecionarFavoritosBy($param) {
        $repository = $this->_repository->selecionarFavoritosBy($param);
        return $repository;
    }

    public function listarAnunciantesFavoritos($idUsuario) {
        $result = $this->_repository->listarAnunciantesFavoritos($idUsuario);
        return $result;
    }
    
    public function salvarFavoritos($data) {
        $data['idAnunciante'] = $this->em->getRepository('Anunciante\Entity\AnuncianteEntity')
                ->find($data['idAnunciante']);
        $data['idUsuario'] = $this->em->getRepository('Usuario\Entity\UsuarioEntity')
                ->find($data['idUsuario']);
        if (isset($data['idFavoritos'])) {
            $repository = $this->_repository->editarFavoritos($data);
        } else {
            $repository = $this->_repository->inserirFavoritos($data);
        }
        return $repository;
    }

    public function removerFavoritos($repository) {
        $entity = $this->_repository->excluirFavoritos($repository);
        return $entity;
    }
}
