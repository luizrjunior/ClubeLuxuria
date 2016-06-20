<?php

namespace Cliente\Form;

use Zend\Form\Form;
use Cliente\Form\Filter\PesquisarFilter;

class ClientePsqHomeForm extends Form {
    
    protected $SgUf;
    protected $Cidade;
    protected $CabeloCor;
    protected $Situacao;

    public function __construct($ufs = array(), $cidades = array(), $cabelos = array(), $situacoes = array()) {
        parent::__construct(NULL);
        
        $this->SgUf = $ufs;
        $this->Cidade = $cidades;
        $this->CabeloCor = $cabelos;
        $this->Situacao = $situacoes;

        $this->setAttribute('method', 'POST');
        $this->setAttribute('class', 'sky-form boxed');
        $this->setAttribute('id', 'formPsq');
        $this->setInputFilter(new PesquisarFilter());

        $this->add(
            array(
                'name' => 'nomePsq',
                'attributes' => array(
                    'type' => 'text',
                    'placeholder' => 'Nome do Cliente',
                    'id' => 'nomePsq'
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
                'name' => 'idCidadePsq',
                'type' => 'select',
                'attributes' => array(
                    'id' => 'idCidadePsq',
                    'class' => 'form-control'
                ),
                'options' => array(
                    'value_options' => $this->Cidade,
                )
            )
        );

        $this->add(
            array(
                'name' => 'cabeloCorPsq',
                'type' => 'select',
                'attributes' => array(
                    'id' => 'cabeloCorPsq',
                    'class' => 'form-control'
                ),
                'options' => array(
                    'value_options' => $this->CabeloCor,
                )
            )
        );

        $this->add(
            array(
                'name' => 'situacaoPsq',
                'type' => 'select',
                'attributes' => array(
                    'id' => 'situacaoPsq',
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

    }

}
