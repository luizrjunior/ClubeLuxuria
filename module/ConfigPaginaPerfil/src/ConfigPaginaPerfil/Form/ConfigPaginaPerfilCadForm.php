<?php

namespace ConfigPaginaPerfil\Form;

use Zend\Form\Form;
use ConfigPaginaPerfil\Form\Filter\ConfigPaginaPerfilCadFilter;

class ConfigPaginaPerfilCadForm extends Form {

    public function __construct() {
        parent::__construct(NULL);

        $this->setAttribute('method', 'POST');
        $this->setAttribute('action', 'index/salvar');
        $this->setAttribute('class', 'sky-form boxed');
        $this->setAttribute('id', 'formCadConfigPaginaPerfil');

        $this->setInputFilter(new ConfigPaginaPerfilCadFilter());

        $this->add(
                array(
                    'name' => 'idConfigPaginaPerfil',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'idConfigPaginaPerfil'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'idUsuarioConfigPaginaPerfil',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'idUsuarioConfigPaginaPerfil'
                    ),
                )
        );

        $this->add(array(
            'name' => 'btnGravarConfigPaginaPerfil',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnGravarConfigPaginaPerfil',
                'value' => 'Salvar'
            ),
            'options' => array(
                'label' => 'Salvar'
            )
        ));

    }

}