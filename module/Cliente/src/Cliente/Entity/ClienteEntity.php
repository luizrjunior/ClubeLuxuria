<?php

namespace Cliente\Entity;

use Application\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * ClienteEntity
 *
 * @ORM\Table(name="tb_cliente")
 * @ORM\Entity(repositoryClass="Cliente\Entity\Repository\ClienteRepository")
 */
class ClienteEntity extends AbstractEntity {

    /**
     * @var integer
     *
     * @ORM\Column(name="ID_CLIENTE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCliente;

    /**
     * @var integer
     *
     * @ORM\Column(name="TP_CLIENTE", type="integer", nullable=false)
     */
    private $tpCliente;

    /**
     * @var integer
     *
     * @ORM\Column(name="ST_CLIENTE", type="integer", nullable=false)
     */
    private $stCliente;

    /**
     * @var integer
     *
     * @ORM\Column(name="TP_SEXO", type="integer", nullable=false)
     */
    private $tpSexo;

    /**
     * @var integer
     *
     * @ORM\Column(name="ST_LI_CONCORDO", type="integer", nullable=false)
     */
    private $stLiConcordo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DT_HR_CADASTRO", type="datetime", nullable=false)
     */
    private $dtHrCadastro;

    /**
     * @var \Date
     *
     * @ORM\Column(name="DT_NASCIMENTO", type="date", nullable=false)
     */
    private $dtNascimento;

    /**
     * @var \Date
     *
     * @ORM\Column(name="DT_VENCIMENTO", type="date", nullable=false)
     */
    private $dtVencimento;

    /**
     * @var string
     *
     * @ORM\Column(name="NO_CLIENTE", type="string", length=45, nullable=false)
     */
    private $noCliente;

    /**
     * @var string
     *
     * @ORM\Column(name="NU_CPF", type="string", length=15, nullable=true)
     */
    private $nuCpf;

    /**
     * @var string
     *
     * @ORM\Column(name="NU_CEP", type="string", length=9, nullable=true)
     */
    private $nuCep;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_ENDERECO", type="string", length=135, nullable=false)
     */
    private $dsEndereco;

    /**
     * @var string
     *
     * @ORM\Column(name="SG_UF", type="string", length=2, nullable=true)
     */
    private $sgUf;

    /**
     * @var string
     *
     * @ORM\Column(name="NO_CIDADE", type="string", length=100, nullable=true)
     */
    private $noCidade;

    /**
     * @var string
     *
     * @ORM\Column(name="NU_TELEFONE", type="string", length=14, nullable=false)
     */
    private $nuTelefone;

    /**
     * Get idCliente
     *
     * @return integer
     */
    public function getIdCliente() {
        return $this->idCliente;
    }

    /**
     * Set stCliente
     *
     * @param integer $stCliente
     *
     * @return Cliente
     */
    public function setStCliente($stCliente) {
        $this->stCliente = $stCliente;

        return $this;
    }

    /**
     * Get stCliente
     *
     * @return integer
     */
    public function getStCliente() {
        return $this->stCliente;
    }

    /**
     * Set dtHrCadastro
     *
     * @param \DateTime $dtHrCadastro
     *
     * @return Cliente
     */
    public function setDtHrCadastro($dtHrCadastro) {
        $this->dtHrCadastro = $dtHrCadastro;

        return $this;
    }

    /**
     * Get dtHrCadastro
     *
     * @return \DateTime
     */
    public function getDtHrCadastro() {
        return $this->dtHrCadastro;
    }

    /**
     * Set noCliente
     *
     * @param string $noCliente
     *
     * @return Cliente
     */
    public function setNoCliente($noCliente) {
        $this->noCliente = $noCliente;

        return $this;
    }

    /**
     * Get noCliente
     *
     * @return string
     */
    public function getNoCliente() {
        return $this->noCliente;
    }

    /**
     * Set dsEndereco
     *
     * @param string $dsEndereco
     *
     * @return Cliente
     */
    public function setDsEndereco($dsEndereco) {
        $this->dsEndereco = $dsEndereco;

        return $this;
    }

    /**
     * Get dsDsEndereco
     *
     * @return string
     */
    public function getDsEndereco() {
        return $this->dsEndereco;
    }

    /**
     * Set nuTelefone
     *
     * @param string $nuTelefone
     *
     * @return Cliente
     */
    public function setNuTelefone($nuTelefone) {
        $this->nuTelefone = $nuTelefone;

        return $this;
    }

    /**
     * Get nuTelefone
     *
     * @return string
     */
    public function getNuTelefone() {
        return $this->nuTelefone;
    }

    /**
     * Get tpCliente
     * 
     * @return integer
     */
    function getTpCliente() {
        return $this->tpCliente;
    }

    /**
     * Set tpCliente
     *
     * @param string $tpCliente
     *
     * @return Cliente
     */
    function setTpCliente($tpCliente) {
        $this->tpCliente = $tpCliente;
    }

    /**
     * Get nuCpf
     * 
     * @return string
     */
    function getNuCpf() {
        return $this->nuCpf;
    }

    function getTpSexo() {
        return $this->tpSexo;
    }

    function getDtNascimento() {
        return $this->dtNascimento;
    }

    function getDtVencimento() {
        return $this->dtVencimento;
    }

    function setNuCpf($nuCpf) {
        $this->nuCpf = $nuCpf;
    }

    function setTpSexo($tpSexo) {
        $this->tpSexo = $tpSexo;
    }

    function setDtNascimento($dtNascimento) {
        $this->dtNascimento = $dtNascimento;
    }

    function setDtVencimento($dtVencimento) {
        $this->dtVencimento = $dtVencimento;
    }

    function getNuCep() {
        return $this->nuCep;
    }

    function getSgUf() {
        return $this->sgUf;
    }

    function getNoCidade() {
        return $this->noCidade;
    }

    function setNuCep($nuCep) {
        $this->nuCep = $nuCep;
    }

    function setSgUf($sgUf) {
        $this->sgUf = $sgUf;
    }

    function setNoCidade($noCidade) {
        $this->noCidade = $noCidade;
    }

    function getStLiConcordo() {
        return $this->stLiConcordo;
    }

    function setStLiConcordo($stLiConcordo) {
        $this->stLiConcordo = $stLiConcordo;
    }

    /**
     * @param array $options
     */
    public function __construct(Array $options = array()) {
        parent::__construct($options);
    }

}