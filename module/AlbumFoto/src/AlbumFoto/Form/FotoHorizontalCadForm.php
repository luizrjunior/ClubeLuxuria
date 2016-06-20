<?php

namespace AlbumFoto\Form;

use Zend\Form\Form;
use AlbumFoto\Form\Filter\FotoHorizontalCadFilter;

class FotoHorizontalCadForm extends Form {

    public function __construct() {
        parent::__construct(NULL);
        
        $this->setAttribute('method', 'POST');
        $this->setAttribute('action', 'foto/salvar-foto-horizontal');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', 'clearfix');
        $this->setAttribute('role', 'form');
        $this->setAttribute('id', 'formCadFotoHorizontal');

        $this->setInputFilter(new FotoHorizontalCadFilter());

        $this->add(
                array(
                    'name' => 'idFotoHorizontal',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'idFotoHorizontal'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'idAlbumFotoHorizontal',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'idAlbumFotoHorizontal'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'tpFotoHorizontal',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'tpFotoHorizontal'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'stFotoHorizontal',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'stFotoHorizontal'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'stComentarioFotoHorizontal',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'stComentarioFotoHorizontal'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'dsLegendaFotoHorizontal',
                    'type' => 'hidden',
                    'attributes' => array(
                        'value' => 'Foto da Horizontal',
                        'id' => 'dsLegenda'
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'dsArquivoFotoHorizontal',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'dsArquivoFotoHorizontal'
                    ),
                )
        );

        $this->add(array(
            'name' => 'btnRemoverArquivoFotoHorizontal',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-danger btn-xs',
                'id' => 'btnRemoverArquivoFotoHorizontal',
                'value' => 'Remover'
            ),
            'options' => array(
                'label' => 'Remover'
            )
        ));

        $this->add(array(
            'name' => 'btnGravarFotoHorizontal',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnGravarFotoHorizontal',
                'value' => 'Salvar'
            ),
            'options' => array(
                'label' => 'Salvar'
            )
        ));
        
    }

}