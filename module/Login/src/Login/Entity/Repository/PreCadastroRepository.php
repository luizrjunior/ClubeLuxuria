<?php

namespace Login\Entity\Repository;

use Login\Entity\PreCadastroEntity;
use Doctrine\ORM\EntityRepository;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Zend\Stdlib\Hydrator;

/**
 * PreCadastroRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PreCadastroRepository extends EntityRepository
{
   
    public function alteraDadosPreCadastro($array){
        $this->createQueryBuilder($alias);
    }//altera dados cadastrais usuario
}