<?php

namespace Pagamento\Form;

use Zend\Form\Form;

class PagamentoPsqForm extends Form {

    public function __construct($stPagamentos = array(), $tpPagamentos = array(), $tpPlanos = array()) {
        parent::__construct(NULL);

        $this->stPagamento = $stPagamentos;
        $this->tpPagamento = $tpPagamentos;
        $this->tpPlano = $tpPlanos;

        $this->setAttribute('method', 'POST');
        $this->setAttribute('class', 'sky-form boxed');
        $this->setAttribute('id', 'formPsqPagamento');

        $this->add(array(
            'name' => 'noClientePsq',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'text',
                'placeholder' => 'Pesquisar pelo nome do cliente',
                'id' => 'noClientePsq'
            )
        ));

        $this->add(array(
            'name' => 'idClientePsqPagamento',
            'attributes' => array(
                'type' => 'hidden',
                'id' => 'idClientePsqPagamento'
            )
        ));

        $this->add(array(
            'name' => 'tpPagamentoPsq',
            'type' => 'select',
            'attributes' => array(
                'id' => 'tpPagamentoPsq',
                'class' => 'form-control'
            ),
            'options' => array(
                'value_options' => $this->tpPagamento,
            )
        ));

        $this->add(array(
            'name' => 'stPagamentoPsq',
            'type' => 'select',
            'attributes' => array(
                'id' => 'stPagamentoPsq',
                'class' => 'form-control'
            ),
            'options' => array(
                'value_options' => $this->stPagamento,
            )
        ));

        $this->add(array(
            'name' => 'tpPlanoPsq',
            'type' => 'select',
            'attributes' => array(
                'id' => 'tpPlanoPsq',
                'class' => 'form-control'
            ),
            'options' => array(
                'value_options' => $this->tpPlano,
            )
        ));

        $this->add(array(
            'name' => 'dtInicioPsq',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'dtInicioPsq'
            )
        ));

        $this->add(array(
            'name' => 'dtFimPsq',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'dtFimPsq'
            )
        ));

        $this->add(array(
            'name' => 'btnPesquisarPagamento',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnPesquisarPagamento'
            ),
            'options' => array(
                'label' => 'Pesquisar'
            )
        ));

        $this->add(array(
            'name' => 'btnNovoPagamento',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnNovoPagamento'
            ),
            'options' => array(
                'label' => 'Adicionar'
            )
        ));

        $this->add(array(
            'name' => 'btnVoltarPagamento',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnVoltarPagamento'
            ),
            'options' => array(
                'label' => 'Voltar'
            )
        ));
    }

}
