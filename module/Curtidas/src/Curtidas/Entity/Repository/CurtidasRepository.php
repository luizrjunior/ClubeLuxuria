<?php

namespace Curtidas\Entity\Repository;

use Curtidas\Entity\CurtidasEntity;
use Doctrine\ORM\EntityRepository;
use Zend\Stdlib\Hydrator;

/**
 * CurtidasRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CurtidasRepository extends EntityRepository {

    public function selecionarCurtidas($id) {
        $repository = $this->find($id);
        return $repository;
    }

    public function selecionarCurtidasBy($param) {
        $repository = $this->findBy($param);
        return $repository;
    }

    public function inserirCurtidas($param = array()) {
        $entity = new CurtidasEntity($param);
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
        return $entity;
    }

    public function editarCurtidas($param = array()) {
        $entity = $this->getEntityManager()->getReference('Curtidas\Entity\CurtidasEntity', $param['idCurtidas']);
        (new Hydrator\ClassMethods())->hydrate($param, $entity);
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
        return $entity;
    }

    public function excluirCurtidas($repository) {
        $this->getEntityManager()->remove($repository);
        $this->getEntityManager()->flush();
        return $repository;
    }
    
}