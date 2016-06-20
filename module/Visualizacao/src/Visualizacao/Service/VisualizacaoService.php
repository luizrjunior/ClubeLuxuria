<?php

namespace Visualizacao\Service;

use Application\Service\AbstractService;
use Doctrine\ORM\EntityManager;

class VisualizacaoService extends AbstractService {

    protected $_repository;

    public function __construct(EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'Visualizacao\Entity\VisualizacaoEntity';
        $this->_repository = $this->em->getRepository($this->entity);
    }

    public function salvarVisualizacao($data) {
        $data['idCliente'] = $this->em->getRepository('Cliente\Entity\ClienteEntity')
                ->find($data['idCliente']);
        if ($data['idUsuario']) {
        $data['idUsuario'] = $this->em->getRepository('Usuario\Entity\UsuarioEntity')
                ->find($data['idUsuario']);
        } else {
            unset($data['idUsuario']);
        }
        $repository = $this->_repository->inserirVisualizacao($data);
        return $repository;
    }

}
