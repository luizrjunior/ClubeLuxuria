<?php

namespace Contato\Service;

use Application\Service\AbstractService;
use Doctrine\ORM\EntityManager;

class ContatoService extends AbstractService {

    protected $_repository;

    public function __construct(EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'Contato\Entity\ContatoEntity';
        $this->_repository = $this->em->getRepository($this->entity);
    }

    public function selecionarContato($id) {
        $repository = $this->_repository->selecionarContato($id);
        return $repository;
    }

    public function listarContatos($params = array(), $pagina = 1, $range = 10) {
        $result = $this->_repository->listarContatos($params, $pagina, $range);
        return $result;
    }

    public function salvarContato($data) {
        $data['idAssunto'] = $this->em->getRepository('Contato\Entity\AssuntoEntity')
                ->find($data['idAssunto']);
        if (isset($data['idContato'])) {
            $repository = $this->_repository->editarContato($data);
        } else {
            $repository = $this->_repository->inserirContato($data);
        }
        return $repository;
    }

    public function excluirContato($repository) {
        $entity = $this->_repository->excluirContato($repository);
        return $entity;
    }

}
