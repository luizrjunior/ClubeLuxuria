<?php

namespace Anunciante\Form;

use Zend\Form\Form;

class AnunciantePsqForm extends Form {
    
    protected $SgUf;
    protected $StAnunciante;
    protected $TpAnunciante;

    public function __construct($sgUfs = array(), $stAnunciantes = array(), $tpAnunciantes = array()) {
        parent::__construct(NULL);
        
        $this->SgUf = $sgUfs;
        $this->StAnunciante = $stAnunciantes;
        $this->TpAnunciante = $tpAnunciantes;

        $this->setAttribute('method', 'POST');
        $this->setAttribute('class', 'sky-form boxed');
        $this->setAttribute('id', 'formPsqAnunciante');

        $this->add(
            array(
                'name' => 'tpAnunciantePsq',
                'type' => 'select',
                'attributes' => array(
                    'id' => 'tpAnunciantePsq',
                    'class' => 'form-control'
                ),
                'options' => array(
                    'value_options' => $this->TpAnunciante,
                )
            )
        );

        $this->add(
            array(
                'name' => 'stAnunciantePsq',
                'type' => 'select',
                'attributes' => array(
                    'id' => 'stAnunciantePsq',
                    'class' => 'form-control'
                ),
                'options' => array(
                    'value_options' => $this->StAnunciante,
                )
            )
        );

        $this->add(
            array(
                'name' => 'noArtisticoPsq',
                'attributes' => array(
                    'class' => 'form-control',
                    'type' => 'text',
                    'placeholder' => 'Pesquisar pelo nome artístico da anunciante',
                    'id' => 'noArtisticoPsq'
                )
            )
        );

        $this->add(
            array(
                'name' => 'sgUfPsq',
                'type' => 'select',
                'attributes' => array(
                    'id' => 'sgUfPsq',
                    'class' => 'form-control'
                ),
                'options' => array(
                    'value_options' => $this->SgUf,
                )
            )
        );

        $this->add(array(
            'name' => 'dtVencimentoPsq',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'dtVencimentoPsq'
            )
        ));

        $this->add(array(
            'name' => 'btnPesquisarAnunciante',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnPesquisarAnunciante'
            ),
            'options' => array(
                'label' => 'Pesquisar'
            )
        ));

        $this->add(array(
            'name' => 'btnVoltarAnunciante',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnVoltarAnunciante'
            ),
            'options' => array(
                'label' => 'Voltar'
            )
        ));

    }

}
