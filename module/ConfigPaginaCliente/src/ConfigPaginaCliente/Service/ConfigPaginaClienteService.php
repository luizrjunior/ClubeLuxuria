<?php

namespace ConfigPaginaCliente\Service;

use Application\Service\AbstractService;
use Doctrine\ORM\EntityManager;

class ConfigPaginaClienteService extends AbstractService {

    protected $_repository;

    public function __construct(EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'ConfigPaginaCliente\Entity\ConfigPaginaClienteEntity';
        $this->_repository = $this->em->getRepository($this->entity);
    }

    public function selecionarConfigPaginaCliente($id) {
        $repository = $this->_repository->selecionarConfigPaginaCliente($id);
        return $repository;
    }

    public function selecionarConfigPaginaClienteBy($param) {
        $repository = $this->_repository->selecionarConfigPaginaClienteBy($param);
        return $repository;
    }

    public function salvarConfigPaginaCliente($data) {
        $data['idCliente'] = $this->em->getRepository('Cliente\Entity\ClienteEntity')
                ->find($data['idCliente']);
        if (isset($data['idConfigPaginaCliente']) && $data['idConfigPaginaCliente'] != "") {
            $repository = $this->_repository->editarConfigPaginaCliente($data);
        } else {
            $repository = $this->_repository->inserirConfigPaginaCliente($data);
        }
        return $repository;
    }

}