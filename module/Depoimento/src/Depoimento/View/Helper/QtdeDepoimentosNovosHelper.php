<?php

namespace Depoimento\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Db\Sql\Sql;

class QtdeDepoimentosNovosHelper extends AbstractHelper {

    protected $dbAdapter;

    function __construct(\Zend\Db\Adapter\Adapter $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
    }

    public function __invoke($idCliente) {
        return $this->mostrarQtdeDepoimentosNovos($idCliente);
    }

    public function mostrarQtdeDepoimentosNovos($idCliente) {
        try {
            $sql = new Sql($this->dbAdapter);
            $select = $sql->select();
            $select->from(array('a' => 'tb_depoimento'));
            $select->where(array('a.ST_DEPOIMENTO' => 1));
            if ($idCliente != "") {
                $select->where(array('a.ID_CLIENTE' => (int) $idCliente));
            }
            $select->order('a.ID_DEPOIMENTO ASC');
            $statement = $sql->prepareStatementForSqlObject($select);
            $stmt = $statement->execute();
            $qtdeRegistros = count($stmt);
            return $qtdeRegistros;
        } catch (Exception $e) {
            return 0;
        }
    }

}
