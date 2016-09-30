<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

class MasterHelper extends AbstractHelper {

    protected $stAtivadoDesativado = array(
        1 => 'Ativado',
        2 => 'Desativado'
    );
    
    protected $tipoUsuario = array(
        1 => 'Administrador',
        2 => 'Funcionário',
        3 => 'Anunciante',
        4 => 'Sócio Clube Luxúria'
    );
    
    protected $stAnunciante = array(
        1 => 'Ativada',
        2 => 'Desativada',
        3 => 'Viajando',
        4 => 'Férias',
        5 => 'Outros'
    );
    
    protected $tipoCaracteristica = array(
        1 => 'Cartões Aceitos',
        2 => 'Serviço',
        3 => 'Atendimento',
        4 => 'Outros'
    );
    
    protected $TpCabeloCor = array(
        1 => 'Loira',
        2 => 'Morena',
        3 => 'Negra',
        4 => 'Ruiva'
    );
    
    protected $tipoVideo = array(
        1 => 'Link',
        2 => 'Embed'
    );
    
    protected $tipoBanner = array(
        1 => 'Banner Principal',
        2 => 'Banner Destaques'
    );
    
    protected $situacaoDepoimento = array(
        1 => 'Aguardando Analise',
        2 => 'Aprovado',
        3 => 'Reprovado'
    );
    
    protected $tpCliente = array(
        1 => 'Anunciante',
        2 => 'Sócio'
    );
    
    protected $stCliente = array(
        1 => 'Ativado',
        2 => 'Desativado',
        3 => 'Pré-Cadastro'
    );
    
    protected $tpAlbum = array(
        1 => 'Principal',
        2 => 'Galeria de Fotos'
    );
    
    protected $tpPagamento = array(
        1 => 'Depósito Bancário',
        2 => 'Pagseguro',
        3 => 'Pagamento Domicilio',
        4 => 'Outros'
    );
    
    protected $stPagamento = array(
        1 => 'Aguardando Pagamento',
        2 => 'Aguardando Depósito Bancário',
        3 => 'Aguardando Pagseguro',
        4 => 'Aguardando Pagamento Domicilio',
        5 => 'Pago',
        6 => 'Devolvido',
        7 => 'Cancelado',
    );
    
    public function __invoke() {
        return $this;
    }

    public function acrescentarZeros($numero, $qtZeros) {
        return str_pad($numero, $qtZeros, "0", STR_PAD_LEFT);
    }

    public function calcularDias($param) {
        $data = explode("-", $param);
        $ano = $data[0];
        $mes = $data[1];
        $dia = $data[2];

        $dtAtual = explode("-", date('Y-m-d'));
        $anoAtual = $dtAtual[0];
        $mesAtual = $dtAtual[1];
        $diaAtual = $dtAtual[2];

        $timestamp1 = mktime(0, 0, 0, $mes, $dia, $ano);
        $timestamp2 = mktime(4, 12, 0, $mesAtual, $diaAtual, $anoAtual);
        $segundos_diferenca = $timestamp1 - $timestamp2;
        $dias_diferenca = $segundos_diferenca / (60 * 60 * 24);
        $diasDiferenca = round(str_replace("-", "", $dias_diferenca));

        return $diasDiferenca;
    }

    public function limitaCaracteres($string, $qtde) {
        return substr($string, 0, $qtde) . "...";
    }
    
    public function stAtivadoDesativado($status) {
        return $this->stAtivadoDesativado[$status];
    }
    
    public function tipoUsuario($tipoUsuario) {
        return $this->tipoUsuario[$tipoUsuario];
    }
    
    public function tipoCaracteristica($tipoCaracteristica) {
        return $this->tipoCaracteristica[$tipoCaracteristica];
    }
    
    public function stAnunciante($stAnunciante) {
        return $this->stAnunciante[$stAnunciante];
    }
    
    public function tpCabeloCor($tpCabeloCor) {
        return $this->TpCabeloCor[$tpCabeloCor];
    }
    
    public function tpPagamento($tpPagamento) {
        return $this->tpPagamento[$tpPagamento];
    }
    
    public function stPagamento($stPagamento) {
        return $this->stPagamento[$stPagamento];
    }
    
    public function tipoVideo($tipoVideo) {
        return $this->tipoVideo[$tipoVideo];
    }
    
    public function tipoBanner($tipoBanner) {
        return $this->tipoBanner[$tipoBanner];
    }
    
    public function situacaoDepoimento($situacaoDepoimento) {
        return $this->situacaoDepoimento[$situacaoDepoimento];
    }
    
    public function stCliente($stCliente) {
        return $this->stCliente[$stCliente];
    }
    
    public function tpCliente($tpCliente) {
        return $this->tpCliente[$tpCliente];
    }
    
    public function tpAlbum($tpAlbum) {
        return $this->tpAlbum[$tpAlbum];
    }
}