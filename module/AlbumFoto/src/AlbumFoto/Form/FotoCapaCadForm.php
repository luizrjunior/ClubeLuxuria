<?php

namespace AlbumFoto\Form;

use Zend\Form\Form;
use AlbumFoto\Form\Filter\FotoCapaCadFilter;

class FotoCapaCadForm extends Form {

    public function __construct() {
        parent::__construct(NULL);
        
        $this->setAttribute('method', 'POST');
        $this->setAttribute('action', 'foto/salvar-foto-capa');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', 'clearfix');
        $this->setAttribute('role', 'form');
        $this->setAttribute('id', 'formCadFotoCapa');

        $this->setInputFilter(new FotoCapaCadFilter());

        $this->add(
                array(
                    'name' => 'idFotoCapa',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'idFotoCapa'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'idAlbumFotoCapa',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'idAlbumFotoCapa'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'tpFotoCapa',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'tpFotoCapa'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'stFotoCapa',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'stFotoCapa'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'stComentarioFotoCapa',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'stComentarioFotoCapa'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'dsLegendaFotoCapa',
                    'type' => 'hidden',
                    'attributes' => array(
                        'value' => 'Foto da Capa',
                        'id' => 'dsLegenda'
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'dsArquivoFotoCapa',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'dsArquivoFotoCapa'
                    ),
                )
        );

        $this->add(array(
            'name' => 'btnRemoverArquivoFotoCapa',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-danger btn-xs',
                'id' => 'btnRemoverArquivoFotoCapa',
                'value' => 'Remover'
            ),
            'options' => array(
                'label' => 'Remover'
            )
        ));

        $this->add(array(
            'name' => 'btnGravarFotoCapa',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnGravarFotoCapa',
                'value' => 'Salvar'
            ),
            'options' => array(
                'label' => 'Salvar'
            )
        ));

    }

}