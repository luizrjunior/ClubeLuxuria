<?php

namespace Conseguro\Mvc\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class Valor extends AbstractPlugin {

    public function trocarPontos($valor) {
        
        $valor = str_replace(',', '', $valor);
        $valor = str_replace('.', ',', $valor);
        
        return $valor;
    }
    
    public function valorToDb($valor){
        $valor = str_replace('.', '', $valor);
        $valor = str_replace(',', '.', $valor);
        
        return $valor;
    }

}
