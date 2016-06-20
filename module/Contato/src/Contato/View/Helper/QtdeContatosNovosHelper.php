<?php

namespace Contato\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Db\Sql\Sql;

class QtdeContatosNovosHelper extends AbstractHelper {

    protected $dbAdapter;

    function __construct(\Zend\Db\Adapter\Adapter $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
    }

    public function __invoke() {
        return $this->mostrarQtdeContatosNovos();
    }

    public function mostrarQtdeContatosNovos() {
        try {
            $sql = new Sql($this->dbAdapter);
            $select = $sql->select();
            $select->from(array('a' => 'tb_contato'))
                    ->where(array('a.ST_CONTATO' => 1))
                    ->order('a.ID_CONTATO ASC');
            $statement = $sql->prepareStatementForSqlObject($select);
            $stmt = $statement->execute();
            $qtdeRegistros = count($stmt);
            return $qtdeRegistros;
        } catch (Exception $e) {
            return 0;
        }
    }

}
