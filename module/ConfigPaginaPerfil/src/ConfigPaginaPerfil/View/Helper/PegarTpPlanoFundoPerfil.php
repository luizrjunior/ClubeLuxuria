<?php

namespace ConfigPaginaPerfil\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Db\Sql\Sql;

class PegarTpPlanoFundoPerfil extends AbstractHelper {

    protected $dbAdapter;

    function __construct(\Zend\Db\Adapter\Adapter $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
    }

    public function __invoke($idUsuario = null) {
        return $this->tpPlanoFundoPerfil($idUsuario);
    }

    public function tpPlanoFundoPerfil($idUsuario = null) {
        try {
            $sql = new Sql($this->dbAdapter);
            $select = $sql->select();
            $select->from(array('a' => 'tb_config_pagina_perfil'));
            $select->where(array('a.ID_USUARIO' => (int) $idUsuario));
            $select->order('a.ID_CONFIG_PAGINA_PERFIL ASC');
            $statement = $sql->prepareStatementForSqlObject($select);
            $stmt = $statement->execute();
            $tpPlanoFundo = "";
            foreach ($stmt as $configPaginaPerfil) {
                $tpPlanoFundo .= $configPaginaPerfil['TP_PLANO_FUNDO'];
            }
            return $tpPlanoFundo;
        } catch (Exception $e) {
            return "";
        }
    }

}
