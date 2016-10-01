<?php

namespace Pagamento\Controller;

use Application\Controller\AbstractController;
use Pagamento\Form as PagamentoForms;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractController {

    private $formPsqPagamento;
    private $formCadPagamento;

    public function __construct() {
        $this->service = 'Pagamento\Service\PagamentoService';
        $this->_view = new ViewModel();
    }

    /**
     * Index Action
     * @return type
     */
    public function indexAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('login', array('controller' => 'index', 'action' => 'index'));
        }
        $this->getEm();
        $config = $this->getServiceLocator()->get('config');

        $stPagamentoPsq = $config['constsStPagamentoPsq'];
        $tpPagamentoPsq = $config['constsTpPagamentoPsq'];

        //Formulario de Pesquisa de Pagamentos
        $this->formPsqPagamento = new PagamentoForms\PagamentoPsqForm($stPagamentoPsq, $tpPagamentoPsq);
        $this->_view->setVariable('formPsqPagamento', $this->formPsqPagamento);

        $stPagamento = $config['constsStPagamentoCad'];

        //Formulario de Cadastro de Pagamento
        $this->formCadPagamento = new PagamentoForms\PagamentoCadForm($stPagamento);
        $this->_view->setVariable('formCadPagamento', $this->formCadPagamento);

        return $this->_view;
    }

    /**
     * Pesquisar Action
     * @return type
     */
    public function pesquisarPagamentoAction() {
        $service = $this->getServiceLocator()->get($this->service);
        $pagina = $this->getEvent()->getRouteMatch()->getParam('page');
        $post = $this->getRequest()->getPost()->toArray();
        $itens = $this->itemForPage;

        $this->_view->setVariable('lista', $service->listarPagamentosPaginado($post, $pagina, $itens));
        $this->_view->setTerminal(true);

        return $this->_view;
    }

    /**
     * Salvar Action
     * @return JsonModel
     */
    public function salvarAction() {
        $post = $this->getRequest()->getPost()->toArray();
        $post['idCliente'] = $post['idClientePagamento'];
        $data = $this->prepararDados($post);
        $service = $this->getServiceLocator()->get($this->service);
        $stDadosPagamento = $this->validarDadosPagamento($post, $service);
        if ($stDadosPagamento['tipoMsg'] === "S") {
            $arrPagamento = $service->salvarPagamento($data);
            if ($arrPagamento) {
                $tipoMsg = "S";
                $textoMsg = $this->exibeMsgSalvar($post['idPagamento'],$post['stPagamento']);
            } else {
                $tipoMsg = "E";
                $textoMsg = "Erro ao tentar cadastrar o Pagamento! Tente mais tarde.";
            }
            $dados = array();
            if ($arrPagamento) {
                $dados['idPagamento'] = $arrPagamento->getIdPagamento();
            }
        } else {
            $tipoMsg = $stDadosPagamento['tipoMsg'];
            $textoMsg = $stDadosPagamento['textoMsg'];
        }
        
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;

        $result = new JsonModel($dados);
        return $result;
    }
    
    private function validarDadosPagamento($post, $service) {
        $tipoMsg = "S";
        $textoMsg = "Dados do Pagamento validado com sucesso!!!";
        $param = array('idPagamento' => $post['idPagamento'], 'idCliente' => $post['idCliente'], 'stPagamento' => array(1,2,3,4));
        $stPagamentoCliente = $service->verificarPagamentoExistente($param);
        if (!$stPagamentoCliente) {
            if ($post['tpPagamento'] == 1) {
                $stValidaCpf = $this->Documento()->validarCpf($post['nuCpfDepositante']);
                if ($stValidaCpf) {
                    $stDtDeposito = $this->Data()->validarData($post['dtDeposito']);
                    if (!$stDtDeposito) {
                        $tipoMsg = "W";
                        $textoMsg = "Data o Depósito inválida! Por favor informe outra.";
                    }
                } else {
                    $tipoMsg = "W";
                    $textoMsg = "Nº do CPF inválido! Por favor informe outro.";
                }
            }
            if ($post['tpPagamento'] == 3) {
                $stDataRecebimento = $this->verificarDataRecebimento($post['dtEntrega']);
                if ($stDataRecebimento) {
                    $stDomingo = $this->Data()->retornaDiaSemana($this->Data()->dateToDB($post['dtEntrega'], FALSE));
                    if ($stDomingo != "dom") {
                        $stHoraRecebimento = $this->verificarHoraRecebimento($post['hrEntrega']);
                        if (!$stHoraRecebimento) {
                            $tipoMsg = "W";
                            $textoMsg = "Hora de Recebimento inválida! Por favor informe uma hora entre 09:00hs e 17:00hs";
                        }
                    } else {
                        $tipoMsg = "W";
                        $textoMsg = "Não recebemos pagamentos aos domingos";
                    }
                } else {
                    if ($post['idPagamento'] == "") {
                        $tipoMsg = "W";
                        $textoMsg = "Data de Recebimento inválida! Por favor informe uma data maior que " . date("d/m/Y");
                    }
                }
            }            
        } else {
            $tipoMsg = "W";
            $textoMsg = "Pagamento já cadastrado no sistema! Por favor informe outro.";
        }

        $dados = array();
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;

        return $dados;
    }

    private function verificarDataRecebimento($dtEntrega) {
        $dt_atual = date("Y-m-d");
        $timestamp_dt_atual = strtotime($dt_atual);

        $dt_expira = $this->Data()->dateToDB($dtEntrega, FALSE);
        $timestamp_dt_expira = strtotime($dt_expira);
        if ($timestamp_dt_atual >= $timestamp_dt_expira) {
            $stDataRecebimento = FALSE;
        } else {
            $stDataRecebimento = TRUE;
        }
        return $stDataRecebimento;
    }

    private function verificarHoraRecebimento($hrEntrega) {
        $hrEntregaArray = explode(":", $hrEntrega);
        $stHrRecebimento = TRUE;
        if ((int)$hrEntregaArray[0] < 9) {
            $stHrRecebimento = FALSE;
        }
        if ((int)$hrEntregaArray[0] > 17) {
            $stHrRecebimento = FALSE;
        }
        return $stHrRecebimento;
    }

    /**
     * Exibe Mensagem Salvar
     * @param type $idPagamento
     * @return string
     */
    private function exibeMsgSalvar($idPagamento, $stPagamento) {
        switch ($stPagamento) {
            case 1:
                $textoMsgComplemento = "<br />Aguardando Pagamento";
                break;
            case 2:
                $textoMsgComplemento = "<br />Aguardando Depósito Bancário";
                break;
            case 3:
                $textoMsgComplemento = "<br />Aguardando Pagseguro";
                break;
            case 4:
                $textoMsgComplemento = "<br />Aguardando Pagamento Domicílio";
                break;
            default:
                $textoMsgComplemento = "";
                break;
        }
        if ($idPagamento) {
            $textoMsg = "Pagamento atualizado com sucesso!" . $textoMsgComplemento;
        } else {
            $textoMsg = "Pagamento cadastrado com sucesso!" . $textoMsgComplemento;
        }
        return $textoMsg;
    }

    /**
     * Selecionar Action
     * @return JsonModel
     */
    public function selecionarAction() {
        $id = $this->getRequest()->getPost()->toArray();
        $service = $this->getServiceLocator()->get($this->service);
        $repository = $service->selecionarPagamento($id);
        if ($repository) {
            $tipoMsg = "S";
            $textoMsg = "Registro encontrado!";
            $dados = $this->carregarDados($repository);
        } else {
            $tipoMsg = "I";
            $textoMsg = "Registro não encontrado!";
        }
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;

        $result = new JsonModel($dados);
        return $result;
    }
    
    /**
     * Selecionar Action
     * @return JsonModel
     */
    public function verificarPagamentoAbertoAction() {
        $post = $this->getRequest()->getPost()->toArray();
        $service = $this->getServiceLocator()->get($this->service);
        $repository = $service->selecionarPagamentoBy($post);
        if ($repository) {
            $tipoMsg = "S";
            $textoMsg = "Registro encontrado!";
            $idPagamento = $repository[0]->getIdPagamento();
        } else {
            $tipoMsg = "I";
            $textoMsg = "Registro não encontrado!";
            $idPagamento = NULL;
        }
        $dados = array();
        $dados['idPagamento'] = $idPagamento;
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;

        $result = new JsonModel($dados);
        return $result;
    }
    
    private function prepararDados($post) {
        $valor = explode(' ', $post['vlPagamento']);
        $vlPagamento = str_replace(',', '.', $valor[1]);
        $post['vlPagamento'] = (float) $vlPagamento;
        if ($post['dtPagamento'] != "") {
            $post['dtPagamento'] = \DateTime::createFromFormat('d/m/Y', $post['dtPagamento']);
        } else {
            unset($post['dtPagamento']);
        }
        if ($post['dtDeposito'] != "") {
            $post['dtDeposito'] = \DateTime::createFromFormat('d/m/Y', $post['dtDeposito']);
        } else {
            unset($post['dtDeposito']);
        }
        if ($post['dtEntrega'] != "") {
            $post['dtEntrega'] = \DateTime::createFromFormat('d/m/Y', $post['dtEntrega']);
        } else {
            unset($post['dtEntrega']);
        }
        if (empty($post['idPagamento'])) {
            $post['dtCadastro'] = new \DateTime("now");
            unset($post['idPagamento']);
        }
        return $post;
    }

    /**
     * Carregar Dados do Valor do Pagamento
     * @param type $repository
     * @return type
     */
    private function carregarDados($repository) {
        $vlPagamento = "R$ " . str_replace('.', ',', $repository->getVlPagamento());
        $array['idPagamento'] = $repository->getIdPagamento();
        $array['idCliente'] = $repository->getIdCliente()->getIdCliente();
        $array['tpCliente'] = $repository->getIdCliente()->getTpCliente();
        $array['dtVencimento'] = NULL;
        if ($repository->getIdCliente()->getDtVencimento()) {
            $array['dtVencimento'] = $repository->getIdCliente()->getDtVencimento()->format('d/m/Y');
        }
        $array['stPagamento'] = $repository->getStPagamento();
        $array['tpPagamento'] = $repository->getTpPagamento();
        $array['vlPagamentoLimpo'] = $repository->getVlPagamento();
        $array['vlPagamento'] = $vlPagamento;
        $array['vlAnuncioComum'] = $repository->getVlAnuncioComum();
        if ($repository->getDtPagamento()) {
            $array['dtPagamento'] = $repository->getDtPagamento()->format('d/m/Y');
        } else {
            $array['dtPagamento'] = NULL;
        }
        $array['noDepositante'] = $repository->getNoDepositante();
        $array['nuCpfDepositante'] = $repository->getNuCpfDepositante();
        if ($repository->getDtDeposito()) {
            $array['dtDeposito'] = $repository->getDtDeposito()->format('d/m/Y');
        } else {
            $array['dtDeposito'] = NULL;
        }
        $array['nuComprovante'] = $repository->getNuComprovante();
        $array['dsLocalEntrega'] = $repository->getDsLocalEntrega();
        if ($repository->getDtEntrega()) {
            $array['dtEntrega'] = $repository->getDtEntrega()->format('d/m/Y');
        } else {
            $array['dtEntrega'] = NULL;
        }
        $array['hrEntrega'] = $repository->getHrEntrega();
        $array['dsFalarCom'] = $repository->getDsFalarCom();
        $array['nuTelefone'] = $repository->getNuTelefone();
        return $array;
    }

    /**
     * Excluir Action
     * @return JsonModel
     */
    public function excluirAction() {
        $post = $this->getRequest()->getPost()->toArray();
        if ($this->identity()->getTpUsuario() == 1) {
            $service = $this->getServiceLocator()->get($this->service);
            $repository = $service->selecionarPagamento($post['idPagamento']);
            if ($repository) {
                if ($service->excluirPagamento($repository)) {
                    $tipoMsg = "S";
                    $textoMsg = "Registro deletado com sucesso!";
                } else {
                    $tipoMsg = "E";
                    $textoMsg = "Não foi possível deletar o registro!";
                }
            } else {
                $tipoMsg = "I";
                $textoMsg = "Registro não foi encontrado!";
            }
        } else {
            $tipoMsg = "I";
            $textoMsg = "Ação restrita apenas aos administradores do sistema!";
        }

        $dados = array();
        $dados['tipoMsg'] = $tipoMsg;
        $dados['textoMsg'] = $textoMsg;

        $result = new JsonModel($dados);
        return $result;
    }

}