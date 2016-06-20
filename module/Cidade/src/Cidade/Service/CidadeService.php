<?php

namespace Cidade\Service;

use Application\Service\AbstractService;
use Doctrine\ORM\EntityManager;

class CidadeService extends AbstractService {

    protected $_repository;

    public function __construct(EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'Cidade\Entity\CidadeEntity';
        $this->_repository = $this->em->getRepository($this->entity);
    }

    public function verificarCidadeExistente($noCidade, $idCidade) {
        $repository = $this->_repository->verificarCidadeExistente($noCidade, $idCidade);
        return $repository;
    }

    public function selecionarCidadeBy($param) {
        $repository = $this->_repository->selecionarCidadeBy($param);
        return $repository;
    }

    public function selecionarCidade($id) {
        $repository = $this->_repository->selecionarCidade($id);
        return $repository;
    }

    public function listarCidade($params = array()) {
        $result = $this->_repository->listarCidade($params);
        return $result;
    }

    public function listarCidadePaginados($params = array(), $pagina = 1, $range = 10) {
        $result = $this->_repository->listarCidadePaginados($params, $pagina, $range);
        return $result;
    }

    public function salvarCidade($data) {
        if (isset($data['idCidade']) && $data['idCidade'] != "") {
            $repository = $this->_repository->editarCidade($data);
        } else {
            $repository = $this->_repository->inserirCidade($data);
        }
        return $repository;
    }

    public function excluirCidade($repository) {
        $entity = $this->_repository->excluirCidade($repository);
        return $entity;
    }

}
