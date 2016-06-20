<?php

namespace Cliente\Service;

use Application\Service\AbstractService;
use Doctrine\ORM\EntityManager;

class ClienteUsuarioService extends AbstractService {

    protected $_repository;

    public function __construct(EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'Cliente\Entity\ClienteUsuarioEntity';
        $this->_repository = $this->em->getRepository($this->entity);
    }

    public function selecionarClienteUsuarioBy($param) {
        $repository = $this->_repository->selecionarClienteUsuarioBy($param);
        return $repository;
    }

    public function selecionarClienteUsuario($id) {
        $repository = $this->_repository->selecionarClienteUsuario($id);
        return $repository;
    }

    public function listarClientesUsuarios($params = array(), $pagina = 1, $range = 10) {
        $result = $this->_repository->listarClientesUsuarios($params, $pagina, $range);
        return $result;
    }

    public function salvarClienteUsuario($data) {
        $data['idCliente'] = $this->em->getRepository('Cliente\Entity\ClienteEntity')
                ->find($data['idCliente']);
        $data['idUsuario'] = $this->em->getRepository('Usuario\Entity\UsuarioEntity')
                ->find($data['idUsuario']);
        if (isset($data['idClienteUsuario'])) {
            $repository = $this->_repository->editarClienteUsuario($data);
        } else {
            $repository = $this->_repository->inserirClienteUsuario($data);
        }
        return $repository;
    }

    public function excluirClienteUsuario($repository) {
        $entity = $this->_repository->excluirClienteUsuario($repository);
        return $entity;
    }

}
