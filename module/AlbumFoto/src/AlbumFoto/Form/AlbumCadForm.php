<?php

namespace AlbumFoto\Form;

use Zend\Form\Form;
use AlbumFoto\Form\Filter\AlbumCadFilter;

class AlbumCadForm extends Form {

    public function __construct($tpAlbums = array(), $stAlbums = array()) {
        parent::__construct(NULL);
        
        $this->tpAlbum = $tpAlbums;
        $this->stAlbum = $stAlbums;

        $this->setAttribute('method', 'POST');
        $this->setAttribute('action', 'index/salvar');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', 'sky-form boxed');
        $this->setAttribute('id', 'formCadAlbum');

        $this->setInputFilter(new AlbumCadFilter());

        $this->add(
                array(
                    'name' => 'idAlbum',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'idAlbum'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'idClienteAlbum',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'idClienteAlbum'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'idClienteSelectAlbum',
                    'type' => 'select',
                    'attributes' => array(
                        'id' => 'idClienteSelectAlbum',
                        'class' => 'form-control'
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'tpAlbum',
                    'type' => 'select',
                    'attributes' => array(
                        'id' => 'tpAlbum',
                        'class' => 'form-control'
                    ),
                    'options' => array(
                        'value_options' => $this->tpAlbum,
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'stAlbum',
                    'type' => 'select',
                    'attributes' => array(
                        'id' => 'stAlbum',
                        'class' => 'form-control'
                    ),
                    'options' => array(
                        'value_options' => $this->stAlbum,
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'stComentarioAlbum',
                    'type' => 'checkbox',
                    'options' => array(
                        'label' => 'Permitir Comentários',
                        'allow_empty' => true,
                        'nullable' => true
                    ),
                    'attributes' => array(
                        'id' => 'stComentarioAlbum'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'noAlbum',
                    'attributes' => array(
                        'type' => 'text',
                        'placeholder' => 'Informar o nome do album',
                        'id' => 'noAlbum'
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'dsAlbum',
                    'type' => 'textarea',
                    'attributes' => array(
                        'class' => 'form-control input-sm',
                        'rows' => '5',
                        'placeholder' => 'Informar a descriçao do album',
                        'id' => 'dsAlbum'
                    ),
                )
        );

        $this->add(array(
            'name' => 'btnNovoCadAlbum',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnNovoCadAlbum',
                'value' => 'Novo'
            ),
            'options' => array(
                'label' => 'Novo'
            )
        ));

        $this->add(array(
            'name' => 'btnGravarAlbum',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnGravarAlbum',
                'value' => 'Salvar'
            ),
            'options' => array(
                'label' => 'Salvar'
            )
        ));

        $this->add(array(
            'name' => 'btnVoltarCadAlbum',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnVoltarCadAlbum',
                'value' => 'Voltar'
            ),
            'options' => array(
                'label' => 'Voltar'
            )
        ));
    }

}