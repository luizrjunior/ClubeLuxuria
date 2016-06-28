<?php

namespace Banner\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Db\Sql\Sql;
//SESSION
use Zend\Session\Container;

class BannerDestaquesHelper extends AbstractHelper {

    protected $dbAdapter;

    function __construct(\Zend\Db\Adapter\Adapter $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
    }

    public function __invoke() {
        return $this->mostrarBannerDestaques();
    }

    public function mostrarBannerDestaques() {
        $sessao = new Container();
        if (!$_POST['sgUfPsq']) {
            $_POST['sgUfPsq'] = $sessao->sgUfSessionPsq;
        }
        $data = date('Y-m-d');
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select();
        $select->from(array('a' => 'tb_banner'))
                ->join(array('b' => 'tb_cliente'), 'a.ID_CLIENTE = b.ID_CLIENTE')
                ->where(array(
                    "a.TP_BANNER" => (int) 2, 
                    "a.ST_BANNER" => (int) 1,
                    "a.DT_INICIO <= '$data'",
                    "a.DT_FIM >= '$data'",
                    "b.ST_CLIENTE" => (int) 1,
                    "b.SG_UF = '" . $_POST['sgUfPsq'] . "'",
                    "b.DT_VENCIMENTO >= '$data'",
                ))->order('a.ID_BANNER');
        $statement = $sql->prepareStatementForSqlObject($select);
        $stmt = $statement->execute();
        $array = array();
        foreach ($stmt as $banner) {
            $array[]['idCliente'] = $banner['ID_CLIENTE'];
        }
        return $array;
    }

}