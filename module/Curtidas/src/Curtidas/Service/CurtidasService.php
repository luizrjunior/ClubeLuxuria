<?php

namespace Curtidas\Service;

use Application\Service\AbstractService;
use Doctrine\ORM\EntityManager;

class CurtidasService extends AbstractService {

    protected $_repository;

    public function __construct(EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'Curtidas\Entity\CurtidasEntity';
        $this->_repository = $this->em->getRepository($this->entity);
    }

    public function selecionarCurtidas($id) {
        $repository = $this->_repository->selecionarCurtidas($id);
        return $repository;
    }

    public function selecionarCurtidasBy($param) {
        $repository = $this->_repository->selecionarCurtidasBy($param);
        return $repository;
    }

    public function salvarCurtidas($data) {
        if (isset($data['idCliente'])) {
            $data['idCliente'] = $this->em->getRepository('Cliente\Entity\ClienteEntity')
                ->find($data['idCliente']);
        } else {
            unset($data['idCliente']);
        }
        if (isset($data['idAlbum'])) {
            $data['idAlbum'] = $this->em->getRepository('AlbumFoto\Entity\AlbumEntity')
                ->find($data['idAlbum']);
        } else {
            unset($data['idAlbum']);
        }
        if (isset($data['idFoto'])) {
            $data['idFoto'] = $this->em->getRepository('AlbumFoto\Entity\FotoEntity')
                ->find($data['idFoto']);
        } else {
            unset($data['idFoto']);
        }
        if (isset($data['idUsuario'])) {
            $data['idUsuario'] = $this->em->getRepository('Usuario\Entity\UsuarioEntity')
                ->find($data['idUsuario']);
        } else {
            unset($data['idUsuario']);
        }
//        if (isset($data['idComentario'])) {
//            $data['idComentario'] = $this->em->getRepository('Comentarios\Entity\ComentarioEntity')
//                ->find($data['idComentario']);
//        } else {
//            unset($data['idComentario']);
//        }
        if (isset($data['idCurtidas'])) {
            $repository = $this->_repository->editarCurtidas($data);
        } else {
            $repository = $this->_repository->inserirCurtidas($data);
        }
        return $repository;
    }

    public function removerCurtidas($repository) {
        $entity = $this->_repository->excluirCurtidas($repository);
        return $entity;
    }
}
