<?php

namespace Agenda\Entity\Repository;

use Agenda\Entity\AgendaEventoDataEntity;
use Doctrine\ORM\EntityRepository;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Zend\Stdlib\Hydrator;

/**
 * AgendaEventoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AgendaEventoDataRepository extends EntityRepository
{
    
    //Variáveis de Controle
    //Dia da Semana
    public $_ds_dia_semana = array(
        1 => 'Domingo',
        2 => 'Segunda',
        3 => 'Terça',
        4 => 'Quarta',
        5 => 'Quinta',
        6 => 'Sexta',
        7 => 'Sábado'
    );//Dia da semana
    
    //Função que verifica se o código ja esá cadastrado
     public function listaDatas($idEvento){
        $select = $this->getEntityManager()->createQueryBuilder()
                  ->select(array('d.diaSemana','d.dtMes','d.hrIni','d.hrFinal'))
                  ->from('Agenda\Entity\AgendaEventoDataEntity' , 'd')
                  ->where('d.fkIdEventoData = :id')
                  ->setParameter('id', $idEvento);
        
        $qry    = $select->getQuery();
        $result = $qry->getResult();
        return $result;        
    }//função para lista eventos
    
}//AgendaEventoRepository