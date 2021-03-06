<?php

namespace Pagamento\Entity\Repository;

use Pagamento\Entity\PagamentoEntity;
use Doctrine\ORM\EntityRepository;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Zend\Stdlib\Hydrator;

/**
 * PagamentoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PagamentoRepository extends EntityRepository {

    public function verificarPagamentoExistente($param) {
        $Pagamento = $this->createQueryBuilder('a')
                        ->innerJoin('a.idCliente', 'b')
                        ->andWhere('a.idCliente = :idCliente')
                        ->setParameter('idCliente', $param['idCliente'])
                        ->andWhere('a.stPagamento IN (:stPagamento)')
                        ->setParameter('stPagamento', $param['stPagamento'])
                        ->getQuery()->getOneOrNullResult();
        if (!is_null($Pagamento)) {
            if ($param['idPagamento'] != $Pagamento->getIdPagamento()) {
                return $Pagamento;
            }
        }
        return false;
    }

    public function inserirPagamento($param = array()) {
        $entity = new PagamentoEntity($param);

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        return $entity;
    }

    public function editarPagamento($param = array()) {
        $entity = $this->getEntityManager()->getReference('Pagamento\Entity\PagamentoEntity', $param['idPagamento']);
        (new Hydrator\ClassMethods())->hydrate($param, $entity);

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        return $entity;
    }

    public function selecionarPagamento($id) {
        $repository = $this->find($id);
        return $repository;
    }

    public function selecionarPagamentoBy($param) {
        $repository = $this->findBy($param);
        return $repository;
    }

    public function listarPagamentosPaginado($param = array(), $pagina = 1, $itens = 10) {
        $queryCreate = $this->criarConsultaPagamentos($param);

        $paginado = new ORMPaginator($queryCreate->getQuery());
        $paginado->setUseOutputWalkers(FALSE);

        $adapter = new DoctrineAdapter($paginado);

        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage($itens);
        $paginator->setCurrentPageNumber($pagina);

        return $paginator;
    }

    private function criarConsultaPagamentos($param = array()) {
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select(array('a.idPagamento', 'a.tpPagamento', 'a.vlPagamento',
            'a.stPagamento', 'a.dtPagamento', 'a.dtDeposito', 
            'b.idCliente', 'b.tpCliente', 'b.noCliente'))
                ->from('Pagamento\Entity\PagamentoEntity', 'a')
                ->innerJoin('a.idCliente', 'b');
        if (!empty($param['idClientePsqPagamento'])) {
            $query->andWhere("b.idCliente = :idCliente")
            ->setParameter('idCliente', $param['idClientePsqPagamento']);
        }
        if (!empty($param['noClientePsq'])) {
            $query->andWhere("b.noCliente LIKE :noCliente")
            ->setParameter('noCliente', "%{$param['noClientePsq']}%");
        }
        if ($param['tpPagamentoPsq'] != "T") {
            $query->andWhere("a.tpPagamento = :tpPagamentoPsq")
            ->setParameter('tpPagamentoPsq', $param['tpPagamentoPsq']);
        }
        if ($param['stPagamentoPsq'] != "T") {
            $query->andWhere("a.stPagamento = :stPagamentoPsq")
            ->setParameter('stPagamentoPsq', $param['stPagamentoPsq']);
        }
        if (!empty($param['dtInicioPsq'])) {
            $query->andWhere('a.dtCadastro >= :dtInicioPsq')
            ->setParameter('dtInicioPsq', \DateTime::createFromFormat('d/m/Y', $param['dtInicioPsq']));
        }
        if (!empty($param['dtFimPsq'])) {
            $query->andWhere('a.dtCadastro <= :dtFimPsq')
            ->setParameter('dtFimPsq', \DateTime::createFromFormat('d/m/Y', $param['dtFimPsq']));
        }
        $query->addOrderBy('a.idPagamento', 'DESC');
        return $query;
    }

    public function excluirPagamento($repository) {
        $this->getEntityManager()->remove($repository);
        $this->getEntityManager()->flush();
        return $repository;
    }

}
