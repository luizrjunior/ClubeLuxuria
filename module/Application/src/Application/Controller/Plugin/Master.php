<?php

namespace Application\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;
use Zend\Mail\Transport\SmtpOptions;

class Master extends AbstractPlugin {

    protected $_dbAdapter;
    protected $_serviceManager;
    protected $_tpAns = array(
        0 => 'Todos',
        1 => 'Imóvel',
        2 => 'Automóvel',
        3 => 'Moto',
    );
    protected $_tpPessoa = array(
        0 => 'Todos',
        1 => 'Pessoa Física',
        2 => 'Pessoa Jurídica'
    );
    protected $_stTramiteProcesso = array(
        1 => 'Em Espera',
        2 => 'Aceita',
        3 => 'Cancelada'
    );
    protected $_nuEtapaCorrespondente = array(
        '' => 'NENHUMA ETAPA',
        1 => 'ETAPA I',
        2 => 'ETAPA II',
        3 => 'ETAPA III'
    );

    function __construct($serviceManager) {
        $this->_dbAdapter = $serviceManager->get('Zend\Db\Adapter\Adapter');
        $this->_serviceManager = $serviceManager;
    }

    /**
     * traduz o id para o nome do ANS
     * @name traduzirIdParaANS
     * @access public
     * @param Int $idAns id do ans o qual se deseja o nome
     * @return String nome do ans
     * @author  Marcelo Neres <marcelo.neres@consegurocorretora.com.br>
     */
    public function traduzirIdParaANS($idAns, $hasTipo = TRUE) {

        $sql = 'SELECT DS_ANS,TP_ANS FROM consegurocorre3.tb_conseg_ans WHERE `ID_ANS` = ?';
        $statement = $this->_dbAdapter->createStatement($sql, array($idAns));
        $result = $statement->execute();
        $ans = '';
        if ($hasTipo && $result->current()['TP_ANS'] == 0) {
            $ans = $result->current()['DS_ANS'];
        } elseif ($hasTipo) {
            $ans = $result->current()['DS_ANS'] . ' - ' . $this->_tpAns[(int) $result->current()['TP_ANS']];
        } else {
            $ans = $result->current()['DS_ANS'];
        }
        return ucfirst(html_entity_decode($ans));
    }
    
    /**
     * dados da traduação 
     * @name traduzirIdParaFase
     * @access public
     * @param Int $idFase identificador da fase 
     * @param Int $idAns identificador do Ans
     * @return String nome da fase
     * @author  Marcelo Neres <marcelo.neres@consegurocorretora.com.br>
     */
    public function traduzirIdParaFase($idFase, $idAns) {
        $etapa = '';
        if ($idAns == 13) {
            switch ((int) $idFase) {
                case 1:
                    $etapa = 'Etapa I - Análise de Crédito';
                    break;
                case 2:
                    $etapa = 'Etapa II - Formalização da Garantia Veículo';
                    break;
            }
        } elseif ($idAns == 2) {
            switch ((int) $idFase) {
                case 1:
                    $etapa = 'Etapa I - Análise de Crédito';
                    break;
                case 2:
                    $etapa = 'Etapa II - Análise Cadastral do Vendedor Imóvel';
                    break;
                case 3:
                    $etapa = 'Etapa III - Pagamendo do bem';
                    break;
            }
        } else {
            switch ((int) $idFase) {
                case 1:
                    $etapa = 'Fase I';
                    break;
                case 2:
                    $etapa = 'Fase II';
                    break;
                case 3:
                    $etapa = 'Fase III';
                    break;
                case 4:
                    $etapa = 'Fase IV';
                    break;
            }
        }
        return $etapa;
    }

    /**
     * traduz o tipo de ANS  para imóvel auto ou moto
     * @name traduzirTipoANS
     * @access public
     * @param Int $idTipo tipo do ans
     * @return String Ans traduzido
     * @author  Marcelo Neres <marcelo.neres@consegurocorretora.com.br>
     */
    public function traduzirTipoANS($idTipoAns) {
        return $this->_tpAns[$idTipoAns];
    }

