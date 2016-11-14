<?php

namespace Agenda\Form;

use Zend\Form\Form;

class NovoEventoForm extends Form {
    
    protected $SgUf;
    
    public function __construct($ufs = array()) {
        parent::__construct('agenda');
        
        $this->SgUf = $ufs;
        
        $this->setAttribute('method', 'POST');
        $this->setAttribute('action', '/agenda/inicio/novo-evento');
        $this->setAttribute('id', 'formAgendaNovo');
        
        //Estado de onde o evento acontecerá
        $this->add(
                array(
                    'name' => 'sgUfCad',
                    'type' => 'select',
                    'attributes' => array(
                        'id' => 'sgUfCad',
                        'class' => 'form-control'
                    ),
                    'options' => array(
                        'value_options' => $this->SgUf,
                    )
                )
        );//Estado 

        //Endereço de onde o evento acontecerá
        $this->add(
            array(
                'name' => 'endereco',
                'attributes' => array(
                    'id' => 'endereco',
                    'type' => 'text',
                    'placeholder' => 'Ex.: SBS Qd. 1 - Teatro dos Bancários - Asa Sul - Brasília',
                    'class'=> 'col-sm-12 col-md-12',
                    'maxlength' => '240'
                )
            )
        );
        
        

        $this->add(array(
            'name' => 'btnSairAcessoHome',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary col-sm-12 col-md-4 col-md-offset-3',
                'id' => 'btnSairAcessoHome',
                'value' => 'SAIR',
                'style' => 'height:50px;'
            )           
        ));
    }
}