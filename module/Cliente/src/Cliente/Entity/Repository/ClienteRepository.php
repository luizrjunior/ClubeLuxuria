<?php

namespace Cliente\Entity\Repository;

use Cliente\Entity\ClienteEntity;
use Doctrine\ORM\EntityRepository;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Zend\Stdlib\Hydrator;

/**
 * ClienteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ClienteRepository extends EntityRepository {

    public function verificarNomeClienteExistente($param) {
        $Cliente = $this->createQueryBuilder('a')
                        ->where('a.noCliente LIKE :noCliente')
                        ->setParameter('noCliente', $param['noCliente'])->getQuery()->getOneOrNullResult();
        if (!is_null($Cliente)) {
            if ($param['idCliente'] != $Cliente->getIdCliente()) {
                return $Cliente;
            }
        }
        return false;
    }

    public function verificarCpfClienteExistente($param) {
        $Cliente = $this->createQueryBuilder('a')
                        ->where('a.nuCpf LIKE :nuCpf')
                        ->setParameter('nuCpf', $param['nuCpf'])->getQuery()->getOneOrNullResult();
        if (!is_null($Cliente)) {
            if ($param['idCliente'] != $Cliente->getIdCliente()) {
                return $Cliente;
            }
        }
        return false;
    }

    public function inserirCliente($param = array()) {
        $entity = new ClienteEntity($param);

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        return $entity;
    }

    public function editarCliente($param = array()) {
        $entity = $this->getEntityManager()->getReference('Cliente\Entity\ClienteEntity', $param['idCliente']);
        (new Hydrator\ClassMethods())->hydrate($param, $entity);

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        return $entity;
    }

    public function selecionarCliente($id) {
        $repository = $this->find($id);
        return $repository;
    }

    public function listarClientes($param = array(), $pagina = 1, $itens = 10) {
        $stHome = 2;
        $queryCreate = $this->criarConsultaClientes($param, $stHome);

        $paginado = new ORMPaginator($queryCreate->getQuery());
        $paginado->setUseOutputWalkers(FALSE);

        $adapter = new DoctrineAdapter($paginado);

        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage($itens);
        $paginator->setCurrentPageNumber($pagina);

        return $paginator;
    }

    public function listarClientesHome($param = array()) {
        $stHome = 1;
        $queryCreate = $this->criarConsultaClientes($param, $stHome);
        $listaClientes = $queryCreate->getQuery()->getResult();

        return $listaClientes;
    }

    private function criarConsultaClientes($param = array(), $stHome) {
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select(array(
            'a.idCliente', 'a.dtHrCadastro', 'a.noCliente', 'a.noCidade', 
            'a.sgUf', 'a.nuTelefone', 'a.stCliente', 'a.tpCliente', 'a.dtVencimento'
        ));
        $query->from('Cliente\Entity\ClienteEntity', 'a');
        if ($param['idClientePsq'] != "") {
            $query->andWhere("a.idCliente = :idClientePsq")
                    ->setParameter('idClientePsq', $param['idClientePsq']);
        }
        if ($param['tpClientePsq'] != "T") {
            $query->andWhere("a.tpCliente = :tpClientePsq")
                    ->setParameter('tpClientePsq', $param['tpClientePsq']);
        }
        if ($param['stClientePsq'] != "T") {
            $query->andWhere("a.stCliente = :stCliente")
                    ->setParameter('stCliente', $param['stClientePsq']);
        }
        if (!empty($param['noClientePsq'])) {
            $query->andWhere("a.noCliente LIKE :noCliente")
                    ->setParameter('noCliente', "{$param['noClientePsq']}%");
        }
        if (!empty($param['nuCpfPsq'])) {
            $query->andWhere("a.nuCpf LIKE :nuCpf")
                    ->setParameter('nuCpf', "{$param['nuCpfPsq']}%");
        }
        if ($param['sgUfPsq'] != "") {
            $query->andWhere("a.sgUf = :sgUf")
                    ->setParameter('sgUf', $param['sgUfPsq']);
        }
        if (!empty($param['dtVencimentoPsq'])) {
            $query->andWhere('a.dtVencimento >= :dtVencimentoPsq')
            ->setParameter('dtVencimentoPsq', \DateTime::createFromFormat('d/m/Y', $param['dtVencimentoPsq']));
        }
        if ($stHome == 1) {
            $minutos = date("i");
            if ($minutos >= 1 && $minutos <= 15) {
                $query->addOrderBy('a.noCliente', 'ASC');
            } elseif ($minutos >= 16 && $minutos <= 30) {
                $query->addOrderBy('a.noCliente', 'DESC');
            } elseif ($minutos >= 31 && $minutos <= 45) {
                $query->addOrderBy('a.idCliente', 'ASC');
            } elseif ($minutos >= 46) {
                $query->addOrderBy('a.idCliente', 'DESC');
            }
        } else {
            $query->addOrderBy('a.idCliente', 'DESC');
        }
        
//        echo '<pre>';
//        print_r($query->getQuery()->getSQL());
//        echo '<pre/>';
//        die();
        
        return $query;
    }

}
