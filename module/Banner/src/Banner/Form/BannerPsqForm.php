<?php

namespace Banner\Form;

use Zend\Form\Form;

class BannerPsqForm extends Form {

    public function __construct($tpBanners = array()) {
        parent::__construct(NULL);

        $this->tpBanner = $tpBanners;

        $this->setAttribute('method', 'POST');
        $this->setAttribute('class', 'sky-form boxed');
        $this->setAttribute('id', 'formPsqBanner');

        $this->add(array(
            'name' => 'noClientePsq',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'text',
                'placeholder' => 'Pesquisar pelo nome do cliente',
                'id' => 'noClientePsq'
            )
        ));

        $this->add(array(
            'name' => 'tpBannerPsq',
            'type' => 'select',
            'attributes' => array(
                'id' => 'tpBannerPsq',
                'class' => 'form-control'
            ),
            'options' => array(
                'value_options' => $this->tpBanner,
            )
        ));

        $this->add(array(
            'name' => 'btnPesquisarBanner',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnPesquisarBanner'
            ),
            'options' => array(
                'label' => 'Pesquisar'
            )
        ));

        $this->add(array(
            'name' => 'btnNovoBanner',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnNovoBanner'
            ),
            'options' => array(
                'label' => 'Adicionar'
            )
        ));

        $this->add(array(
            'name' => 'btnVoltarBanner',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnVoltarBanner'
            ),
            'options' => array(
                'label' => 'Voltar'
            )
        ));
    }

}
