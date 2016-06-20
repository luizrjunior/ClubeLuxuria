<?php

namespace Usuario\Form;

use Zend\Form\Form;
use Usuario\Form\Filter\UsuarioCadFilter;

class UsuarioCadForm extends Form {

    protected $SgUf;
    protected $StUsuario;
    protected $TpUsuario;

    public function __construct($ufs = array(), $stUsuario = array(), $tpUsuario = array()) {
        parent::__construct(NULL);

        $this->SgUf = $ufs;
        $this->StUsuario = $stUsuario;
        $this->TpUsuario = $tpUsuario;

        $this->setAttribute('method', 'POST');
        $this->setAttribute('action', 'usuario/salvar');
        $this->setAttribute('id', 'formCadUsuario');

        $this->setInputFilter(new UsuarioCadFilter());

        $this->add(
                array(
                    'name' => 'idUsuario',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'idUsuario'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'login',
                    'attributes' => array(
                        'type' => 'text',
                        'placeholder' => 'Login de Acesso',
                        'id' => 'login',
                        'class' => 'form-control'
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'noUsuario',
                    'attributes' => array(
                        'type' => 'text',
                        'placeholder' => 'Nome do Usuário',
                        'id' => 'noUsuario',
                        'class' => 'form-control'
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'email',
                    'attributes' => array(
                        'type' => 'text',
                        'placeholder' => 'Email',
                        'id' => 'email',
                        'class' => 'form-control'
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'sgUfUsuario',
                    'type' => 'select',
                    'attributes' => array(
                        'id' => 'sgUfUsuario',
                        'class' => 'form-control'
                    ),
                    'options' => array(
                        'value_options' => $this->SgUf,
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'tpUsuario',
                    'type' => 'select',
                    'attributes' => array(
                        'id' => 'tpUsuario',
                        'class' => 'form-control'
                    ),
                    'options' => array(
                        'value_options' => $this->TpUsuario,
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'stUsuario',
                    'type' => 'select',
                    'attributes' => array(
                        'id' => 'stUsuario',
                        'class' => 'form-control'
                    ),
                    'options' => array(
                        'value_options' => $this->StUsuario,
                    )
                )
        );

        $this->add(array(
            'name' => 'senha',
            'attributes' => array(
                'type' => 'password',
                'id' => 'senha',
                'placeholder' => 'Digitar Senha',
                'class' => 'form-control'
            ),
        ));

        $this->add(array(
            'name' => 'confirmarsenha',
            'attributes' => array(
                'type' => 'password',
                'id' => 'confirmarsenha',
                'placeholder' => 'Confirmar Senha',
                'class' => 'form-control'
            ),
        ));

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
            'name' => 'btnNovoCad',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnNovoCad',
                'value' => 'Novo'
            ),
            'options' => array(
                'label' => 'Novo'
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
