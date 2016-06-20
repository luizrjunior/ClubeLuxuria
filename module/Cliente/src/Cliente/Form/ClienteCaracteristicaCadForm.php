<?php

namespace Cliente\Form;

use Zend\Form\Form;
use Cliente\Form\Filter\ClienteCaracteristicaCadFilter;

class ClienteCaracteristicaCadForm extends Form {

    public function __construct() {
        parent::__construct(NULL);

        $this->setAttribute('method', 'POST');
        $this->setAttribute('class', 'sky-form boxed');
        $this->setAttribute('id', 'formCadClienteCaracteristica');

        $this->setInputFilter(new ClienteCaracteristicaCadFilter());

        $this->add(
            array(
                'name' => 'idClienteCaracteristica',
                'type' => 'hidden',
                'attributes' => array(
                    'id' => 'idClienteCaracteristica'
                ),
            )
        );

        $this->add(
            array(
                'name' => 'btnGravarClienteCaracteristica',
                'attributes' => array(
                    'type' => 'button',
                    'class' => 'btn btn-primary',
                    'id' => 'btnGravarClienteCaracteristica',
                    'value' => 'Salvar'
                ),
                'options' => array(
                    'label' => 'Salvar'
                )
            )
        );
    }

}