<?php

namespace AlbumFoto\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Db\Sql\Sql;

class MostrarFotoPerfilHelper extends AbstractHelper {

    protected $dbAdapter;

    function __construct(\Zend\Db\Adapter\Adapter $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
    }

    public function __invoke($idCliente) {
        return $this->mostrarFotoPerfil($idCliente);
    }

    public function mostrarFotoPerfil($idCliente) {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select();
        $select->from(array('a' => 'tb_album'))
                ->join(array('b' => 'tb_foto'), 'a.ID_ALBUM = b.ID_ALBUM')
                ->join(array('c' => 'tb_cliente'), 'a.ID_CLIENTE = c.ID_CLIENTE')
                ->where(array('a.TP_ALBUM' => (int) 1))
                ->where(array('b.TP_FOTO' => (int) 1))
                ->where(array('c.ID_CLIENTE' => (int) $idCliente))
                ->order('b.DS_LEGENDA ASC');
        $statement = $sql->prepareStatementForSqlObject($select);
        $stmt = $statement->execute();
        $dsArquivo = "/epona/images/demo/people/9.jpg";
        foreach ($stmt as $fotoPerfil) {
            $dsArquivo = "/storage/fotos/" . $idCliente . "/" . $fotoPerfil['ID_ALBUM'] . "/" . $fotoPerfil['DS_ARQUIVO'];
        }
        return $dsArquivo;
    }

}
