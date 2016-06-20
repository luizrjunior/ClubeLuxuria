<?php

namespace Contato\Entity;

use Application\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Contato
 *
 * @ORM\Table(name="tb_contato")
 * @ORM\Entity(repositoryClass="Contato\Entity\Repository\ContatoRepository")
 */
class ContatoEntity extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="ID_CONTATO", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idContato;

    /**
     * @var integer
     *
     * @ORM\Column(name="STATUS", type="integer")
     */
    private $status;

    /**
     * @var \Contato\Entity\AssuntoEntity
     *
     * @ORM\ManyToOne(targetEntity="Contato\Entity\AssuntoEntity")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_ASSUNTO", referencedColumnName="ID_ASSUNTO", nullable=true)
     * })
     */
    private $idAssunto;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="REGISTRADO", type="datetime")
     */
    private $registrado;

    /**
     * @var string
     *
     * @ORM\Column(name="NOME", type="string")
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="EMAIL", type="string")
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="ASSUNTO", type="string")
     */
    private $assunto;
    
    /**
     * @var string
     *
     * @ORM\Column(name="MENSAGEM", type="string")
     */
    private $mensagem;
    
    /**
     * Get idContato
     *
     * @return integer 
     */
    public function getIdContato()
    {
        return $this->idContato;
    }

    /**
     * Get Status
     * @return integer
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Set Status
     * @param type $status
     * @return \Contato\Entity\Contato
     */
    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    /**
     * Set idAssunto
     *
     * @param \Contato\Entity\AssuntoEntity $idAssunto
     * @return AssuntoEntity
     */
    public function setIdAssunto(\Contato\Entity\AssuntoEntity $idAssunto = null)
    {
        $this->idAssunto = $idAssunto;

        return $this;
    }

    /**
     * Get idAssunto
     *
     * @return \Contato\Entity\AssuntoEntity
     */
    public function getIdAssunto()
    {
        return $this->idAssunto;
    }

    /**
     * Get Registrado
     * @return \DateTime
     */
    public function getRegistrado() {
        return $this->registrado;
    }

    /**
     * Set Registrado
     * @param \DateTime $registrado
     * @return \Contato\Entity\Contato
     */
    public function setRegistrado($registrado) {
        $this->registrado = $registrado;
        return $this;
    }

    /**
     * Get Nome
     * @return string
     */
    public function getNome() {
        return $this->nome;
    }

    /**
     * Set Nome
     * @param type $nome
     * @return \Contato\Entity\Contato
     */
    public function setNome($nome) {
        $this->nome = $nome;
        return $this;
    }

    /**
     * Get Email
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set Email
     * @param type $email
     * @return \Contato\Entity\Contato
     */
    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    /**
     * Get Assunto
     * @return string
     */
    public function getAssunto() {
        return $this->assunto;
    }

    /**
     * Set Assunto
     * @param type $assunto
     * @return \Contato\Entity\Contato
     */
    public function setAssunto($assunto) {
        $this->assunto = $assunto;
        return $this;
    }

    /**
     * Get Mensagem
     * @return string
     */
    public function getMensagem() {
        return $this->mensagem;
    }

    /**
     * Set Mensagem
     * @param type $mensagem
     * @return \Contato\Entity\Contato
     */
    public function setMensagem($mensagem) {
        $this->mensagem = $mensagem;
        return $this;
    }

    /**
     * @param array $options
     */
    public function __construct(Array $options = array())
    {
        parent::__construct($options);
    }    
    
}