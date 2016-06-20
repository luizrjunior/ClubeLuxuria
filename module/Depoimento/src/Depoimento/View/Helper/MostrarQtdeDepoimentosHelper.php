<?php

namespace Depoimento\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Db\Sql\Sql;

class MostrarQtdeDepoimentosHelper extends AbstractHelper {

    protected $dbAdapter;

    function __construct(\Zend\Db\Adapter\Adapter $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
    }

    public function __invoke($idCliente, $idUsuario = null) {
        return $this->mostrarQtdeDepoimentos($idCliente, $idUsuario);
    }

    public function mostrarQtdeDepoimentos($idCliente, $idUsuario = null) {
        try {
            $sql = new Sql($this->dbAdapter);
            $select = $sql->select();
            $select->from(array('a' => 'tb_depoimento'));
            if ($idCliente != "") {
                $select->where(array('a.ID_CLIENTE' => (int) $idCliente));
            }
            if ($idUsuario != null) {
                $select->where(array('a.ID_USUARIO' => (int) $idUsuario));
            }
            $select->order('a.ID_DEPOIMENTO ASC');
            $statement = $sql->prepareStatementForSqlObject($select);
            $stmt = $statement->execute();
            $qtdeRegistros = count($stmt);
            return $qtdeRegistros;
        } catch (Exception $e) {
            return "0";
        }
    }

}
