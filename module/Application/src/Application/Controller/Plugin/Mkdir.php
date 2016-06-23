<?php

namespace Application\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class Mkdir extends AbstractPlugin {
    
    public function verificarDiretorio($diretorio) {
        if (is_dir($diretorio)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function criarDiretorio($diretorio) {
        if (is_dir($diretorio)) {
            return true;
        } else {
            if (mkdir($diretorio, 0777)) {
                chmod($diretorio, 0777);
                return true;
            } else {
                mkdir($diretorio, 0777, true);
                chmod($diretorio, 0777);
                return true;
            }
        }
        
        return false;
    }
    
    public function removeArquivo($arquivo) {
        if (unlink($arquivo)) {
            return true;
        } else {
            return false;
        }
    }

    public function pegarDiretorioRoot($diretorioRoot) {
        $sistemaOperacional = strtoupper(PHP_OS);
        if ($sistemaOperacional == "LINUX") {
            $diretorioRoot .= "public/";
        }
        return $diretorioRoot;
    }

}
