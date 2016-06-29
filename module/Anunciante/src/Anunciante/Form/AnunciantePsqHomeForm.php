<?php

namespace Anunciante\Form;

use Zend\Form\Form;

class AnunciantePsqHomeForm extends Form {
    
    protected $SgUf;
    protected $Cidade;

    public function __construct($ufs = array(), $cidades = array()) {
        parent::__construct(NULL);
        
        $this->SgUf = $ufs;
        $this->Cidade = $cidades;

        $this->setAttribute('method', 'POST');
        $this->setAttribute('class', 'sky-form boxed');
        $this->setAttribute('id', 'formPsqAnuncianteHome');

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

        $this->add(
            array(
                'name' => 'idCidadePsq',
                'type' => 'select',
                'attributes' => array(
                    'id' => 'idCidadePsq',
                    'class' => 'form-control'
                ),
                'options' => array(
                    'value_options' => $this->Cidade,
                )
            )
        );

        $this->add(array(
            'name' => 'btnPesquisarAnuncianteHome',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnPesquisarAnuncianteHome'
            ),
            'options' => array(
                'label' => 'Pesquisar'
            )
        ));

    }

}
