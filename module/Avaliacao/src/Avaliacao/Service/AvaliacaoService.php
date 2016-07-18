<?php

namespace Avaliacao\Service;

use Application\Service\AbstractService;
use Doctrine\ORM\EntityManager;

class AvaliacaoService extends AbstractService {

    protected $_repository;

    public function __construct(EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'Avaliacao\Entity\AvaliacaoEntity';
        $this->_repository = $this->em->getRepository($this->entity);
    }

    public function verificarNomeArtisticoExistente($param) {
        $repository = $this->_repository->verificarNomeArtisticoExistente($param);
        return $repository;
    }
    
    public function selecionarAvaliacaoBy($param) {
        $repository = $this->_repository->selecionarAvaliacaoBy($param);
        return $repository;
    }

    public function pegarNomeAvaliacaoCliente($idCliente) {
        $repository = $this->_repository->pegarNomeAvaliacaoCliente($idCliente);
        return $repository;
    }

    public function listarAvaliacaosNovidades($params = array()) {
        $result = $this->_repository->listarAvaliacaosNovidades($params);
        return $result;
    }
    
    public function listarAvaliacaosHome($params = array()) {
        $result = $this->_repository->listarAvaliacaosHome($params);
        return $result;
    }
    
    public function listarAvaliacaosHomePaginado($params = array(), $pagina = 1, $range = 10) {
        $result = $this->_repository->listarAvaliacaosHomePaginado($params, $pagina, $range);
        return $result;
    }
    
    public function listarAvaliacaosPaginado($params = array(), $pagina = 1, $range = 10) {
        $result = $this->_repository->listarAvaliacaosPaginado($params, $pagina, $range);
        return $result;
    }
    
    public function listarAvaliacaosDestaques($params = array()) {
        $result = $this->_repository->listarAvaliacaosDestaques($params);
        return $result;
    }
    
    public function salvarAvaliacao($data) {
        $data['idCliente'] = $this->em->getRepository('Cliente\Entity\ClienteEntity')
                ->find($data['idCliente']);
        $data['idCidade'] = $this->em->getRepository('Cidade\Entity\CidadeEntity')
                ->find($data['idCidade']);
        if (isset($data['idAvaliacao']) && $data['idAvaliacao'] != "") {
            $repository = $this->_repository->editarAvaliacao($data);
        } else {
            $repository = $this->_repository->inserirAvaliacao($data);
        }
        return $repository;
    }
    
}
