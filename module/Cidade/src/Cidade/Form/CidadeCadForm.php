<?php

namespace Cidade\Form;

use Zend\Form\Form;

class CidadeCadForm extends Form {

    protected $SgUf;
    
    public function __construct($sgUf = array()) {
        parent::__construct(NULL);

        $this->SgUf = $sgUf;
        
        $this->setAttribute('method', 'POST');
        $this->setAttribute('class', 'sky-form boxed');
        $this->setAttribute('id', 'formCadCidade');

        $this->add(
            array(
                'name' => 'idCidade',
                'type' => 'hidden',
                'attributes' => array(
                    'id' => 'idCidade'
                ),
            )
        );

        $this->add(
                array(
                    'name' => 'noCidade',
                    'attributes' => array(
                        'type' => 'text',
                        'placeholder' => 'Nome da Cidade',
                        'id' => 'noCidade',
                        'class' => 'form-control'
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'sgUf',
                    'type' => 'select',
                    'attributes' => array(
                        'id' => 'sgUf',
                        'class' => 'form-control'
                    ),
                    'options' => array(
                        'value_options' => $this->SgUf,
                    )
                )
        );

        $this->add(
            array(
                'name' => 'btnPesquisarCidade',
                'attributes' => array(
                    'type' => 'button',
                    'class' => 'btn btn-primary',
                    'id' => 'btnPesquisarCidade',
                    'value' => 'Pesquisar'
                ),
                'options' => array(
                    'label' => 'Pesquisar'
                )
            )
        );

        $this->add(
            array(
                'name' => 'btnNovoCidade',
                'attributes' => array(
                    'type' => 'button',
                    'class' => 'btn btn-primary',
                    'id' => 'btnNovoCidade',
                    'value' => 'Novo'
                ),
                'options' => array(
                    'label' => 'Novo'
                )
            )
        );

        $this->add(
            array(
                'name' => 'btnGravarCidade',
                'attributes' => array(
                    'type' => 'button',
                    'class' => 'btn btn-primary',
                    'id' => 'btnGravarCidade',
                    'value' => 'Salvar'
                ),
                'options' => array(
                    'label' => 'Salvar'
                )
            )
        );
        
        $this->add(
            array(
                'name' => 'btnVoltarCidade',
                'attributes' => array(
                    'type' => 'button',
                    'class' => 'btn btn-primary',
                    'id' => 'btnVoltarCidade',
                    'value' => 'Voltar'
                ),
                'options' => array(
                    'label' => 'Voltar'
                )
            )
        );
    }

}