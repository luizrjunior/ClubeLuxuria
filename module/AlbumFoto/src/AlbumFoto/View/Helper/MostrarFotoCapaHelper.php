<?php

namespace AlbumFoto\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Db\Sql\Sql;

class MostrarFotoCapaHelper extends AbstractHelper {

    protected $dbAdapter;

    function __construct(\Zend\Db\Adapter\Adapter $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
    }

    public function __invoke($idCliente) {
        return $this->mostrarFotoCapa($idCliente);
    }

    public function mostrarFotoCapa($idCliente) {
        try {
            $sql = new Sql($this->dbAdapter);
            $select = $sql->select();
            $select->from(array('a' => 'tb_album'))
                    ->join(array('b' => 'tb_foto'), 'a.ID_ALBUM = b.ID_ALBUM')
                    ->where(array('a.TP_ALBUM' => (int) 1))
                    ->where(array('b.TP_FOTO' => (int) 2))
                    ->order('b.DS_LEGENDA ASC');
            $statement = $sql->prepareStatementForSqlObject($select);
            $stmt = $statement->execute();
            $dsArquivo = "../../epona/images/demo/people/9_full.jpg";
            foreach ($stmt as $fotoCapa) {
                if ((int)$fotoCapa['ID_CLIENTE'] === (int)$idCliente) {
                    $dsArquivo = "../../storage/fotos/" . $idCliente . "/" . $fotoCapa['ID_ALBUM'] . "/" . $fotoCapa['DS_ARQUIVO'];
                }
            }
            return $dsArquivo;
        } catch (Exception $e) {
            return "../../epona/images/demo/people/9_full.jpg";
        }
    }

}
