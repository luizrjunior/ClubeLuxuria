<?php

namespace Cache\Form;

use Zend\Form\Form;

use Cache\Form\Filter\CachePsqFilter;

class CachePsqForm extends Form {

    public function __construct() {
        parent::__construct(NULL);

        $this->setAttribute('method', 'POST');
        $this->setAttribute('class', 'sky-form boxed');
        $this->setAttribute('id', 'formPsqCache');

        $this->setInputFilter(new CachePsqFilter());

        $this->add(
                array(
                    'name' => 'idClientePsqCache',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'idClientePsqCache'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'idClienteSelectPsqCache',
                    'type' => 'select',
                    'attributes' => array(
                        'id' => 'idClienteSelectPsqCache',
                        'class' => 'form-control'
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'noCachePsq',
                    'attributes' => array(
                        'type' => 'text',
                        'placeholder' => 'Informar Cachê para pesquisa',
                        'id' => 'noCachePsq',
                        'maxlength' => 10
                    )
                )
        );

        $this->add(array(
            'name' => 'btnPesquisarCache',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnPesquisarCache'
            ),
            'options' => array(
                'label' => 'Pesquisar'
            )
        ));

        $this->add(array(
            'name' => 'btnNovoCache',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnNovoCache'
            ),
            'options' => array(
                'label' => 'Adicionar'
            )
        ));

    }

}