<?php

namespace Curtidas\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Db\Sql\Sql;

class MostrarQtdeCurtidasHelper extends AbstractHelper {

    protected $dbAdapter;

    function __construct(\Zend\Db\Adapter\Adapter $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
    }

    public function __invoke($idCliente, $idUsuario = null) {
        return $this->mostrarQtdeCurtidas($idCliente, $idUsuario);
    }

    public function mostrarQtdeCurtidas($idCliente, $idUsuario = null) {
        try {
            $sql = new Sql($this->dbAdapter);
            $select = $sql->select();
            $select->from(array('a' => 'tb_curtidas'));
            if ($idCliente != "") {
                $select->where(array('a.ID_CLIENTE' => (int) $idCliente));
            }
            if ($idUsuario != null) {
                $select->where(array('a.ID_USUARIO' => (int) $idUsuario));
            }
            $select->order('a.ID_CURTIDAS ASC');
            $statement = $sql->prepareStatementForSqlObject($select);
            $stmt = $statement->execute();
            $qtdeRegistros = count($stmt);
            return $qtdeRegistros;
        } catch (Exception $e) {
            return "0";
        }
    }

}
