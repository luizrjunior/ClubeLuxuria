<?php

namespace Usuario\Service;

use Application\Service\AbstractService;
use Doctrine\ORM\EntityManager;

class UsuarioService extends AbstractService {

    protected $_repository;

    public function __construct(EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'Usuario\Entity\UsuarioEntity';
        $this->_repository = $this->em->getRepository($this->entity);
    }

    public function verificarLoginExistente($login, $idUsuario) {
        $repository = $this->_repository->verificarLoginExistente($login, $idUsuario);
        return $repository;
    }

    public function selecionarUsuarioBy($param) {
        $repository = $this->_repository->selecionarUsuarioBy($param);
        return $repository;
    }

    public function selecionarUsuario($id) {
        $repository = $this->_repository->selecionarUsuario($id);
        return $repository;
    }

    public function listarUsuarios($params = array()) {
        $result = $this->_repository->listarUsuarios($params);
        return $result;
    }

    public function listarUsuariosPaginados($params = array(), $pagina = 1, $range = 10) {
        $result = $this->_repository->listarUsuariosPaginados($params, $pagina, $range);
        return $result;
    }

    public function salvarUsuario($data) {
        if (isset($data['idUsuario'])) {
            $repository = $this->_repository->editarUsuario($data);
        } else {
            $repository = $this->_repository->inserirUsuario($data);
        }
        return $repository;
    }

    public function excluirUsuario($repository) {
        $entity = $this->_repository->excluirUsuario($repository);
        return $entity;
    }

}
