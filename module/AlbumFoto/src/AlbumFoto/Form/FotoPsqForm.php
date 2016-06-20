<?php

namespace Video\Form;

use Zend\Form\Form;

use Video\Form\Filter\VideoPsqFilter;

class VideoPsqForm extends Form {

    public function __construct() {
        parent::__construct(NULL);

        $this->setAttribute('method', 'POST');
        $this->setAttribute('class', 'sky-form boxed');
        $this->setAttribute('id', 'formPsqVideo');

        $this->setInputFilter(new VideoPsqFilter());

        $this->add(
                array(
                    'name' => 'idClientePsq',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'idClientePsq'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'idClienteSelectPsq',
                    'type' => 'select',
                    'attributes' => array(
                        'id' => 'idClienteSelectPsq',
                        'class' => 'form-control'
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
            'name' => 'btnPesquisar',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnPesquisar'
            ),
            'options' => array(
                'label' => 'Pesquisar'
            )
        ));

        $this->add(array(
            'name' => 'btnNovo',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnNovo'
            ),
            'options' => array(
                'label' => 'Adicionar'
            )
        ));

        $this->add(array(
            'name' => 'btnVoltar',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnVoltar'
            ),
            'options' => array(
                'label' => 'Voltar'
            )
        ));

    }

}