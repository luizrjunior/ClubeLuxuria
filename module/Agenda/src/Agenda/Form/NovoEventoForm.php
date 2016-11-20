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
        
       //Título do Evento
       $this->add(
            array(
                'name' => 'titulo',
                'attributes' => array(
                    'id' => 'titulo',
                    'type' => 'text',
                    'placeholder' => 'Nome do seu Evento (Resumidamente)',
                    'class'=> 'col-sm-12 col-md-12',
                    'maxlength' => '128'
                )
            )
        );
        
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
        
        //Descrição do evento
        
        //Data Inicial do Evento
         $this->add(array(
            'name' => 'dtInicial',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'dtInicial'
            )
        ));
         
        //Data Final do Evento
         $this->add(array(
            'name' => 'dtFinal',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'dtFinal'
            )
        ));        

        $this->add(array(
            'name' => 'btnVerifHorario',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary col-sm-12 col-md-8',
                'id' => 'btnVerifHorario',
                'value' => 'Verificar Datas e Horários',
                'style' => 'margin:0px auto;'
            )           
        ));
    }
}