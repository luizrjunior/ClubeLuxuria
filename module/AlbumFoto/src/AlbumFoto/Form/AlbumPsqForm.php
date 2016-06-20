<?php

namespace AlbumFoto\Form;

use Zend\Form\Form;

use AlbumFoto\Form\Filter\AlbumPsqFilter;

class AlbumPsqForm extends Form {
    
    protected $tpAlbumPsq;
    protected $stAlbumPsq;

    public function __construct($tpAlbums = array(), $stAlbums = array()) {
        parent::__construct(NULL);

        $this->tpAlbumPsq = $tpAlbums;
        $this->stAlbumPsq = $stAlbums;
        
        $this->setAttribute('method', 'POST');
        $this->setAttribute('class', 'sky-form boxed');
        $this->setAttribute('id', 'formPsqAlbum');

        $this->setInputFilter(new AlbumPsqFilter());

        $this->add(
                array(
                    'name' => 'idClientePsqAlbum',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'idClientePsqAlbum'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'idClienteSelectPsqAlbum',
                    'type' => 'select',
                    'attributes' => array(
                        'id' => 'idClienteSelectPsqAlbum',
                        'class' => 'form-control'
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'tpAlbumPsq',
                    'type' => 'select',
                    'attributes' => array(
                        'id' => 'tpAlbumPsq',
                        'class' => 'form-control'
                    ),
                    'options' => array(
                        'value_options' => $this->tpAlbumPsq,
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'stAlbumPsq',
                    'type' => 'select',
                    'attributes' => array(
                        'id' => 'stAlbumPsq',
                        'class' => 'form-control'
                    ),
                    'options' => array(
                        'value_options' => $this->stAlbumPsq,
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'noAlbumPsq',
                    'attributes' => array(
                        'type' => 'text',
                        'placeholder' => 'Informar Nome do Album para pesquisa',
                        'id' => 'noAlbumPsq',
                        'maxlength' => 45
                    )
                )
        );

        $this->add(array(
            'name' => 'btnPesquisarAlbum',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnPesquisarAlbum'
            ),
            'options' => array(
                'label' => 'Pesquisar'
            )
        ));

        $this->add(array(
            'name' => 'btnNovoAlbum',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnNovoAlbum'
            ),
            'options' => array(
                'label' => 'Adicionar'
            )
        ));

    }

}