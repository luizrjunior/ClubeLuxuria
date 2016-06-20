<?php

namespace Anunciante\Form;

use Zend\Form\Form;

class AnunciantePsqHomeForm extends Form {
    
    protected $SgUf;
    protected $Cidade;
    protected $CabeloCor;
    protected $StAnunciante;

    public function __construct($ufs = array(), $cidades = array(), $cabelos = array(), $situacoes = array()) {
        parent::__construct(NULL);
        
        $this->SgUf = $ufs;
        $this->Cidade = $cidades;
        $this->CabeloCor = $cabelos;
        $this->StAnunciante = $situacoes;

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

    }

}
