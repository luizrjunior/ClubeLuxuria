<?php

namespace ConfigPaginaCliente\Form;

use Zend\Form\Form;
use ConfigPaginaCliente\Form\Filter\ConfigPaginaClienteCadFilter;

class ConfigPaginaClienteCadForm extends Form {

    public function __construct() {
        parent::__construct(NULL);

        $this->setAttribute('method', 'POST');
        $this->setAttribute('action', 'index/salvar');
        $this->setAttribute('class', 'sky-form boxed');
        $this->setAttribute('id', 'formCadConfigPaginaCliente');

        $this->setInputFilter(new ConfigPaginaClienteCadFilter());

        $this->add(
                array(
                    'name' => 'idConfigPaginaCliente',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'idConfigPaginaCliente'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'idClienteConfigPaginaCliente',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'idClienteConfigPaginaCliente'
                    ),
                )
        );

        $this->add(array(
            'name' => 'btnGravarConfigPaginaCliente',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnGravarConfigPaginaCliente',
                'value' => 'Salvar'
            ),
            'options' => array(
                'label' => 'Salvar'
            )
        ));

    }

}