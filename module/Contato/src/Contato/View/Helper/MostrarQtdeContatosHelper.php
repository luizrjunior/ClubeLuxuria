<?php

namespace Contato\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Db\Sql\Sql;

class MostrarQtdeContatosHelper extends AbstractHelper {

    protected $dbAdapter;

    function __construct(\Zend\Db\Adapter\Adapter $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
    }

    public function __invoke() {
        return $this->mostrarQtdeContatos();
    }

    public function mostrarQtdeContatos() {
        try {
            $sql = new Sql($this->dbAdapter);
            $select = $sql->select();
            $select->from(array('a' => 'tb_contato'))
                    ->order('a.ID_CONTATO ASC');
            $statement = $sql->prepareStatementForSqlObject($select);
            $stmt = $statement->execute();
            $qtdeRegistros = count($stmt);
            return $qtdeRegistros;
        } catch (Exception $e) {
            return "0";
        }
    }

}
