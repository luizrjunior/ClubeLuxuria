<?php

namespace AlbumFoto\Form;

use Zend\Form\Form;
use AlbumFoto\Form\Filter\FotoCadFilter;

class FotoCadForm extends Form {

    public function __construct() {
        parent::__construct(NULL);
        
        $this->setAttribute('method', 'POST');
        $this->setAttribute('action', 'foto/salvar-foto');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', 'clearfix');
        $this->setAttribute('role', 'form');
        $this->setAttribute('id', 'formCadFoto');

        $this->setInputFilter(new FotoCadFilter());

        $this->add(
                array(
                    'name' => 'idFoto',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'idFoto'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'idAlbumFoto',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'idAlbumFoto'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'tpFoto',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'tpFoto'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'stFoto',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'stFoto'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'stComentarioFoto',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'stComentarioFoto'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'dsLegendaFoto',
                    'type' => 'hidden',
                    'attributes' => array(
                        'value' => '',
                        'id' => 'dsLegendaFoto'
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'dsArquivoFoto',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'dsArquivoFoto'
                    ),
                )
        );

    }

}