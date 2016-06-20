<?php
namespace Cliente\Service;

use Application\Service\AbstractService;
use Doctrine\ORM\EntityManager;

class ClienteService extends AbstractService
{
    protected $_repository;

    public function __construct(EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'Cliente\Entity\ClienteEntity';
        $this->_repository = $this->em->getRepository($this->entity);
    }

    public function verificarNomeClienteExistente($param) {
        $repository = $this->_repository->verificarNomeClienteExistente($param);
        return $repository;
    }
    
    public function verificarCpfClienteExistente($param) {
        $repository = $this->_repository->verificarCpfClienteExistente($param);
        return $repository;
    }
    
    public function selecionarClienteBy($param) {
        $repository = $this->_repository->selecionarClienteBy($param);
        return $repository;
    }
    
    public function selecionarCliente($id) {
        $repository = $this->_repository->selecionarCliente($id);
        return $repository;
    }
    
    public function listarClientesHome($params = array()) {
        $result = $this->_repository->listarClientesHome($params);
        return $result;
    }
    
    public function listarClientes($params = array(), $pagina = 1, $range = 10) {
        $result = $this->_repository->listarClientes($params, $pagina, $range);
        return $result;
    }
    
    public function salvarCliente($data) {
        if (isset($data['idCliente']) && $data['idCliente'] != "") {
            $repository = $this->_repository->editarCliente($data);
        } else {
           $repository = $this->_repository->inserirCliente($data);
        }
        
        return $repository;
    }
    
    public function excluirCliente($repository) {
        $entity = $this->_repository->excluirCliente($repository);
        return $entity;
    }
    
}