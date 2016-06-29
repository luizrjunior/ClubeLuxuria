<?php
namespace AlbumFoto\Form;

use Zend\Form\Form;

class GaleriaFotosPsqForm extends Form {

    public function __construct() {
        parent::__construct(NULL);

        $this->setAttribute('method', 'POST');
        $this->setAttribute('class', 'sky-form boxed');
        $this->setAttribute('id', 'formPsqGaleriaFotos');

        $this->add(array(
            'name' => 'idAlbumPsq',
            'type' => 'hidden',
            'attributes' => array(
                'id' => 'idAlbumPsq'
            ),
        ));

        $this->add(array(
            'name' => 'btnPesquisarGaleriaFotos',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnPesquisarGaleriaFotos'
            ),
            'options' => array(
                'label' => 'Pesquisar'
            )
        ));
    }

}