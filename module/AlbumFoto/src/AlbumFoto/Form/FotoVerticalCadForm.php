<?php

namespace AlbumFoto\Form;

use Zend\Form\Form;
use AlbumFoto\Form\Filter\FotoVerticalCadFilter;

class FotoVerticalCadForm extends Form {

    public function __construct() {
        parent::__construct(NULL);
        
        $this->setAttribute('method', 'POST');
        $this->setAttribute('action', 'foto/salvar-foto-horizontal');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', 'clearfix');
        $this->setAttribute('role', 'form');
        $this->setAttribute('id', 'formCadFotoVertical');

        $this->setInputFilter(new FotoVerticalCadFilter());

        $this->add(
                array(
                    'name' => 'idFotoVertical',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'idFotoVertical'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'idAlbumFotoVertical',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'idAlbumFotoVertical'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'tpFotoVertical',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'tpFotoVertical'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'stFotoVertical',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'stFotoVertical'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'stComentarioFotoVertical',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'stComentarioFotoVertical'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'dsLegendaFotoVertical',
                    'type' => 'hidden',
                    'attributes' => array(
                        'value' => 'Foto da Vertical',
                        'id' => 'dsLegenda'
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'dsArquivoFotoVertical',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'dsArquivoFotoVertical'
                    ),
                )
        );

        $this->add(array(
            'name' => 'btnRemoverArquivoFotoVertical',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-danger btn-xs',
                'id' => 'btnRemoverArquivoFotoVertical',
                'value' => 'Remover'
            ),
            'options' => array(
                'label' => 'Remover'
            )
        ));

        $this->add(array(
            'name' => 'btnGravarFotoVertical',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnGravarFotoVertical',
                'value' => 'Salvar'
            ),
            'options' => array(
                'label' => 'Salvar'
            )
        ));

    }

}