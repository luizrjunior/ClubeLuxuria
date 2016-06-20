<?php

namespace Depoimento\Service;

use Application\Service\AbstractService;
use Doctrine\ORM\EntityManager;

class DepoimentoService extends AbstractService {

    protected $_repository;

    public function __construct(EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'Depoimento\Entity\DepoimentoEntity';
        $this->_repository = $this->em->getRepository($this->entity);
    }

    public function verificarDepoimentoExistente($param) {
        $repository = $this->_repository->verificarDepoimentoExistente($param);
        return $repository;
    }

    public function selecionarDepoimento($id) {
        $repository = $this->_repository->selecionarDepoimento($id);
        return $repository;
    }

    public function selecionarDepoimentoBy($param) {
        $repository = $this->_repository->selecionarDepoimentoBy($param);
        return $repository;
    }

    public function listarDepoimentosPaginado($params = array(), $pagina = 1, $range = 10) {
        $result = $this->_repository->listarDepoimentosPaginado($params, $pagina, $range);
        return $result;
    }

    public function salvarDepoimento($data) {
        $data['idCliente'] = $this->em->getRepository('Cliente\Entity\ClienteEntity')
                ->find($data['idCliente']);
        $data['idUsuario'] = $this->em->getRepository('Usuario\Entity\UsuarioEntity')
                ->find($data['idUsuario']);
        if (isset($data['idDepoimento']) && $data['idDepoimento'] != "") {
            $repository = $this->_repository->editarDepoimento($data);
        } else {
            $repository = $this->_repository->inserirDepoimento($data);
        }
        return $repository;
    }

    public function excluirDepoimento($repository) {
        $entity = $this->_repository->excluirDepoimento($repository);
        return $entity;
    }

}
