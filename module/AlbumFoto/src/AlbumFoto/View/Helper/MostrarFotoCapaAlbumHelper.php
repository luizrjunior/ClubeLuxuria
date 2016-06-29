<?php

namespace AlbumFoto\View\Helper;

use Zend\View\Helper\AbstractHelper;

class MostrarFotoCapaAlbumHelper extends AbstractHelper {

    public function __invoke($idCliente, $idAlbum) {
        return $this->mostrarFotoCapaAlbum($idCliente, $idAlbum);
    }

    public function mostrarFotoCapaAlbum($idCliente, $idAlbum) {
        $path = $_SERVER['DOCUMENT_ROOT'] . "storage/fotos/" . $idCliente . "/" . $idAlbum . "/";
        $diretorio = dir($path);
        while($arquivo = $diretorio -> read()) {
            if ($arquivo != "." && $arquivo != "..") {
                $dsArquivo = $arquivo;
            }
        }
        $diretorio->close();
        
        return $dsArquivo;
    }

}