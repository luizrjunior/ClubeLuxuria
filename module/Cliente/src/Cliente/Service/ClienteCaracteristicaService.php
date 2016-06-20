<?php

namespace Cliente\Service;

use Application\Service\AbstractService;
use Doctrine\ORM\EntityManager;

class ClienteCaracteristicaService extends AbstractService {

    protected $_repository;

    public function __construct(EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'Cliente\Entity\ClienteCaracteristicaEntity';
        $this->_repository = $this->em->getRepository($this->entity);
    }

    public function selecionarClienteCaracteristicaBy($param) {
        $repository = $this->_repository->selecionarClienteCaracteristicaBy($param);
        return $repository;
    }

    public function salvarClienteCaracteristica($idCliente, $idCaracteristica) {
        $data['idCliente'] = $this->em->getRepository('Cliente\Entity\ClienteEntity')
                ->find($idCliente);
        $data['idCaracteristica'] = $this->em->getRepository('Caracteristicas\Entity\CaracteristicasEntity')
                ->find($idCaracteristica);
        $data['stClienteCaracteristica'] = 1;
        if (isset($data['idClienteCaracteristica'])) {
            $repository = $this->_repository->editarClienteCaracteristica($data);
        } else {
            $repository = $this->_repository->inserirClienteCaracteristica($data);
        }
        return $repository;
    }

    public function desativarClienteCaracteristica($idCliente, $tpCaracteristica) {
        $this->_repository->desativarClienteCaracteristica($idCliente, $tpCaracteristica);
    }

}
