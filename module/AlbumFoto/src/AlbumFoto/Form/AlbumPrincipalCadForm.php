<?php

namespace AlbumFoto\Form;

use Zend\Form\Form;
use AlbumFoto\Form\Filter\AlbumPrincipalCadFilter;

class AlbumPrincipalCadForm extends Form {

    public function __construct() {
        parent::__construct(NULL);
        
        $this->setAttribute('method', 'POST');
        $this->setAttribute('action', 'album/salvar-album-principal');
        $this->setAttribute('id', 'formCadAlbumPrincipal');

        $this->setInputFilter(new AlbumPrincipalCadFilter());

        $this->add(
                array(
                    'name' => 'idAlbumPrincipal',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'idAlbumPrincipal'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'idClienteAlbumPrincipal',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'idClienteAlbumPrincipal'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'tpAlbumPrincipal',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'tpAlbumPrincipal'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'stAlbumPrincipal',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'stAlbumPrincipal'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'stComentarioAlbumPrincipal',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'stComentarioAlbumPrincipal'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'noAlbumPrincipal',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'noAlbumPrincipal'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'dsAlbumPrincipal',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'dsAlbumPrincipal'
                    ),
                )
        );

    }

}