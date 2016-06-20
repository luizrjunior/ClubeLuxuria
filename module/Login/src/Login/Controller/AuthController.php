<?php
/**
 * Description of authController
 * 
 * Todos os controllers que necessitarem de login deverá herdar de AuthController
 *
 * @author jose-filho
 */
namespace Login\Controller;

use Application\Controller\AbstractController;

use Zend\Mvc\Controller\AbstractController;
use Zend\View\Model\ViewModel;



class AuthController extends AbstractController
{ 
    function __construct() 
    {
        if (!$this->identity()) {
            $viewModel = new ViewModel();
            $loginForm = new Form\LoginForm();
            $cadastroForm = new Form\NovoCadastroForm();        

            $viewModel->setVariable('formLogin', $loginForm);        
            $viewModel->setVariable('formCadastro', $cadastroForm);        

            return $viewModel;
        } else {
            return $this->redirect()->toRoute('usuario', array('controller' => 'index', 'action' => 'index'));
        }
    }
    
    
}


