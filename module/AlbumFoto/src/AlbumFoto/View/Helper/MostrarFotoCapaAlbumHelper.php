<?php

namespace AlbumFoto\View\Helper;

use Zend\View\Helper\AbstractHelper;

class MostrarFotoCapaAlbumHelper extends AbstractHelper {

    public function __invoke($idCliente, $idAlbum) {
        return $this->mostrarFotoCapaAlbum($idCliente, $idAlbum);
    }

    public function mostrarFotoCapaAlbum($idCliente, $idAlbum) {        $sistemaOperacional = strtoupper(PHP_OS);
        $path = $_SERVER['DOCUMENT_ROOT'] . "storage/fotos/" . $idCliente . "/" . $idAlbum . "/";
        if ($sistemaOperacional == "LINUX") {
            $path = $_SERVER['DOCUMENT_ROOT'] . "public/storage/fotos/" . $idCliente . "/" . $idAlbum . "/";
        }
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