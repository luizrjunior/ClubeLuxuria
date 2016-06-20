<?php

namespace Anunciante\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class DadosAnunciante extends AbstractPlugin {

    protected $_dbAdapter;
    protected $_serviceManager;

    function __construct($serviceManager) {
        $this->_dbAdapter = $serviceManager->get('Zend\Db\Adapter\Adapter');
        $this->_serviceManager = $serviceManager;
    }

    /**
     * traduz o id para o nome do ANS
     * @name traduzirIdParaANS
     * @access public
     * @param Int $idCliente id do cliente o qual se deseja o nome artistico
     * @return Array Anunciante
     * @author Luiz Roberto <luizrjunior@gmail.com>
     */
    public function carregarDadosAnunciante($idCliente) {
        $sql = new Sql($this->_dbAdapter);
        $select = $sql->select();
        $select->from(array('a' => 'tb_anunciante'))
                ->join(array('b' => 'tb_cliente'), 'a.ID_CLIENTE = b.ID_CLIENTE')
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

