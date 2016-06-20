<?php

namespace Cache\Form;

use Zend\Form\Form;
use Cache\Form\Filter\CacheCadFilter;

class CacheCadForm extends Form {

    public function __construct() {
        parent::__construct(NULL);

        $this->setAttribute('method', 'POST');
        $this->setAttribute('action', 'index/salvar');
        $this->setAttribute('class', 'sky-form boxed');
        $this->setAttribute('id', 'formCadCache');

        $this->setInputFilter(new CacheCadFilter());

        $this->add(
                array(
                    'name' => 'idCache',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'idCache'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'idClienteCache',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'idClienteCache'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'idClienteSelectCache',
                    'type' => 'select',
                    'attributes' => array(
                        'id' => 'idClienteSelectCache',
                        'class' => 'form-control'
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'noCache',
                    'attributes' => array(
                        'type' => 'text',
                        'placeholder' => 'Cachê (Ex.: Básico, Super, Hiper, Mega, Viagens)',
                        'id' => 'noCache',
                        'maxlength' => 10
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'dsCache',
                    'attributes' => array(
                        'type' => 'text',
                        'placeholder' => 'Informar a Descrição do Cachê',
                        'id' => 'dsCache',
                        'maxlength' => 25
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'dsValor',
                    'attributes' => array(
                        'type' => 'text',
                        'placeholder' => 'Valor do Cachê (à Combinar/R$ 999,99)',
                        'id' => 'dsValor',
                        'maxlength' => 12
                    )
                )
        );

        $this->add(array(
            'name' => 'btnNovoCadCache',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnNovoCadCache',
                'value' => 'Novo'
            ),
            'options' => array(
                'label' => 'Novo'
            )
        ));

        $this->add(array(
            'name' => 'btnGravarCache',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnGravarCache',
                'value' => 'Salvar'
            ),
            'options' => array(
                'label' => 'Salvar'
            )
        ));

        $this->add(array(
            'name' => 'btnVoltarCadCache',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnVoltarCadCache',
                'value' => 'Voltar'
            ),
            'options' => array(
                'label' => 'Voltar'
            )
        ));
    }

}