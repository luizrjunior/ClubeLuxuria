<?php

namespace Pagamento\Service;

use Application\Service\AbstractService;
use Doctrine\ORM\EntityManager;

class PagamentoService extends AbstractService {

    protected $_repository;

    public function __construct(EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'Pagamento\Entity\PagamentoEntity';
        $this->_repository = $this->em->getRepository($this->entity);
    }

    public function verificarPagamentoExistente($param) {
        $repository = $this->_repository->verificarPagamentoExistente($param);
        return $repository;
    }
    
    public function selecionarPagamento($id) {
        $repository = $this->_repository->selecionarPagamento($id);
        return $repository;
    }
    
    public function selecionarPagamentoBy($param) {
        $repository = $this->_repository->selecionarPagamentoBy($param);
        return $repository;
    }

    public function listarPagamentosPaginado($params = array(), $pagina = 1, $range = 10) {
        $result = $this->_repository->listarPagamentosPaginado($params, $pagina, $range);
        return $result;
    }

    public function salvarPagamento($data) {
        $data['idCliente'] = $this->em->getRepository('Cliente\Entity\ClienteEntity')
                ->find($data['idCliente']);
        if (isset($data['idPagamento']) && $data['idPagamento'] != "") {
            $repository = $this->_repository->editarPagamento($data);
        } else {
            $repository = $this->_repository->inserirPagamento($data);
        }
        return $repository;
    }

    public function excluirPagamento($repository) {
        $entity = $this->_repository->excluirPagamento($repository);
        return $entity;
    }
    
}
