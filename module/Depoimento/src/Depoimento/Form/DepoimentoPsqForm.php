<?php

namespace Depoimento\Form;

use Zend\Form\Form;

use Depoimento\Form\Filter\DepoimentoPsqFilter;

class DepoimentoPsqForm extends Form {

    public function __construct($situacoes = array()) {
        parent::__construct(NULL);

        $this->Situacao = $situacoes;
        
        $this->setAttribute('method', 'POST');
        $this->setAttribute('class', 'sky-form boxed');
        $this->setAttribute('id', 'formPsqDepoimento');

        $this->setInputFilter(new DepoimentoPsqFilter());

        $this->add(
                array(
                    'name' => 'idClientePsqDepoimento',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'idClientePsqDepoimento'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'idClienteSelectPsqDepoimento',
                    'type' => 'select',
                    'attributes' => array(
                        'id' => 'idClienteSelectPsqDepoimento',
                        'class' => 'form-control'
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'idUsuarioSelectPsqDepoimento',
                    'type' => 'select',
                    'attributes' => array(
                        'id' => 'idUsuarioSelectPsqDepoimento',
                        'class' => 'form-control'
                    )
                )
        );

        $this->add(
            array(
                'name' => 'stDepoimentoPsq',
                'type' => 'select',
                'attributes' => array(
                    'id' => 'stDepoimentoPsq',
                    'class' => 'form-control'
                ),
                'options' => array(
                    'value_options' => $this->Situacao,
                )
            )
        );

        $this->add(
                array(
                    'name' => 'dtInicioPsq',
                    'attributes' => array(
                        'type' => 'text',
                        'class' => 'data',
                        'id' => 'dtInicioPsq'
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'dtFimPsq',
                    'attributes' => array(
                        'type' => 'text',
                        'class' => 'data',
                        'id' => 'dtFimPsq'
                    )
                )
        );

        $this->add(array(
            'name' => 'btnPesquisarDepoimento',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnPesquisarDepoimento'
            ),
            'options' => array(
                'label' => 'Pesquisar'
            )
        ));

        $this->add(array(
            'name' => 'btnNovoDepoimento',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnNovoDepoimento'
            ),
            'options' => array(
                'label' => 'Adicionar'
            )
        ));

    }

}