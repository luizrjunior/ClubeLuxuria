<?php

namespace AlbumFoto\Form;

use Zend\Form\Form;
use AlbumFoto\Form\Filter\FotoPerfilCadFilter;

class FotoPerfilCadForm extends Form {

    public function __construct() {
        parent::__construct(NULL);
        
        $this->setAttribute('method', 'POST');
        $this->setAttribute('action', 'foto/salvar-foto-perfil');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', 'clearfix');
        $this->setAttribute('role', 'form');
        $this->setAttribute('id', 'formCadFotoPerfil');

        $this->setInputFilter(new FotoPerfilCadFilter());

        $this->add(
                array(
                    'name' => 'idFotoPerfil',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'idFotoPerfil'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'idAlbumFotoPerfil',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'idAlbumFotoPerfil'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'tpFotoPerfil',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'tpFotoPerfil'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'stFotoPerfil',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'stFotoPerfil'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'stComentarioFotoPerfil',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'stComentarioFotoPerfil'
                    ),
                )
        );

        $this->add(
                array(
                    'name' => 'dsLegendaFotoPerfil',
                    'type' => 'hidden',
                    'attributes' => array(
                        'value' => 'Foto do Perfil',
                        'id' => 'dsLegenda'
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'dsArquivoFotoPerfil',
                    'type' => 'hidden',
                    'attributes' => array(
                        'id' => 'dsArquivoFotoPerfil'
                    ),
                )
        );

        $this->add(array(
            'name' => 'btnRemoverArquivoFotoPerfil',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-danger btn-xs',
                'id' => 'btnRemoverArquivoFotoPerfil',
                'value' => 'Remover'
            ),
            'options' => array(
                'label' => 'Remover'
            )
        ));

        $this->add(array(
            'name' => 'btnGravarFotoPerfil',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnGravarFotoPerfil',
                'value' => 'Salvar'
            ),
            'options' => array(
                'label' => 'Salvar'
            )
        ));

    }

}