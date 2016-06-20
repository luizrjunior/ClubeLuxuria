<?php

namespace AlbumFoto\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Db\Sql\Sql;

class PegarQtdeFotoSensuallHelper extends AbstractHelper {

    protected $dbAdapter;

    function __construct(\Zend\Db\Adapter\Adapter $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
    }

    public function __invoke($idCliente) {
        return $this->mostrarQtdeFotoSensual($idCliente);
    }

    public function mostrarQtdeFotoSensual($idCliente) {
        try {
            $sql = new Sql($this->dbAdapter);
            $select = $sql->select();
            $select->from(array('a' => 'tb_album'))
                    ->join(array('b' => 'tb_foto'), 'a.ID_ALBUM = b.ID_ALBUM')
                    ->join(array('c' => 'tb_cliente'), 'a.ID_CLIENTE = c.ID_CLIENTE')
                    ->where(array('a.ID_CLIENTE' => $idCliente))
                    ->where(array('a.TP_ALBUM' => (int) 1))
                    ->where(array('b.TP_FOTO' => array((int) 3,(int) 4)))
                    ->order('b.ID_FOTO ASC');
            $statement = $sql->prepareStatementForSqlObject($select);
            $stmt = $statement->execute();
            return count($stmt);
        } catch (Exception $e) {
            return 0;
        }
    }

}
