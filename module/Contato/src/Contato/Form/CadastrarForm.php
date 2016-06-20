<?php

namespace Contato\Form;

use Zend\Form\Form;
use Contato\Form\Filter\CadastrarFilter;

class CadastrarForm extends Form {

    protected $Assunto;

    public function __construct($Assunto = array()) {
        parent::__construct('contato');

        $this->Assunto = $Assunto;

        $this->setAttribute('method', 'POST');
        $this->setAttribute('action', 'contato/salvar');
        $this->setAttribute('class', 'sky-form boxed');
        $this->setAttribute('id', 'formCad');

        $this->setInputFilter(new CadastrarFilter());

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
                        'id' => 'assunto'
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'mensagem',
                    'attributes' => array(
                        'type' => 'text',
                        'placeholder' => 'Mensagem',
                        'id' => 'mensagem'
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'status',
                    'type' => 'select',
                    'attributes' => array(
                        'id' => 'status',
                        'class' => 'form-control'
                    ),
                    'options' => array(
                        'value_options' => array(
                            'T' => '- - Selecione o Status - -',
                            '1' => 'Ativado',
                            '0' => 'Desativado'
                        ),
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'idAssunto',
                    'type' => 'select',
                    'attributes' => array(
                        'id' => 'idAssunto',
                        'class' => 'form-control'
                    ),
                    'options' => array(
                        'label' => 'Assunto:',
                        'label_attributes' => array(
                            'for' => 'idAssunto'
                        ),
                        'value_options' => $this->Assunto,
                    )
                )
        );

        $this->add(array(
            'name' => 'btnGravar',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnGravar',
                'value' => 'Salvar'
            ),
            'options' => array(
                'label' => 'Salvar'
            )
        ));

        $this->add(array(
            'name' => 'btnVoltarCad',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnVoltarCad',
                'value' => 'Voltar'
            ),
            'options' => array(
                'label' => 'Voltar'
            )
        ));
    }

}
