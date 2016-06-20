<?php

namespace Depoimento\Form;

use Zend\Form\Form;
use Depoimento\Form\Filter\DepoimentoCadFilter;

class DepoimentoCadForm extends Form {

    public function __construct($situacoes = array()) {
        parent::__construct(NULL);

        $this->Situacao = $situacoes;
        
        $this->setAttribute('method', 'POST');
        $this->setAttribute('action', 'index/salvar');
        $this->setAttribute('class', 'sky-form boxed');
        $this->setAttribute('id', 'formCadDepoimento');

        $this->setInputFilter(new DepoimentoCadFilter());

        $this->add(
                array(
                    'name' => 'idDepoimento',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'idDepoimento'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'idClienteDepoimento',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'idClienteDepoimento'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'idClienteSelectDepoimento',
                    'type' => 'select',
                    'attributes' => array(
                        'id' => 'idClienteSelectDepoimento',
                        'class' => 'form-control'
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'idUsuarioDepoimento',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'idUsuarioDepoimento'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'idUsuarioSelectDepoimento',
                    'type' => 'select',
                    'attributes' => array(
                        'id' => 'idUsuarioSelectDepoimento',
                        'class' => 'form-control'
                    )
                )
        );

        $this->add(
            array(
                'name' => 'stDepoimento',
                'type' => 'select',
                'attributes' => array(
                    'id' => 'stDepoimento',
                    'class' => 'form-control'
                ),
                'options' => array(
                    'value_options' => $this->Situacao,
                )
            )
        );

        $this->add(
                array(
                    'name' => 'dtHrDepoimento',
                    'attributes' => array(
                        'type' => 'text',
                        'class' => 'data',
                        'id' => 'dtHrDepoimento'
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'dsDepoimento',
                    'type' => 'textarea',
                    'attributes' => array(
                        'class' => 'form-control input-sm',
                        'rows' => '3',
                        'placeholder' => 'Escreva aqui o seu Depoimento',
                        'id' => 'dsDepoimento'
                    ),
                )
        );

        $this->add(array(
            'name' => 'btnNovoCadDepoimento',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnNovoCadDepoimento',
                'value' => 'Novo'
            ),
            'options' => array(
                'label' => 'Novo'
            )
        ));

        $this->add(array(
            'name' => 'btnGravarDepoimento',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnGravarDepoimento',
                'value' => 'Salvar'
            ),
            'options' => array(
                'label' => 'Salvar'
            )
        ));

        $this->add(array(
            'name' => 'btnVoltarCadDepoimento',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnVoltarCadDepoimento',
                'value' => 'Voltar'
            ),
            'options' => array(
                'label' => 'Voltar'
            )
        ));
    }

}