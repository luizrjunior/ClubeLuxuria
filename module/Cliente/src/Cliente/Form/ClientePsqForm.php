<?php

namespace Cliente\Form;

use Zend\Form\Form;

class ClientePsqForm extends Form {
    
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
        $this->setAttribute('class', 'sky-form boxed');
        $this->setAttribute('id', 'formPsqCliente');

        $this->add(
            array(
                'name' => 'tpClientePsq',
                'type' => 'select',
                'attributes' => array(
                    'id' => 'tpClientePsq',
                    'class' => 'form-control'
                ),
                'options' => array(
                    'value_options' => $this->TpCliente,
                )
            )
        );

        $this->add(
            array(
                'name' => 'stClientePsq',
                'type' => 'select',
                'attributes' => array(
                    'id' => 'stClientePsq',
                    'class' => 'form-control'
                ),
                'options' => array(
                    'value_options' => $this->StCliente,
                )
            )
        );

        $this->add(
            array(
                'name' => 'noClientePsq',
                'attributes' => array(
                    'class' => 'form-control',
                    'type' => 'text',
                    'placeholder' => 'Pesquisar pelo nome do cliente',
                    'id' => 'noClientePsq'
                )
            )
        );

        $this->add(
            array(
                'name' => 'nuCpfPsq',
                'attributes' => array(
                    'class' => 'form-control',
                    'type' => 'text',
                    'placeholder' => 'Pesquisar pelo nº do CPF',
                    'id' => 'nuCpfPsq'
                )
            )
        );

        $this->add(
            array(
                'name' => 'tpSexoPsq',
                'type' => 'select',
                'attributes' => array(
                    'id' => 'tpSexoPsq',
                    'class' => 'form-control'
                ),
                'options' => array(
                    'value_options' => $this->TpSexo,
                )
            )
        );

        $this->add(
            array(
                'name' => 'sgUfPsq',
                'type' => 'select',
                'attributes' => array(
                    'id' => 'sgUfPsq',
                    'class' => 'form-control'
                ),
                'options' => array(
                    'value_options' => $this->SgUf,
                )
            )
        );

        $this->add(
            array(
                'name' => 'noCidadePsq',
                'attributes' => array(
                    'class' => 'form-control',
                    'type' => 'text',
                    'placeholder' => 'Pesquisar pelo nome da cidade',
                    'id' => 'noCidadePsq'
                )
            )
        );

        $this->add(array(
            'name' => 'nuTelefoneClientePsq',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'text',
                'placeholder' => 'Pesquisar pelo nº do telefone. Ex.: (99)9999-9999',
                'id' => 'nuTelefoneClientePsq'
            )
        ));

        $this->add(array(
            'name' => 'dtVencimentoPsq',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'dtVencimentoPsq'
            )
        ));

        $this->add(array(
            'name' => 'btnPesquisarCliente',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnPesquisarCliente'
            ),
            'options' => array(
                'label' => 'Pesquisar'
            )
        ));

        $this->add(array(
            'name' => 'btnNovoCliente',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnNovoCliente'
            ),
            'options' => array(
                'label' => 'Adicionar'
            )
        ));

        $this->add(array(
            'name' => 'btnVoltarCliente',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnVoltarCliente'
            ),
            'options' => array(
                'label' => 'Voltar'
            )
        ));

    }

}
