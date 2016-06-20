<?php

namespace Login\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use Login\Form;

class IndexController extends AbstractController {

    function __construct() {
        $this->service = 'Login\Service\LoginService';
        $this->form =  new Form\LoginForm();
        $this->_view = new ViewModel();
    }

    public function logarAction() {
        if ($this->identity()) {
            $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
            $auth->clearIdentity();
        }
        $Dados = $this->login();
        if ($Dados['tipoMsg'] === "S") {
            return $this->redirect()->toRoute('perfil');
        }
    }
    
    public function indexAction() {
        if (!$this->identity()) {
            if (is_string($this->form)) {
                $form = new $this->form;
            } else {
                $form = $this->form;
            }
            $this->_view->setVariable('formLogin', $this->form);
            $request = $this->getRequest();
            if ($request->isPost()) {
                $form->setData($request->getPost());
                $Login = $this->validarLogin($form);
                if ($Login['tipoMsg'] === "S") {
                    $Dados = $this->login();
                    if ($Dados['tipoMsg'] === "S") {
                        return $this->redirect()->toRoute('perfil');
                    } else {
                        $this->_view->setVariable('dados', $Dados);
                        return $this->_view;
                    }
                } else {
                    $this->_view->setVariable('dados', $Login);
                    return $this->_view;
                }
            } else {
                return $this->_view;
            }
        } else {
            return $this->redirect()->toRoute('perfil');
        }
    }

    private function validarLogin($form) {
        $post = $this->getRequest()->getPost()->toArray();
        $tipoMsg = "S";$textoMsg = "Formulário validade com sucesso!";
        if ($form->isValid()) {
            if ($post['login'] === "") {
                $tipoMsg = "W"; 
                $textoMsg = "O campo <strong>Login</strong> é de preenchimento obrigatório!";
            }
            if ($post['senha'] === "") {
                $tipoMsg = "W"; 
                $textoMsg = "O campo <strong>Senha</strong> é de preenchimento obrigatório!";
            }
            if ($post['login'] === "" && $post['senha'] === "") {
                $tipoMsg = "W"; 
                $textoMsg = "Os campos <strong>Login</strong> e <strong>Senha</strong> são de preenchimento obrigatório!";
            }
        }
        $dados = array();
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;
        return $dados;
    }
    
    private function login() {
        $post = $this->getRequest()->getPost()->toArray();
        $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $adapter = $auth->getAdapter();
        $adapter->setLogin($post['login'])->setSenha($post['senha']);
        if ($auth->authenticate()->isValid()) {
            $message = $auth->authenticate()->getMessages();
            $tipoMsg = "S";
            $textoMsg = $message[0];
        } else {
            $message = $auth->authenticate()->getMessages();
            $tipoMsg = "E"; 
            $textoMsg = $message[0];
        }
        $dados = array();
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;
        return $dados;
    }

    public function logoutAction() {
        $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $auth->clearIdentity();
        return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
    }

}