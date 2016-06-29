<?php
namespace AlbumFoto\Form;

use Zend\Form\Form;

class MeusAlbunsPsqForm extends Form {

    public function __construct() {
        parent::__construct(NULL);

        $this->setAttribute('method', 'POST');
        $this->setAttribute('class', 'sky-form boxed');
        $this->setAttribute('id', 'formPsqMeusAlbuns');

        $this->add(array(
            'name' => 'idClientePsqMeusAlbuns',
            'type' => 'hidden',
            'attributes' => array(
                'id' => 'idClientePsqMeusAlbuns'
            ),
        ));

        $this->add(array(
            'name' => 'btnPesquisarMeusAlbuns',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnPesquisarMeusAlbuns'
            ),
            'options' => array(
                'label' => 'Pesquisar'
            )
        ));
    }

}