    /**
     * envia email noReply
     * @name enviarEmailNoReply
     * @access public
     * @param  Array  $opcoes opcoes que configurarao o envio de email 
     * @return Boolean True caso enviado com sucesso e false caso nao
     * @author  Marcelo Neres <marcelo.neres@consegurocorretora.com.br>
     * <code>
     * //forma de uso
     * $opcoes = array(
     *  'mensagem' => '<html>Mensagem formato html</html>',   //**obrigatório mensagem 
     *  'destinatario' =>    array(emailPessoa@email.com) ,   //**obrigatorio detString|Array 
     *  'assunto' =>    'Email de teste' ,                    //**obrigatorio String|Array
     *  'cc' =>    array(emailCopia@email.com) ,              //Não Obrigatório só em casos de cópia oculta String|Array
     *  'bcc' =>    array(emailCopiaOculta@email.com) ,       //Não Obrigatório só em casos de cópia oculta String|Array
     *  'emailEnvio' => 'noreply@consegurocorretora.com.br',  //Não obrigatorio só em casos que não sejam usados o email noReply
     *  'senhaEmailEnvio' => 'xxx',                           //Não obrigatorio só em casos que não sejam usados o email noReply
     *  'nomeEmailEnvio' => 'xxx',                           //Não obrigatorio só em casos que não sejam usados o email noReply
     *  'smtp' => 'xxx',                           //Não obrigatorio só em casos que não sejam usados o email noReply
     * );
     * 
     * $this->masterPlugin()->$opcoes(enviarEmail);
     * 
     * </code>
     * 
     */
    public function enviarEmail($opcoes) {
//        testando se as chaves estão ok
        $this->_testarChavesObrigatoriasEmail($opcoes);
//        configuracao global do email noReply
        $emailConfig = $this->_serviceManager->get('config')['constsGlobal']['emailNoReply'];

//        configurando o email
        $mensagem = new Message();
//        email de envio
        if (!empty($opcoes['emailEnvio'])) {
            $mensagem->addFrom($opcoes['emailEnvio']);
            $opcoes['smtp'] = $emailConfig['smtp'];
            $opcoes['email'] = $emailConfig['email'];
            $opcoes['senha'] = $emailConfig['senha'];
        } else {
            $mensagem->addFrom($emailConfig['email']);
        }
        $mensagem->addTo($opcoes['destinatario']);

        if ($opcoes['cc'] != "") {
            foreach ($opcoes['cc'] as $listCc) {
                $mensagem->addCc($listCc);
            }
        }
        $mensagem->setSubject($opcoes['assunto']);
//      configurango o smtp de envio
        $transport = new SmtpTransport();
        $transportConfig = new SmtpOptions(array(
            'host' => $opcoes['smtp'],
            'connection_class' => $emailConfig['auth'],
            'connection_config' => array(
                'username' => $opcoes['email'],
                'password' => $opcoes['senha']
            ),
            'port' => $emailConfig['porta'],
        ));
//      setando a mensagem
        $html = new MimePart($opcoes['mensagem']);
        $html->type = "text/html";

        $body = new MimeMessage();
        $body->addPart($html);
        $mensagem->setBody($body);
//        enviando o email
        $transport->setOptions($transportConfig);
        $transport->send($mensagem);
    }

    /**
     * metodo que testa se as chaves obrigatórios estao setados e caso não disparam uma exception
     * @name _testarChavesObrigatoriasEmail
     * @access public
     * @param Array $opcoesEmail opcoes que sao passados para o metodo de envio de email
     * @author  Marcelo Neres <marcelo.neres@consegurocorretora.com.br>
     */
    private function _testarChavesObrigatoriasEmail($opcoesEmail) {
        if (empty($opcoesEmail['mensagem'])) {
            throw new \Exception('Programador a chave "mensagem" é obrigatorio', 500);
        }
        if (empty($opcoesEmail['destinatario'])) {
            throw new \Exception('Programador a chave "destinatario" é obrigatorio', 500);
        }
        if (empty($opcoesEmail['assunto'])) {
            throw new \Exception('Programador a chave "assunto" é obrigatorio', 500);
        }
        if (!empty($opcoesEmail['emailEnvio']) &&
                (empty($opcoesEmail['senhaEmailEnvio']) ||
                empty($opcoesEmail['smtp']) ||
                empty($opcoesEmail['nomeEmailEnvio']))
        ) {
            throw new \Exception('Programador como você setou a chave "emailEnvio" então as chaves "senhaEmailEnvio", "smtp", "nomeEmailEnvio" são obrigatórias ', 500);
        }
    }

    /** traduz o tipo de pessoa para jurídica e física
     * @name traduzirTipoPessoa
     * @access public
     * @param int $idTipoPessoa
     * @return string pessoa
     * @author  Eduardo Ramos <eduardo.freitas@consegurocorretora.com.br>
     */
    public function traduzirTipoPessoa($idTipoPessoa) {
        return $this->_tpPessoa[$idTipoPessoa];
    }

    /**
     * formata o php excel para o tipo data
     * @name dataToPhpExcel
     * @access public
     * @param String $dataOrig data original formato yyyy-mm-dd
     * @return PHPExcel_Shared_Date data tratada para PHP excel caso nao preenchido retorna null
     * @author  Marcelo Neres <marcelo.neres@consegurocorretora.com.br>
     */
    public function dataToPhpExcel($dataOrig = null) {
        if ($dataOrig) {
            $dateTimeObject = new \DateTime($dataOrig);
            $excelDate = \PHPExcel_Shared_Date::PHPToExcel($dateTimeObject);
            return $excelDate;
        }
    }

    public function traduzirSituacaoTramiteProcesso($stTramite) {
        return $this->_stTramiteProcesso[$stTramite];
    }
    
    public function traduzirEtapaCorrespondente($nuEtapa) {
        return $this->_nuEtapaCorrespondente[$nuEtapa];
    }
}

