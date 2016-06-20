<?php

namespace Anunciante\Service;

use Application\Service\AbstractService;
use Doctrine\ORM\EntityManager;

class AnuncianteService extends AbstractService {

    protected $_repository;

    public function __construct(EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'Anunciante\Entity\AnuncianteEntity';
        $this->_repository = $this->em->getRepository($this->entity);
    }

    public function verificarNomeArtisticoExistente($param) {
        $repository = $this->_repository->verificarNomeArtisticoExistente($param);
        return $repository;
    }
    
    public function selecionarAnuncianteBy($param) {
        $repository = $this->_repository->selecionarAnuncianteBy($param);
        return $repository;
    }

    public function pegarNomeAnuncianteCliente($idCliente) {
        $repository = $this->_repository->pegarNomeAnuncianteCliente($idCliente);
        return $repository;
    }

    public function listarAnunciantesNovidades($params = array()) {
        $result = $this->_repository->listarAnunciantesNovidades($params);
        return $result;
    }
    
    public function listarAnunciantesHome($params = array()) {
        $result = $this->_repository->listarAnunciantesHome($params);
        return $result;
    }
    
    public function listarAnunciantesPaginado($params = array(), $pagina = 1, $range = 10) {
        $result = $this->_repository->listarAnunciantesPaginado($params, $pagina, $range);
        return $result;
    }
    
    public function listarAnunciantesDestaques($params = array()) {
        $result = $this->_repository->listarAnunciantesDestaques($params);
        return $result;
    }
    
    public function salvarAnunciante($data) {
        $data['idCliente'] = $this->em->getRepository('Cliente\Entity\ClienteEntity')
                ->find($data['idCliente']);
        $data['idCidade'] = $this->em->getRepository('Cidade\Entity\CidadeEntity')
                ->find($data['idCidade']);
        if (isset($data['idAnunciante']) && $data['idAnunciante'] != "") {
            $repository = $this->_repository->editarAnunciante($data);
        } else {
            $repository = $this->_repository->inserirAnunciante($data);
        }
        return $repository;
    }
    
}
