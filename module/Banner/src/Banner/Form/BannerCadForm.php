<?php

namespace Banner\Form;

use Zend\Form\Form;

class BannerCadForm extends Form {

    public function __construct($tpBanners = array()) {
        parent::__construct(NULL);

        $this->tpBanner = $tpBanners;

        $this->setAttribute('method', 'POST');
        $this->setAttribute('action', 'index/salvar');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', 'sky-form boxed');
        $this->setAttribute('id', 'formCadBanner');

        $this->add(array(
            'name' => 'idBanner',
            'type' => 'hidden',
            'attributes' => array(
                'id' => 'idBanner'
            ),
        ));

        $this->add(array(
            'name' => 'idCliente',
            'type' => 'select',
            'attributes' => array(
                'id' => 'idCliente',
                'class' => 'form-control'
            )
        ));

        $this->add(array(
            'name' => 'tpBanner',
            'type' => 'select',
            'attributes' => array(
                'id' => 'tpBanner',
                'class' => 'form-control'
            ),
            'options' => array(
                'value_options' => $this->tpBanner,
            )
        ));

        $this->add(array(
            'name' => 'dsBanner',
            'type' => 'textarea',
            'attributes' => array(
                'class' => 'form-control input-sm',
                'rows' => '9',
                'placeholder' => 'Informar o HTML do Banner',
                'id' => 'dsBanner'
            ),
        ));

        $this->add(array(
            'name' => 'dtInicio',
            'attributes' => array(
                'type' => 'text',
                'class' => 'data',
                'id' => 'dtInicio'
            )
        ));

        $this->add(array(
            'name' => 'dtFim',
            'attributes' => array(
                'type' => 'text',
                'class' => 'data',
                'id' => 'dtFim'
            )
        ));

        $this->add(array(
            'name' => 'btnNovoCadBanner',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnNovoCadBanner',
                'value' => 'Novo'
            ),
            'options' => array(
                'label' => 'Novo'
            )
        ));

        $this->add(array(
            'name' => 'btnGravarBanner',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnGravarBanner',
                'value' => 'Salvar'
            ),
            'options' => array(
                'label' => 'Salvar'
            )
        ));

        $this->add(array(
            'name' => 'btnVoltarCadBanner',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnVoltarCadBanner',
                'value' => 'Voltar'
            ),
            'options' => array(
                'label' => 'Voltar'
            )
        ));
    }

}