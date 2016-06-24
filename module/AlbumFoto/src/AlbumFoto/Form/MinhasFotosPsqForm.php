<?php
namespace AlbumFoto\Form;

use Zend\Form\Form;

class MinhasFotosPsqForm extends Form {

    public function __construct() {
        parent::__construct(NULL);

        $this->setAttribute('method', 'POST');
        $this->setAttribute('class', 'sky-form boxed');
        $this->setAttribute('id', 'formPsqMinhasFotos');

        $this->add(array(
            'name' => 'idClientePsq',
            'type' => 'hidden',
            'attributes' => array(
                'id' => 'idClientePsq'
            ),
        ));

        $this->add(array(
            'name' => 'btnPesquisarMinhasFotos',
            'attributes' => array(
                'type' => 'button',
                'class' => 'btn btn-primary',
                'id' => 'btnPesquisarMinhasFotos'
            ),
            'options' => array(
                'label' => 'Pesquisar'
            )
        ));
    }

}