<?php

namespace Caracteristicas\Service;

use Application\Service\AbstractService;
use Doctrine\ORM\EntityManager;

class CaracteristicasService extends AbstractService {

    protected $_repository;

    public function __construct(EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'Caracteristicas\Entity\CaracteristicasEntity';
        $this->_repository = $this->em->getRepository($this->entity);
    }

    public function verificarCaracteristicaExistente($noCaracteristica, $idCaracteristica) {
        $repository = $this->_repository->verificarCaracteristicaExistente($noCaracteristica, $idCaracteristica);
        return $repository;
    }

    public function selecionarCaracteristicaBy($param) {
        $repository = $this->_repository->selecionarCaracteristicaBy($param);
        return $repository;
    }

    public function selecionarCaracteristica($id) {
        $repository = $this->_repository->selecionarCaracteristica($id);
        return $repository;
    }

    public function listarCaracteristicas($params = array()) {
        $result = $this->_repository->listarCaracteristicas($params);
        return $result;
    }

    public function listarCaracteristicasPaginados($params = array(), $pagina = 1, $range = 10) {
        $result = $this->_repository->listarCaracteristicasPaginados($params, $pagina, $range);
        return $result;
    }

    public function salvarCaracteristica($data) {
        if (isset($data['idCaracteristica']) && $data['idCaracteristica'] != "") {
            $repository = $this->_repository->editarCaracteristica($data);
        } else {
            $repository = $this->_repository->inserirCaracteristica($data);
        }
        return $repository;
    }

    public function excluirCaracteristica($repository) {
        $entity = $this->_repository->excluirCaracteristica($repository);
        return $entity;
    }

}
