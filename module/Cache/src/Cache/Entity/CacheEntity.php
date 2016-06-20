<?php

namespace Cache\Entity;

use Application\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * CacheEntity
 *
 * @ORM\Table(name="tb_cache", indexes={@ORM\Index(name="fk_tb_cache_tb_cliente1_idx", columns={"ID_CLIENTE"})})
 * @ORM\Entity(repositoryClass="Cache\Entity\Repository\CacheRepository")
 */
class CacheEntity extends AbstractEntity {

    /**
     * @var integer
     *
     * @ORM\Column(name="ID_CACHE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCache;

    /**
     * @var string
     *
     * @ORM\Column(name="NO_CACHE", type="string", length=25, nullable=false)
     */
    private $noCache;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_CACHE", type="string", length=45, nullable=false)
     */
    private $dsCache;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_VALOR", type="string", length=45, nullable=false)
     */
    private $dsValor;

    /**
     * @var \Cliente\Entity\ClienteEntity
     *
     * @ORM\ManyToOne(targetEntity="Cliente\Entity\ClienteEntity")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_CLIENTE", referencedColumnName="ID_CLIENTE")
     * })
     */
    private $idCliente;

    function getIdCache() {
        return $this->idCache;
    }

    function getNoCache() {
        return $this->noCache;
    }

    function getDsCache() {
        return $this->dsCache;
    }

    function getDsValor() {
        return $this->dsValor;
    }

    function getIdCliente() {
        return $this->idCliente;
    }

    function setIdCache($idCache) {
        $this->idCache = $idCache;
    }

    function setNoCache($noCache) {
        $this->noCache = $noCache;
    }

    function setDsCache($dsCache) {
        $this->dsCache = $dsCache;
    }

    function setDsValor($dsValor) {
        $this->dsValor = $dsValor;
    }

    function setIdCliente(\Cliente\Entity\ClienteEntity $idCliente) {
        $this->idCliente = $idCliente;
    }

    /**
     * @param array $options
     */
    public function __construct(Array $options = array()) {
        parent::__construct($options);
    }

}
