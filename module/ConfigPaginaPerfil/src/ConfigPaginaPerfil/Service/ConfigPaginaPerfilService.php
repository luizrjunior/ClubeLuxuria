<?php

namespace ConfigPaginaPerfil\Service;

use Application\Service\AbstractService;
use Doctrine\ORM\EntityManager;

class ConfigPaginaPerfilService extends AbstractService {

    protected $_repository;

    public function __construct(EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'ConfigPaginaPerfil\Entity\ConfigPaginaPerfilEntity';
        $this->_repository = $this->em->getRepository($this->entity);
    }

    public function selecionarConfigPaginaPerfil($id) {
        $repository = $this->_repository->selecionarConfigPaginaPerfil($id);
        return $repository;
    }

    public function selecionarConfigPaginaPerfilBy($param) {
        $repository = $this->_repository->selecionarConfigPaginaPerfilBy($param);
        return $repository;
    }

    public function salvarConfigPaginaPerfil($data) {
        $data['idUsuario'] = $this->em->getRepository('Usuario\Entity\UsuarioEntity')
                ->find($data['idUsuario']);
        if (isset($data['idConfigPaginaPerfil']) && $data['idConfigPaginaPerfil'] != "") {
            $repository = $this->_repository->editarConfigPaginaPerfil($data);
        } else {
            $repository = $this->_repository->inserirConfigPaginaPerfil($data);
        }
        return $repository;
    }

}