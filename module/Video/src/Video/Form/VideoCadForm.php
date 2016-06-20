<?php

namespace Video\Form;

use Zend\Form\Form;
use Video\Form\Filter\VideoCadFilter;

class VideoCadForm extends Form {

    protected $tpVideo;
    
    public function __construct($tpVideos = array()) {
        parent::__construct(NULL);
        
        $this->tpVideo = $tpVideos;

        $this->setAttribute('method', 'POST');
        $this->setAttribute('action', 'index/salvar');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', 'sky-form boxed');
        $this->setAttribute('id', 'formCadVideo');

        $this->setInputFilter(new VideoCadFilter());

        $this->add(
                array(
                    'name' => 'idVideo',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'idVideo'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'idClienteVideo',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'idClienteVideo'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'idClienteSelectVideo',
                    'type' => 'select',
                    'attributes' => array(
                        'id' => 'idClienteSelectVideo',
                        'class' => 'form-control'
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'tpVideo',
                    'type' => 'select',
                    'attributes' => array(
                        'id' => 'tpVideo',
                        'class' => 'form-control'
                    ),
                    'options' => array(
                        'value_options' => $this->tpVideo,
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'tiVideo',
                    'attributes' => array(
                        'type' => 'text',
                        'placeholder' => 'Informar Titulo do Video',
                        'id' => 'tiVideo',
                        'maxlength' => 45
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'dsVideo',
                    'attributes' => array(
                        'type' => 'text',
                        'id' => 'dsVideo',
                        'maxlength' => 255
                    )
                )
        );

        $this->add(array(
            'name' => 'btnNovoCadVideo',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnNovoCadVideo',
                'value' => 'Novo'
            ),
            'options' => array(
                'label' => 'Novo'
            )
        ));

        $this->add(array(
            'name' => 'btnGravarVideo',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnGravarVideo',
                'value' => 'Salvar'
            ),
            'options' => array(
                'label' => 'Salvar'
            )
        ));

        $this->add(array(
            'name' => 'btnVoltarCadVideo',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnVoltarCadVideo',
                'value' => 'Voltar'
            ),
            'options' => array(
                'label' => 'Voltar'
            )
        ));
    }

}