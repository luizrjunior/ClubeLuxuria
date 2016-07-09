<?php

namespace Application\Form;

use Zend\Form\Form;

class AcessoHomeForm extends Form {
    
    protected $SgUf;
    
    public function __construct($ufs = array()) {
        parent::__construct('application');
        
        $this->SgUf = $ufs;
        
        $this->setAttribute('method', 'POST');
        $this->setAttribute('action', '/application/index');
        $this->setAttribute('id', 'formAcessoHome');
        
        $this->add(
                array(
                    'name' => 'sgUfSessionPsq',
                    'type' => 'select',
                    'attributes' => array(
                        'id' => 'sgUfSessionPsq',
                        'class' => 'form-control'
                    ),
                    'options' => array(
                        'value_options' => $this->SgUf,
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'stMaior18',
                    'type' => 'checkbox',
                    'options' => array(
                        'label' => 'Sou maior de 18 anos',
                        'allow_empty' => true,
                        'nullable' => true
                    ),
                    'attributes' => array(
                        'id' => 'stMaior18'
                    ),
                )
        );

        $this->add(array(
            'name' => 'btnEntrarAcessoHome',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnEntrarAcessoHome',
                'value' => 'ENTRAR (18+)',
            )           
        ));

        $this->add(array(
            'name' => 'btnSairAcessoHome',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnSairAcessoHome',
                'value' => 'SAIR',
            )           
        ));
    }
}