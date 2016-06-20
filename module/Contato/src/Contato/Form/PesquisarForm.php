<?php

namespace Contato\Form;

use Zend\Form\Form;
use Contato\Form\Filter\PesquisarFilter;

class PesquisarForm extends Form {

    public function __construct() {
        parent::__construct(NULL);

        $this->setAttribute('method', 'POST');
        $this->setAttribute('class', 'sky-form boxed');
        $this->setAttribute('id', 'formPsq');
        $this->setInputFilter(new PesquisarFilter());

        $this->add(
                array(
                    'name' => 'nomePsq',
                    'attributes' => array(
                        'type' => 'text',
                        'placeholder' => 'Nome',
                        'id' => 'nomePsq'
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'emailPsq',
                    'attributes' => array(
                        'type' => 'text',
                        'placeholder' => 'Email',
                        'id' => 'emailPsq'
                    )
                )
        );

        $this->add(array(
            'name' => 'btnPesquisar',
            'attributes' => array(
                'type' => 'submit',
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
                'data-toggle' => 'modal',
                'data-target' => '#myModal',
                'id' => 'btnNovo'
            ),
            'options' => array(
                'label' => 'Adicionar Novo'
            )
        ));

        $this->add(array(
            'name' => 'btnVoltar',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnVoltar',
                'value' => 'Voltar'
            ),
            'options' => array(
                'label' => 'Voltar'
            )
        ));
    }

}
