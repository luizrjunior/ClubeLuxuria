<?php

namespace Login\Form;

use Zend\Form\Form;

class LoginForm extends Form {
    
    public function __construct() {
        parent::__construct('login');
        
        $this->setAttribute('method', 'POST');
        $this->setAttribute('action', '/login/index');
        $this->setAttribute('id', 'formLogin');
        
        $this->add(array(
            'name' => 'login',           
            'attributes' => array(
                'type' => 'text',
                'id' => 'login',
                'placeholder'=> 'Usuário',
                'class' => 'form-control'
            ),
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min'      => 1,
                        'max'      => 100,
                    ),
                ),
            ),                
        ));
       
        $this->add(array(
            'name' => 'senha',           
            'attributes' => array(
                'type' => 'password',
                'id' => 'senha',
                'placeholder'=> 'Senha',
                'class' => 'form-control'
            ),                   
        ));
        
        $this->add(array(
            'name' => 'btnEntrar',
            'attributes' => array(
                'type' => 'submit',
                'class' => 'btn btn-primary',
                'id' => 'btnEntrar',
                'value' => 'Entrar',
            )           
        ));
    }
}