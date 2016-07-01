<?php

namespace Anunciante\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Db\Sql\Sql;

class DadosAnuncianteHelper extends AbstractHelper {

    protected $dbAdapter;

    function __construct(\Zend\Db\Adapter\Adapter $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
    }

    public function __invoke($idCliente) {
        return $this->mostrarDadosAnunciante($idCliente);
    }

    public function mostrarDadosAnunciante($idCliente) {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select();
        $select->from(array('a' => 'tb_anunciante'))
                ->join(array('c' => 'tb_cidade'), 'a.ID_CIDADE = c.ID_CIDADE')
                ->where(array(
                    'a.ID_CLIENTE' => (int) $idCliente
                ))->order('a.ID_ANUNCIANTE ASC');
        $statement = $sql->prepareStatementForSqlObject($select);
        $stmt = $statement->execute();
        $array = array();
        foreach ($stmt as $banner) {
            $array['idAnunciante'] = $banner['ID_ANUNCIANTE'];
            $array['stAnunciante'] = $banner['ST_ANUNCIANTE'];
            $array['noArtistico'] = $banner['NO_ARTISTICO'];
            $array['nuTelefone'] = $banner['NU_TELEFONE'];
            $array['sgUf'] = $banner['SG_UF'];
            $array['noCidade'] = $banner['NO_CIDADE'];
        }
        return $array;
    }

}