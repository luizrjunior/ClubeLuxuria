<?php

namespace Anunciante\Form;

use Zend\Form\Form;

class AnuncianteCadForm extends Form {

    protected $TpAnunciante;
    protected $StAnunciante;
    protected $SgUf;
    protected $Cidade;
    protected $TpCabeloCor;
    protected $StAceitaCartao;

    public function __construct($sgUf = array(), $cidade = array(), $tpCabeloCor = array(), $stAceitaCartao = array(), $stAnunciante = array(), $tpAnunciante = array()) {
        parent::__construct(NULL);

        $this->SgUf = $sgUf;
        $this->Cidade = $cidade;
        $this->TpCabeloCor = $tpCabeloCor;
        $this->StAnunciante = $stAnunciante;
        $this->StAceitaCartao = $stAceitaCartao;
        $this->TpAnunciante = $tpAnunciante;

        $this->setAttribute('method', 'POST');
        $this->setAttribute('class', 'sky-form boxed');
        $this->setAttribute('id', 'formCadAnunciante');

        $this->add(array(
            'name' => 'idAnunciante',
            'type' => 'hidden',
            'attributes' => array(
                'id' => 'idAnunciante'
            ),
        ));

        $this->add(array(
            'name' => 'idClienteAnunciante',
            'type' => 'hidden',
            'attributes' => array(
                'id' => 'idClienteAnunciante'
            ),
        ));

        $this->add(array(
            'name' => 'tpAnunciante',
            'type' => 'select',
            'attributes' => array(
                'id' => 'tpAnunciante',
                'class' => 'form-control'
            ),
            'options' => array(
                'value_options' => $this->TpAnunciante,
            )
        ));

        $this->add(array(
            'name' => 'stAnunciante',
            'type' => 'select',
            'attributes' => array(
                'id' => 'stAnunciante',
                'class' => 'form-control'
            ),
            'options' => array(
                'value_options' => $this->StAnunciante,
            )
        ));

        $this->add(array(
            'name' => 'noArtistico',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Nome Artístico',
                'id' => 'noArtistico'
            )
        ));

        $this->add(array(
            'name' => 'nuTelefoneAnunciante',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => '(99)9999-9999',
                'id' => 'nuTelefoneAnunciante'
            )
                )
        );

        $this->add(array(
                    'name' => 'tpCabeloCor',
                    'type' => 'radio',
                    'options' => array(
                        'value_options' => $this->TpCabeloCor,
                        'allow_empty' => true,
                        'nullable' => true,
                    ),
                    'attributes' => array(
                        'value' => null
                    ),
                )
        );

        $this->add(array(
                    'name' => 'stAceitaCartao',
                    'type' => 'radio',
                    'options' => array(
                        'value_options' => $this->StAceitaCartao,
                        'allow_empty' => true,
                        'nullable' => true,
                    ),
                    'attributes' => array(
                        'value' => null
                    ),
                )
        );

        $this->add(array(
            'name' => 'dsUrlSite',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'http://www.seuwebsite.com',
                'id' => 'dsUrlSite'
            )
        ));

        $this->add(
                array(
                    'name' => 'sgUfAnunciante',
                    'type' => 'select',
                    'attributes' => array(
                        'id' => 'sgUfAnunciante',
                        'class' => 'form-control'
                    ),
                    'options' => array(
                        'value_options' => $this->SgUf,
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'idCidadeAnunciante',
                    'type' => 'select',
                    'attributes' => array(
                        'id' => 'idCidadeAnunciante',
                        'class' => 'form-control'
                    ),
                    'options' => array(
                        'value_options' => $this->Cidade,
                    )
                )
        );

        $this->add(array(
                    'name' => 'nuLatitude',
                    'attributes' => array(
                        'type' => 'text',
                        'placeholder' => 'Latitude do Endereço',
                        'id' => 'nuLatitude'
                    )
                )
        );

        $this->add(array(
                    'name' => 'nuLongitude',
                    'attributes' => array(
                        'type' => 'text',
                        'placeholder' => 'Longitude do Endereço',
                        'id' => 'nuLongitude'
                    )
                )
        );

        $this->add(array(
            'name' => 'dsFrase1',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Primeira frase da Anunciante. (Capa do Anuncio)',
                'maxlength' => 25,
                'id' => 'dsFrase1'
            )
        ));

        $this->add(array(
            'name' => 'dsFrase2',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Segunda frase da Anunciante. (Ao lado direito das fotos horizontais)',
                'maxlength' => 45,
                'id' => 'dsFrase2'
            )
        ));

        $this->add(array(
            'name' => 'dsFrase3',
            'type' => 'textarea',
            'attributes' => array(
                'rows' => 5,
                'class' => 'form-control input-sm',
                'placeholder' => 'Breve descrição sobre a Anunciante. Modo de ser e de atender',
                'maxlength' => 250,
                'id' => 'dsFrase3'
            ),
        ));

        $this->add(array(
            'name' => 'btnGravarAnunciante',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnGravarAnunciante',
                'value' => 'Salvar'
            ),
            'options' => array(
                'label' => 'Salvar'
            )
        ));
    }

}
