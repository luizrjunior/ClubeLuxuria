<?php

namespace Caracteristicas\Form;

use Zend\Form\Form;

class CaracteristicaCadForm extends Form {

    protected $TpCaracteristica;
    
    public function __construct($tpCaracteristica = array()) {
        parent::__construct(NULL);

        $this->TpCaracteristica = $tpCaracteristica;
        
        $this->setAttribute('method', 'POST');
        $this->setAttribute('class', 'sky-form boxed');
        $this->setAttribute('id', 'formCadCaracteristica');

        $this->add(
            array(
                'name' => 'idCaracteristica',
                'type' => 'hidden',
                'attributes' => array(
                    'id' => 'idCaracteristica'
                ),
            )
        );

        $this->add(
                array(
                    'name' => 'noCaracteristica',
                    'attributes' => array(
                        'type' => 'text',
                        'placeholder' => 'Nome da Característica',
                        'id' => 'noCaracteristica',
                        'class' => 'form-control'
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'tpCaracteristica',
                    'type' => 'select',
                    'attributes' => array(
                        'id' => 'tpCaracteristica',
                        'class' => 'form-control'
                    ),
                    'options' => array(
                        'value_options' => $this->TpCaracteristica,
                    )
                )
        );

        $this->add(
            array(
                'name' => 'btnPesquisarCaracteristica',
                'attributes' => array(
                    'type' => 'button',
                    'class' => 'btn btn-primary',
                    'id' => 'btnPesquisarCaracteristica',
                    'value' => 'Pesquisar'
                ),
                'options' => array(
                    'label' => 'Pesquisar'
                )
            )
        );

        $this->add(
            array(
                'name' => 'btnNovoCaracteristica',
                'attributes' => array(
                    'type' => 'button',
                    'class' => 'btn btn-primary',
                    'id' => 'btnNovoCaracteristica',
                    'value' => 'Novo'
                ),
                'options' => array(
                    'label' => 'Novo'
                )
            )
        );

        $this->add(
            array(
                'name' => 'btnGravarCaracteristica',
                'attributes' => array(
                    'type' => 'button',
                    'class' => 'btn btn-primary',
                    'id' => 'btnGravarCaracteristica',
                    'value' => 'Salvar'
                ),
                'options' => array(
                    'label' => 'Salvar'
                )
            )
        );
        
        $this->add(
            array(
                'name' => 'btnVoltarCaracteristica',
                'attributes' => array(
                    'type' => 'button',
                    'class' => 'btn btn-primary',
                    'id' => 'btnVoltarCaracteristica',
                    'value' => 'Voltar'
                ),
                'options' => array(
                    'label' => 'Voltar'
                )
            )
        );
    }

}