<?php

namespace Video\Form;

use Zend\Form\Form;

use Video\Form\Filter\VideoPsqFilter;

class VideoPsqForm extends Form {

    protected $tpVideoPsq;
    
    public function __construct($tpVideos = array()) {
        parent::__construct(NULL);

        $this->tpVideoPsq = $tpVideos;
        
        $this->setAttribute('method', 'POST');
        $this->setAttribute('class', 'sky-form boxed');
        $this->setAttribute('id', 'formPsqVideo');

        $this->setInputFilter(new VideoPsqFilter());

        $this->add(
                array(
                    'name' => 'idClientePsqVideo',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'idClientePsqVideo'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'idClienteSelectPsqVideo',
                    'type' => 'select',
                    'attributes' => array(
                        'id' => 'idClienteSelectPsqVideo',
                        'class' => 'form-control'
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'tpVideoPsq',
                    'type' => 'select',
                    'attributes' => array(
                        'id' => 'tpVideoPsq',
                        'class' => 'form-control'
                    ),
                    'options' => array(
                        'value_options' => $this->tpVideoPsq,
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'dsVideoPsq',
                    'attributes' => array(
                        'type' => 'text',
                        'placeholder' => 'Informar Descriçao do Video para pesquisa',
                        'id' => 'dsVideoPsq',
                        'maxlength' => 10
                    )
                )
        );

        $this->add(array(
            'name' => 'btnPesquisarVideo',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnPesquisarVideo'
            ),
            'options' => array(
                'label' => 'Pesquisar'
            )
        ));

        $this->add(array(
            'name' => 'btnNovoVideo',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnNovoVideo'
            ),
            'options' => array(
                'label' => 'Adicionar'
            )
        ));

    }

}