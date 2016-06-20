<?php

namespace Login\Entity;

use Application\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Pre-Cadastro
 *
 * @ORM\Table(name="tb_pre_cadastro")
 * @ORM\Entity(repositoryClass="Login\Entity\Repository\PreCadastroRepository")
 */
class PreCadastroEntity extends AbstractEntity
{
    
    /**
    * @param array $options
    */
    public function __construct(Array $options = array())
    {
        parent::__construct($options);
    }//__construct
    
  
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="ID_CADASTRO", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idCadastro;

    /**
     * @var string
     *
     * @ORM\Column(name="NO_USUARIO", type="string")
     */
    private $noUsuario;

    /**
     * @var string
     *
     * @ORM\Column(name="DT_NASCIMENTO", type="string")
     */
    private $dtNascimento;

    /**
     * @var string
     *
     * @ORM\Column(name="NU_CPF", type="string")
     */
    private $cpf;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_EMAIL", type="string")
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="NU_TEL1", type="string")
     */
    private $tel1;

    /**
     * @var string
     *
     * @ORM\Column(name="NU_TEL2", type="string")
     */
    private $tel2;
    
    /**
     * @var string
     *
     * @ORM\Column(name="NO_UF", type="string")
     */
    private $uf;
    
    /**
     * @var string
     *
     * @ORM\Column(name="NU_CEP", type="string")
     */
    private $cep;
    
    /**
     * @var string
     *
     * @ORM\Column(name="NO_CIDADE", type="string")
     */
    private $cidade;
    
    /**
     * @var string
     *
     * @ORM\Column(name="NO_BAIRRO", type="string")
     */
    private $bairro;
    
    /**
     * @var string
     *
        * @ORM\Column(name="NO_COMPLEMENTO", type="string")
     */
    private $complemento;
    
    /**
     * @var string
     *
        * @ORM\Column(name="DS_COD_PROMOCAO", type="string")
     */
    private $codPromocional;
    
    function getIdCadastro() {
        return $this->idCadastro;
    }

    function getNoUsuario() {
        return $this->noUsuario;
    }

    function getDtNascimento() {
        return $this->dtNascimento;
    }

    function getCpf() {
        return $this->cpf;
    }

    function getEmail() {
        return $this->email;
    }

    function getTel1() {
        return $this->tel1;
    }

    function getTel2() {
        return $this->tel2;
    }

    function getUf() {
        return $this->uf;
    }

    function getCep() {
        return $this->cep;
    }

    function getCidade() {
        return $this->cidade;
    }

    function getBairro() {
        return $this->bairro;
    }

    function getComplemento() {
        return $this->complemento;
    }

    function getCodPromocional() {
        return $this->codPromocional;
    }

//    function setIdCadastro($idCadastro) {
//        $this->idCadastro = $idCadastro;
//    }

    function setNoUsuario($noUsuario) {
        $this->noUsuario = $noUsuario;
    }

    function setDtNascimento($dtNascimento) {
        $this->dtNascimento = $dtNascimento;
    }

    function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setTel1($tel1) {
        $this->tel1 = $tel1;
    }

    function setTel2($tel2) {
        $this->tel2 = $tel2;
    }

    function setUf($uf) {
        $this->uf = $uf;
    }

    function setCep($cep) {
        $this->cep = $cep;
    }

    function setCidade($cidade) {
        $this->cidade = $cidade;
    }

    function setBairro($bairro) {
        $this->bairro = $bairro;
    }

    function setComplemento($complemento) {
        $this->complemento = $complemento;
    }

    function setCodPromocional($codPromocional) {
        $this->codPromocional = $codPromocional;
    }


    

}//PreCadastroEntity