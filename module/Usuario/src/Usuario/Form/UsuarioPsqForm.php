<?php

namespace Usuario\Form;

use Zend\Form\Form;
use Usuario\Form\Filter\UsuarioPsqFilter;

class UsuarioPsqForm extends Form {

    protected $Situacao;
    protected $Tipo;

    public function __construct($situacoes = array(), $tipos = array()) {
        parent::__construct(NULL);

        $this->Situacao = $situacoes;
        $this->Tipo = $tipos;

        $this->setAttribute('method', 'POST');
        $this->setAttribute('class', 'sky-form boxed');
        $this->setAttribute('id', 'formPsq');
        $this->setInputFilter(new UsuarioPsqFilter());

        $this->add(
                array(
                    'name' => 'loginPsq',
                    'attributes' => array(
                        'type' => 'text',
                        'placeholder' => 'Nome de Usuário - Usuário',
                        'id' => 'loginPsq',
                        'class' => 'form-control'
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'emailPsq',
                    'attributes' => array(
                        'type' => 'text',
                        'placeholder' => 'Email do Usuário - Email',
                        'id' => 'emailPsq',
                        'class' => 'form-control'
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'tpUsuarioPsq',
                    'type' => 'select',
                    'attributes' => array(
                        'id' => 'tpUsuarioPsq',
                        'class' => 'form-control'
                    ),
                    'options' => array(
                        'value_options' => $this->Tipo,
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'stUsuarioPsq',
                    'type' => 'select',
                    'attributes' => array(
                        'id' => 'stUsuarioPsq',
                        'class' => 'form-control'
                    ),
                    'options' => array(
                        'value_options' => $this->Situacao,
                    )
                )
        );

        $this->add(array(
            'name' => 'btnPesquisar',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnPesquisar'
            ),
            'options' => array(
                'label' => 'Pesquisar'
            )
        ));

        $this->add(array(
            'name' => 'btnNovo',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnNovo'
            ),
            'options' => array(
                'label' => 'Adicionar'
            )
        ));

        $this->add(array(
            'name' => 'btnVoltar',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnVoltar'
            ),
            'options' => array(
                'label' => 'Voltar'
            )
        ));
    }

}
