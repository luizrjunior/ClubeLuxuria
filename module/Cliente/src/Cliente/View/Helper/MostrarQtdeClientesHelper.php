<?php

namespace Cliente\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Db\Sql\Sql;

class MostrarQtdeClientesHelper extends AbstractHelper {

    protected $dbAdapter;

    function __construct(\Zend\Db\Adapter\Adapter $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
    }

    public function __invoke($tpCliente) {
        return $this->mostrarQtdeClientes($tpCliente);
    }

    public function mostrarQtdeClientes($tpCliente) {
        try {
            $data = date('Y-m-d');
            $sql = new Sql($this->dbAdapter);
            $select = $sql->select();
            $select->from(array('a' => 'tb_cliente'))
                    ->where(array('a.TP_CLIENTE' => (int) $tpCliente))
                    ->where(new \Zend\Db\Sql\Predicate\Expression('DATE(a.DT_VENCIMENTO) >= ?', $data))
                    ->order('a.ID_CLIENTE ASC');
            $statement = $sql->prepareStatementForSqlObject($select);
            $stmt = $statement->execute();
            $qtdeRegistros = count($stmt);
            return $qtdeRegistros;
        } catch (Exception $e) {
            return "0";
        }
    }

}
