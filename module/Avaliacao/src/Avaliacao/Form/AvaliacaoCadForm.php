<?php

namespace Avaliacao\Form;

use Zend\Form\Form;

class AvaliacaoCadForm extends Form {

    protected $StAvaliacao;
    protected $TpAvaliacao;

    public function __construct($stAvaliacao = array(), $tpAvaliacao = array()) {
        parent::__construct(NULL);

        $this->StAvaliacao = $stAvaliacao;
        $this->TpAvaliacao = $tpAvaliacao;

        $this->setAttribute('method', 'POST');
        $this->setAttribute('class', 'sky-form boxed');
        $this->setAttribute('id', 'formCadAvaliacao');

        $this->add(array(
            'name' => 'idAvaliacao',
            'type' => 'hidden',
            'attributes' => array(
                'id' => 'idAvaliacao'
            ),
        ));

        $this->add(array(
            'name' => 'idAnuncianteAvaliacao',
            'type' => 'hidden',
            'attributes' => array(
                'id' => 'idAnuncianteAvaliacao'
            ),
        ));

        $this->add(array(
            'name' => 'tpAvaliacao',
            'type' => 'select',
            'attributes' => array(
                'id' => 'tpAvaliacao',
                'class' => 'form-control'
            ),
            'options' => array(
                'value_options' => $this->TpAvaliacao,
            )
        ));

        $this->add(array(
            'name' => 'stAvaliacao',
            'type' => 'radio',
            'options' => array(
                'value_options' => $this->StAvaliacao,
                'allow_empty' => true,
                'nullable' => true,
            ),
            'attributes' => array(
                'value' => null
            ),
        ));

        $this->add(array(
            'name' => 'dsApresentacao',
            'type' => 'textarea',
            'attributes' => array(
                'rows' => 5,
                'class' => 'form-control input-sm',
                'placeholder' => 'Breve descrição sobre apresentação física da anunciante.',
                'maxlength' => 250,
                'id' => 'dsApresentacao'
            ),
        ));

        $this->add(array(
            'name' => 'dsAtendimento',
            'type' => 'textarea',
            'attributes' => array(
                'rows' => 5,
                'class' => 'form-control input-sm',
                'placeholder' => 'Breve descrição sobre o atendimento da anunciante.',
                'maxlength' => 250,
                'id' => 'dsAtendimento'
            ),
        ));

        $this->add(array(
            'name' => 'dsPersonalidade',
            'type' => 'textarea',
            'attributes' => array(
                'rows' => 5,
                'class' => 'form-control input-sm',
                'placeholder' => 'Breve descrição sobre a personalidade da anunciante.',
                'maxlength' => 250,
                'id' => 'dsPersonalidade'
            ),
        ));

        $this->add(array(
            'name' => 'dsRosto',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Descrição do Rosto',
                'id' => 'dsRosto'
            )
        ));

        $this->add(array(
            'name' => 'dsCorpo',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Descrição do Corpo',
                'id' => 'dsCorpo'
            )
        ));

        $this->add(array(
            'name' => 'dsOral',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Descrição do Sexo Oral',
                'id' => 'dsOral'
            )
        ));

        $this->add(array(
            'name' => 'dsVaginal',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Descrição do Sexo Vaginal',
                'id' => 'dsVaginal'
            )
        ));

        $this->add(array(
            'name' => 'dsBeijoBoca',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Descrição do Beijo na Boca',
                'id' => 'dsBeijoBoca'
            )
        ));


        $this->add(array(
            'name' => 'dsGeral',
            'type' => 'textarea',
            'attributes' => array(
                'rows' => 5,
                'class' => 'form-control input-sm',
                'placeholder' => 'Breve descrição sobre a Avaliacao. Modo de ser e de atender',
                'maxlength' => 250,
                'id' => 'dsGeral'
            ),
        ));

        $this->add(array(
            'name' => 'dsCusto',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Descrição do Custo',
                'id' => 'dsCusto'
            )
        ));

        $this->add(array(
            'name' => 'vlCusto',
            'attributes' => array(
                'type' => 'text',
                'id' => 'vlCusto',
                'class' => 'guiMoneyMask form-control',
                'maxlength' => 14
            )
        ));

        $this->add(array(
            'name' => 'dsConsideracaoFinal',
            'type' => 'textarea',
            'attributes' => array(
                'rows' => 5,
                'class' => 'form-control input-sm',
                'placeholder' => 'Breve descrição sobre a Avaliacao. Modo de ser e de atender',
                'maxlength' => 250,
                'id' => 'dsConsideracaoFinal'
            ),
        ));

        $this->add(array(
            'name' => 'btnGravarAvaliacao',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnGravarAvaliacao',
                'value' => 'Salvar'
            ),
            'options' => array(
                'label' => 'Salvar'
            )
        ));
    }

}
