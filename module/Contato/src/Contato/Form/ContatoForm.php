<?php

namespace Contato\Form;

use Zend\Form\Form;
use Contato\Form\Filter\ContatoFilter;

class ContatoForm extends Form {

    public function __construct() {
        parent::__construct('contato');

        $this->setAttribute('method', 'POST');
        $this->setAttribute('action', 'salvar');
        $this->setAttribute('id', 'formCad');
        $this->setInputFilter(new ContatoFilter());

        $this->add(
                array(
                    'name' => 'idContato',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'idContato'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'nome',
                    'attributes' => array(
                        'type' => 'text',
                        'placeholder' => 'Nome',
                        'class' => 'form-control',
                        'id' => 'nome'
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'email',
                    'attributes' => array(
                        'type' => 'text',
                        'placeholder' => 'Email',
                        'class' => 'form-control',
                        'id' => 'email'
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'assunto',
                    'attributes' => array(
                        'type' => 'text',
                        'placeholder' => 'Assunto',
                        'class' => 'form-control',
                        'id' => 'assunto'
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'mensagem',
                    'attributes' => array(
                        'type' => 'textarea',
                        'maxlength' => '2000',
                        'rows' => '3',
                        'class' => 'form-control',
                        'placeholder' => 'Mensagem',
                        'id' => 'mensagem'
                    )
                )
        );

        $this->add(array(
            'name' => 'btnEnviarContato',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnEnviarContato',
                'value' => 'Enviar'
            ),
            'options' => array(
                'label' => 'Enviar:'
            )
        ));
    }

}
