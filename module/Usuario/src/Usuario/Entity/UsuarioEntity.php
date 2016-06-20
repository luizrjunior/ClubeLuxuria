<?php

namespace Usuario\Entity;

use Application\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * UsuarioEntity
 *
 * @ORM\Table(name="tb_usuario")
 * @ORM\Entity(repositoryClass="Usuario\Entity\Repository\UsuarioRepository")
 */
class UsuarioEntity extends AbstractEntity {

    /**
     * @var integer
     *
     * @ORM\Column(name="ID_USUARIO", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUsuario;

    /**
     * @var integer
     *
     * @ORM\Column(name="ST_USUARIO", type="integer", nullable=false)
     */
    private $stUsuario;

    /**
     * @var integer
     *
     * @ORM\Column(name="TP_USUARIO", type="integer", nullable=false)
     */
    private $tpUsuario;

    /**
     * @var string
     *
     * @ORM\Column(name="NO_USUARIO", type="string", length=90, nullable=true)
     */
    private $noUsuario;

    /**
     * @var string
     *
     * @ORM\Column(name="LOGIN", type="string", length=45, nullable=false)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="SENHA", type="string", length=32, nullable=false)
     */
    private $senha;

    /**
     * @var string
     *
     * @ORM\Column(name="EMAIL", type="string", length=125, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="SG_UF", type="string", length=2, nullable=false)
     */
    private $sgUf;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DT_CADASTRO", type="datetime", nullable=false)
     */
    private $dtCadastro;

    /**
     * Get idUsuario
     *
     * @return integer 
     */
    public function getIdUsuario() {
        return $this->idUsuario;
    }

    /**
     * Set stUsuario
     *
     * @param integer $stUsuario
     * @return UsuarioEntity
     */
    public function setStUsuario($stUsuario) {
        $this->stUsuario = $stUsuario;

        return $this;
    }

    /**
     * Get stUsuario
     *
     * @return integer 
     */
    public function getStUsuario() {
        return $this->stUsuario;
    }

    /**
     * Set tpUsuario
     *
     * @param integer $tpUsuario
     * @return UsuarioEntity
     */
    public function setTpUsuario($tpUsuario) {
        $this->tpUsuario = $tpUsuario;

        return $this;
    }

    /**
     * Get tpUsuario
     *
     * @return integer 
     */
    public function getTpUsuario() {
        return $this->tpUsuario;
    }

    /**
     * Set noUsuario
     *
     * @param string $noUsuario
     * @return UsuarioEntity
     */
    public function setNoUsuario($noUsuario) {
        $this->noUsuario = $noUsuario;

        return $this;
    }

    /**
     * Get noUsuario
     *
     * @return string 
     */
    public function getNoUsuario() {
        return $this->noUsuario;
    }

    /**
     * Set login
     *
     * @param string $login
     * @return UsuarioEntity
     */
    public function setLogin($login) {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string 
     */
    public function getLogin() {
        return $this->login;
    }

    /**
     * @param $password
     * @return string
     */
    public function encryptPassword($password) {
        $crypt = md5($password);
        return $crypt;
    }
    
    /**
     * Set senha
     *
     * @param string $senha
     * @return UsuarioEntity
     */
    public function setSenha($senha) {
        $this->senha = $this->encryptPassword($senha);

        return $this;
    }

    /**
     * Get senha
     *
     * @return string 
     */
    public function getSenha() {
        return $this->senha;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return UsuarioEntity
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set dtCadastro
     *
     * @param \DateTime $dtCadastro
     * @return UsuarioEntity
     */
    public function setDtCadastro($dtCadastro) {
        $this->dtCadastro = $dtCadastro;

        return $this;
    }

    /**
     * Get dtCadastro
     *
     * @return \DateTime 
     */
    public function getDtCadastro() {
        return $this->dtCadastro;
    }
    
    function getSgUf() {
        return $this->sgUf;
    }

    function setSgUf($sgUf) {
        $this->sgUf = $sgUf;
    }

    /**
     * @param array $options
     */
    public function __construct(Array $options = array())
    {
        parent::__construct($options);
    }    

}
