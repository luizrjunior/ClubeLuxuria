<?php

namespace Favoritos\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Db\Sql\Sql;

class MostrarQtdeFavoritosHelper extends AbstractHelper {

    protected $dbAdapter;

    function __construct(\Zend\Db\Adapter\Adapter $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
    }

    public function __invoke($idAnunciante, $idUsuario = null) {
        return $this->mostrarQtdeFavoritos($idAnunciante, $idUsuario);
    }

    public function mostrarQtdeFavoritos($idAnunciante, $idUsuario = null) {
        try {
            $sql = new Sql($this->dbAdapter);
            $select = $sql->select();
            $select->from(array('a' => 'tb_favoritos'));
            if ($idAnunciante != "") {
                $select->where(array('a.ID_ANUNCIANTE' => (int) $idAnunciante));
            }
            if ($idUsuario != null) {
                $select->where(array('a.ID_USUARIO' => (int) $idUsuario));
            }
            $select->order('a.ID_FAVORITOS ASC');
            $statement = $sql->prepareStatementForSqlObject($select);
            $stmt = $statement->execute();
            $qtdeRegistros = count($stmt);
            return $qtdeRegistros;
        } catch (Exception $e) {
            return "0";
        }
    }

}
