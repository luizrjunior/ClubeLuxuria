<?php

namespace Login\Authentication;

use Doctrine\ORM\EntityManager;
use Usuario\Entity\UsuarioEntity;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;

class Adapter implements AdapterInterface {
    
    protected $em;
    protected $login;
    protected $senha;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function getLogin() {
        return $this->login;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function setLogin($login) {
        $this->login = $login;
        return $this;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
        return $this;
    }

    public function authenticate() {
        $user = $this->em->getRepository('Usuario\Entity\UsuarioEntity')
                ->findByLoginAndPassword(new UsuarioEntity(), $this->getLogin(), $this->getSenha());
        if ($user) {
            return new Result(Result::SUCCESS, $user, array(
                'Login e Senha corretos!'
            ));
        } else {
            return new Result(Result::FAILURE_CREDENTIAL_INVALID, NULL, array(
                'Login ou Senha inválido!'
                )
            );
        }
    }
}
