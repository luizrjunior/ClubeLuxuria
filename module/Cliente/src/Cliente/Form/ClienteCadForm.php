<?php

namespace Cliente\Form;

use Zend\Form\Form;

class ClienteCadForm extends Form {

    protected $SgUf;
    protected $StCliente;
    protected $TpCliente;
    protected $TpSexo;

    public function __construct($sgUfs = array(), $stClientes = array(), $tpClientes = array(), $tpSexos = array()) {
        parent::__construct(NULL);

        $this->SgUf = $sgUfs;
        $this->StCliente = $stClientes;
        $this->TpCliente = $tpClientes;
        $this->TpSexo = $tpSexos;

        $this->setAttribute('method', 'POST');
        $this->setAttribute('action', 'index/salvar');
        $this->setAttribute('class', 'sky-form boxed');
        $this->setAttribute('id', 'formCadCliente');

        $this->add(array(
            'name' => 'idCliente',
            'type' => 'hidden',
            'attributes' => array(
                'id' => 'idCliente'
            ),
        ));

        $this->add(array(
            'name' => 'tpCliente',
            'type' => 'select',
            'attributes' => array(
                'id' => 'tpCliente',
                'class' => 'form-control'
            ),
            'options' => array(
                'value_options' => $this->TpCliente,
            )
        ));

        $this->add(array(
            'name' => 'stCliente',
            'type' => 'select',
            'attributes' => array(
                'id' => 'stCliente',
                'class' => 'form-control'
            ),
            'options' => array(
                'value_options' => $this->StCliente,
            )
        ));

        $this->add(array(
            'name' => 'noCliente',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'text',
                'placeholder' => 'Nome Completo',
                'id' => 'noCliente'
            )
        ));

        $this->add(array(
            'name' => 'nuCpf',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'text',
                'placeholder' => 'Nº do CPF',
                'id' => 'nuCpf'
            )
        ));

        $this->add(array(
            'name' => 'tpSexo',
            'type' => 'radio',
            'options' => array(
                'value_options' => $this->TpSexo,
                'allow_empty' => true,
                'nullable' => true,
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'tpSexo',
                'value' => null
            ),
        ));

        $this->add(array(
            'name' => 'nuCep',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'text',
                'placeholder' => 'Nº do CEP',
                'id' => 'nuCep'
            )
        ));

        $this->add(array(
            'name' => 'dsEnderecoCliente',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'text',
                'placeholder' => 'Endereço de Residencia',
                'id' => 'dsEnderecoCliente'
            )
        ));

        $this->add(array(
            'name' => 'sgUfCliente',
            'type' => 'select',
            'attributes' => array(
                'id' => 'sgUfCliente',
                'class' => 'form-control'
            ),
            'options' => array(
                'value_options' => $this->SgUf,
            )
        ));

        $this->add(array(
            'name' => 'noCidadeCliente',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'text',
                'placeholder' => 'Nome da Cidade',
                'id' => 'noCidadeCliente'
            )
        ));

        $this->add(array(
            'name' => 'nuTelefoneCliente',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'text',
                'placeholder' => '(99)9999-9999',
                'id' => 'nuTelefoneCliente'
            )
        ));

        $this->add(array(
            'name' => 'dtNascimento',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'dtNascimento'
            )
        ));

        $this->add(array(
            'name' => 'dtVencimentoCliente',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'dtVencimentoCliente'
            )
        ));

        $this->add(array(
            'name' => 'btnNovoCadCliente',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnNovoCadCliente',
                'value' => 'Novo'
            ),
            'options' => array(
                'label' => 'Novo'
            )
        ));

        $this->add(array(
            'name' => 'btnCaracteristicasCad',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnCaracteristicasCad',
                'value' => 'Características'
            ),
            'options' => array(
                'label' => 'Características'
            )
        ));

        $this->add(array(
            'name' => 'btnFotosCad',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnFotosCad',
                'value' => 'Fotos'
            ),
            'options' => array(
                'label' => 'Fotos'
            )
        ));

        $this->add(array(
            'name' => 'btnVideosCad',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnVideosCad',
                'value' => 'Vídeos'
            ),
            'options' => array(
                'label' => 'Vídeos'
            )
        ));

        $this->add(array(
            'name' => 'btnCacheCad',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnCacheCad',
                'value' => 'Cachês'
            ),
            'options' => array(
                'label' => 'Cachês'
            )
        ));

        $this->add(array(
            'name' => 'btnBannerCad',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnBannerCad',
                'value' => 'Banners'
            ),
            'options' => array(
                'label' => 'Banners'
            )
        ));

        $this->add(array(
            'name' => 'btnDepoimentoCad',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnDepoimentoCad',
                'value' => 'Depoimentos'
            ),
            'options' => array(
                'label' => 'Depoimentos'
            )
        ));

        $this->add(array(
            'name' => 'btnGravarCliente',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnGravarCliente',
                'value' => 'Salvar'
            ),
            'options' => array(
                'label' => 'Salvar'
            )
        ));

        $this->add(array(
            'name' => 'btnVoltarCadCliente',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnVoltarCadCliente',
                'value' => 'Voltar'
            ),
            'options' => array(
                'label' => 'Voltar'
            )
        ));
    }

}
