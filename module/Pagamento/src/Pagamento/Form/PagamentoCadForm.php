<?php

namespace Pagamento\Form;

use Zend\Form\Form;

class PagamentoCadForm extends Form {

    public function __construct($stPagamentos = array()) {
        parent::__construct(NULL);

        $this->stPagamento = $stPagamentos;

        $this->setAttribute('method', 'POST');
        $this->setAttribute('action', 'index/salvar');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', 'sky-form boxed');
        $this->setAttribute('id', 'formCadPagamento');

        $this->add(array(
            'name' => 'idPagamento',
            'type' => 'hidden',
            'attributes' => array(
                'id' => 'idPagamento'
            ),
        ));

        $this->add(array(
            'name' => 'stVencimento',
            'type' => 'hidden',
            'attributes' => array(
                'id' => 'stVencimento'
            ),
        ));

        $this->add(array(
            'name' => 'vlTaxaPublicacao',
            'type' => 'hidden',
            'attributes' => array(
                'id' => 'vlTaxaPublicacao'
            ),
        ));

        $this->add(array(
            'name' => 'vlAnuncioComum',
            'type' => 'hidden',
            'attributes' => array(
                'id' => 'vlAnuncioComum'
            ),
        ));

        $this->add(array(
            'name' => 'idClientePagamento',
            'type' => 'select',
            'attributes' => array(
                'id' => 'idClientePagamento',
                'class' => 'form-control'
            )
        ));

        $this->add(array(
            'name' => 'stPagamento',
            'type' => 'select',
            'attributes' => array(
                'id' => 'stPagamento',
                'class' => 'form-control'
            ),
            'options' => array(
                'value_options' => $this->stPagamento,
            )
        ));

        $this->add(array(
            'name' => 'noDepositante',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Nome completo do depositante',
                'id' => 'noDepositante',
                'class' => 'form-control',
                'maxlength' => 145
            )
        ));

        $this->add(array(
            'name' => 'nuCpfDepositante',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'text',
                'placeholder' => 'Nº do CPF do depositante',
                'id' => 'nuCpfDepositante'
            )
        ));

        $this->add(array(
            'name' => 'dtDeposito',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'dtDeposito'
            )
        ));

        $this->add(array(
            'name' => 'nuComprovante',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Nº do Comprovante do depósito',
                'id' => 'nuComprovante',
                'class' => 'form-control',
                'maxlength' => 55
            )
        ));

        $this->add(array(
            'name' => 'dsLocalEntrega',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'text',
                'placeholder' => 'Endereço Completo de Recebimento do Pagamento',
                'id' => 'dsLocalEntrega'
            )
        ));

        $this->add(array(
            'name' => 'dtEntrega',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'dtEntrega'
            )
        ));

        $this->add(array(
            'name' => 'hrEntrega',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'text',
                'placeholder' => '10:00',
                'id' => 'hrEntrega'
            )
        ));

        $this->add(array(
            'name' => 'dsFalarCom',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'text',
                'placeholder' => 'Nome da pessoa que devemos procurar',
                'id' => 'dsFalarCom'
            )
        ));

        $this->add(array(
            'name' => 'nuTelefone',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'text',
                'placeholder' => '(99)9999-9999',
                'id' => 'nuTelefone'
            )
        ));

        $this->add(array(
            'name' => 'dtPagamento',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'dtPagamento'
            )
        ));

        $this->add(array(
            'name' => 'vlPagamento',
            'attributes' => array(
                'type' => 'text',
                'id' => 'vlPagamento',
                'class' => 'guiMoneyMask form-control',
                'maxlength' => 14
            )
        ));

        $this->add(array(
            'name' => 'dtVencimento',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'dtVencimento'
            )
        ));

        $this->add(array(
            'name' => 'btnNovoCadPagamento',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnNovoCadPagamento',
                'value' => 'Novo'
            ),
            'options' => array(
                'label' => 'Novo'
            )
        ));

        $this->add(array(
            'name' => 'btnGravarPagamento',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnGravarPagamento',
                'value' => 'Salvar'
            ),
            'options' => array(
                'label' => 'Salvar'
            )
        ));

        $this->add(array(
            'name' => 'btnVoltarCadPagamento',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnVoltarCadPagamento',
                'value' => 'Voltar'
            ),
            'options' => array(
                'label' => 'Voltar'
            )
        ));
    }

}