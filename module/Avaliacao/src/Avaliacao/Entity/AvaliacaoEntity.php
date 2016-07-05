<?php

namespace Avaliacao\Entity;

use Application\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * AvaliacaoEntity
 *
 * @ORM\Table(name="tb_avaliacao", indexes={@ORM\Index(name="fk_tb_avaliacao_tb_anunciante1_idx", columns={"ID_ANUNCIANTE"})})
 * @ORM\Entity(repositoryClass="Avaliacao\Entity\Repository\AvaliacaoRepository")
 */
class AvaliacaoEntity extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_AVALIACAO", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAvaliacao;

    /**
     * @var integer
     *
     * @ORM\Column(name="NT_ROSTO", type="integer", nullable=false)
     */
    private $ntRosto;

    /**
     * @var integer
     *
     * @ORM\Column(name="NT_CORPO", type="integer", nullable=false)
     */
    private $ntCorpo;

    /**
     * @var integer
     *
     * @ORM\Column(name="NT_ORAL", type="integer", nullable=false)
     */
    private $ntOral;

    /**
     * @var integer
     *
     * @ORM\Column(name="NT_VAGINAL", type="integer", nullable=false)
     */
    private $ntVaginal;

    /**
     * @var integer
     *
     * @ORM\Column(name="NT_ANAL", type="integer", nullable=false)
     */
    private $ntAnal;

    /**
     * @var integer
     *
     * @ORM\Column(name="NT_BEIJO_BOCA", type="integer", nullable=false)
     */
    private $ntBeijoBoca;

    /**
     * @var integer
     *
     * @ORM\Column(name="ST_AVALIACAO", type="integer", nullable=false)
     */
    private $stAvaliacao;

    /**
     * @var string
     *
     * @ORM\Column(name="VL_CUSTO", type="decimal", precision=12, scale=2, nullable=true)
     */
    private $vlCusto;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DT_AVALIACAO", type="date", nullable=false)
     */
    private $dtAvaliacao;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_ATENDIMENTO", type="text", nullable=false)
     */
    private $dsAtendimento;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_APRESENTACAO", type="string", length=255, nullable=true)
     */
    private $dsApresentacao;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_PERSONALIDADE", type="string", length=255, nullable=true)
     */
    private $dsPersonalidade;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_ROSTO", type="string", length=45, nullable=true)
     */
    private $dsRosto;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_CORPO", type="string", length=45, nullable=true)
     */
    private $dsCorpo;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_ORAL", type="string", length=45, nullable=true)
     */
    private $dsOral;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_VAGINAL", type="string", length=45, nullable=true)
     */
    private $dsVaginal;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_ANAL", type="string", length=45, nullable=true)
     */
    private $dsAnal;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_BEIJO_BOCA", type="string", length=45, nullable=true)
     */
    private $dsBeijoBoca;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_GERAL", type="string", length=255, nullable=true)
     */
    private $dsGeral;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_CUSTO", type="string", length=45, nullable=true)
     */
    private $dsCusto;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_CONSIDERACAO_FINAL", type="string", length=255, nullable=true)
     */
    private $dsConsideracaoFinal;

    /**
     * @var \Anunciante\Entity\AnuncianteEntity
     *
     * @ORM\ManyToOne(targetEntity="Anunciante\Entity\AnuncianteEntity")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_ANUNCIANTE", referencedColumnName="ID_ANUNCIANTE")
     * })
     */
    private $idAnunciante;

    /**
     * @param array $options
     */
    public function __construct(Array $options = array())
    {
        parent::__construct($options);
    }   
    
    function getIdAvaliacao() {
        return $this->idAvaliacao;
    }

    function getNtRosto() {
        return $this->ntRosto;
    }

    function getNtCorpo() {
        return $this->ntCorpo;
    }

    function getNtOral() {
        return $this->ntOral;
    }

    function getNtVaginal() {
        return $this->ntVaginal;
    }

    function getNtAnal() {
        return $this->ntAnal;
    }

    function getNtBeijoBoca() {
        return $this->ntBeijoBoca;
    }

    function getStAvaliacao() {
        return $this->stAvaliacao;
    }

    function getVlCusto() {
        return $this->vlCusto;
    }

    function getDtAvaliacao() {
        return $this->dtAvaliacao;
    }

    function getDsAtendimento() {
        return $this->dsAtendimento;
    }

    function getDsApresentacao() {
        return $this->dsApresentacao;
    }

    function getDsPersonalidade() {
        return $this->dsPersonalidade;
    }

    function getDsRosto() {
        return $this->dsRosto;
    }

    function getDsCorpo() {
        return $this->dsCorpo;
    }

    function getDsOral() {
        return $this->dsOral;
    }

    function getDsVaginal() {
        return $this->dsVaginal;
    }

    function getDsAnal() {
        return $this->dsAnal;
    }

    function getDsBeijoBoca() {
        return $this->dsBeijoBoca;
    }

    function getDsGeral() {
        return $this->dsGeral;
    }

    function getDsCusto() {
        return $this->dsCusto;
    }

    function getDsConsideracaoFinal() {
        return $this->dsConsideracaoFinal;
    }

    function getIdAnunciante() {
        return $this->idAnunciante;
    }

    function setIdAvaliacao($idAvaliacao) {
        $this->idAvaliacao = $idAvaliacao;
    }

    function setNtRosto($ntRosto) {
        $this->ntRosto = $ntRosto;
    }

    function setNtCorpo($ntCorpo) {
        $this->ntCorpo = $ntCorpo;
    }

    function setNtOral($ntOral) {
        $this->ntOral = $ntOral;
    }

    function setNtVaginal($ntVaginal) {
        $this->ntVaginal = $ntVaginal;
    }

    function setNtAnal($ntAnal) {
        $this->ntAnal = $ntAnal;
    }

    function setNtBeijoBoca($ntBeijoBoca) {
        $this->ntBeijoBoca = $ntBeijoBoca;
    }

    function setStAvaliacao($stAvaliacao) {
        $this->stAvaliacao = $stAvaliacao;
    }

    function setVlCusto($vlCusto) {
        $this->vlCusto = $vlCusto;
    }

    function setDtAvaliacao(\DateTime $dtAvaliacao) {
        $this->dtAvaliacao = $dtAvaliacao;
    }

    function setDsAtendimento($dsAtendimento) {
        $this->dsAtendimento = $dsAtendimento;
    }

    function setDsApresentacao($dsApresentacao) {
        $this->dsApresentacao = $dsApresentacao;
    }

    function setDsPersonalidade($dsPersonalidade) {
        $this->dsPersonalidade = $dsPersonalidade;
    }

    function setDsRosto($dsRosto) {
        $this->dsRosto = $dsRosto;
    }

    function setDsCorpo($dsCorpo) {
        $this->dsCorpo = $dsCorpo;
    }

    function setDsOral($dsOral) {
        $this->dsOral = $dsOral;
    }

    function setDsVaginal($dsVaginal) {
        $this->dsVaginal = $dsVaginal;
    }

    function setDsAnal($dsAnal) {
        $this->dsAnal = $dsAnal;
    }

    function setDsBeijoBoca($dsBeijoBoca) {
        $this->dsBeijoBoca = $dsBeijoBoca;
    }

    function setDsGeral($dsGeral) {
        $this->dsGeral = $dsGeral;
    }

    function setDsCusto($dsCusto) {
        $this->dsCusto = $dsCusto;
    }

    function setDsConsideracaoFinal($dsConsideracaoFinal) {
        $this->dsConsideracaoFinal = $dsConsideracaoFinal;
    }

    function setIdAnunciante(\Anunciante\Entity\AnuncianteEntity $idAnunciante) {
        $this->idAnunciante = $idAnunciante;
    }


}
