var DadosEtapas = {
    paginaAtual: null
};

function limparCamposPagamento() {
    $("#idPagamento").val('');
    $("#idClientePagamento").val('');
    top.tpCliente = "";
    $("#idClientePagamento").prop('disabled', false);
    
    var radiosTpPagamento = $('input:radio[name=tpPagamento]');
    radiosTpPagamento.filter('[value=1]').prop('checked', true);
    
    $("#dtPagamento").val('');
    $("#vlPagamento").val('');
    $("#stPagamento").val('');
    $("#dtVencimento").val('');
    top.vlAnuncioComum = 150;
    top.vlPacoteSocioCL = 24;
    
    $("#noDepositante").val('');
    $("#nuCpfDepositante").val('');
    $("#dtDeposito").val('');
    $("#nuComprovante").val('');
    
    $("#dsLocalEntrega").val('');
    $("#dtEntrega").val('');
    $("#hrEntrega").val('');
    $("#dsFalarCom").val('');
    $("#nuTelefone").val('');
     
    $("#divItensFatura").html("");
    $("#tituloPagamento").html('Adicionar Pagamento');
    verificarTpPagamento();
    $("#btnGravarPagamento").prop('disabled', false);
    $("#dtPagamento").prop('disabled', false);
    $("#vlPagamento").prop('disabled', false);
    $("#stPagamento").prop('disabled', false);
    $("#dtVencimento").prop('disabled', false);
    $('input[name="tpPagamento"]').prop('disabled', false);
    
    if (top.idClientePerfil !== undefined || top.stCadPagamentoCliente !== undefined) {
        $("#dtPagamento").prop('disabled', true);
        $("#vlPagamento").prop('disabled', true);
        $("#stPagamento").prop('disabled', true);
        $("#dtVencimento").prop('disabled', true);
    }
    if (top.stCadPagamentoCliente !== undefined) {
        $("#idClientePagamento").val(top.idCliente);
        buscarDadosCliente();
    }
}

function carregarCamposPagamento(json) {
    $("#idPagamento").val(json.idPagamento);
    $("#idClientePagamento").val(json.idCliente);
    top.tpCliente = json.tpCliente;
    $("#idClientePagamento").prop('disabled', true);
    
    var radiosTpPagamento = $('input:radio[name=tpPagamento]');
    radiosTpPagamento.filter('[value=' + json.tpPagamento + ']').prop('checked', true);
    
    $("#dtPagamento").val(json.dtPagamento);
    $("#vlPagamento").val(json.vlPagamento);
    $("#stPagamento").val(json.stPagamento);
    $("#dtVencimento").val(json.dtVencimento);
    top.vlAnuncioComum = 150;
    if (top.tpCliente === 2) {
        top.vlPacoteSocioCL = json.vlPagamentoLimpo;
        $("#vlPagamento").val(json.vlPagamento);
    }
    $("#noDepositante").val(json.noDepositante);
    $("#nuCpfDepositante").val(json.nuCpfDepositante);
    $("#dtDeposito").val(json.dtDeposito);
    $("#nuComprovante").val(json.nuComprovante);
    
    $("#dsLocalEntrega").val(json.dsLocalEntrega);
    $("#dtEntrega").val(json.dtEntrega);
    $("#hrEntrega").val(json.hrEntrega);
    $("#dsFalarCom").val(json.dsFalarCom);
    $("#nuTelefone").val(json.nuTelefone);
     
    $("#tituloPagamento").html('Editar Pagamento');
    verificarTpPagamento();
    if ($("#stPagamento").val() === 5 || $("#stPagamento").val() === '5') {
        $("#btnGravarPagamento").prop('disabled', true);
    }
    if (top.idClientePerfil !== undefined) {
        $("#dtPagamento").prop('disabled', true);
        $("#vlPagamento").prop('disabled', true);
        $("#stPagamento").prop('disabled', true);
        $("#dtVencimento").prop('disabled', true);
    }
}

function mostrarBotaoPagSeguro() {
    $("#divRowBtnPagSeguro").hide();
    $("#divRowBtnPsMensal").hide();
    $("#divRowBtnPsAnual").hide();
    
    if ($("#idPagamento").val() !== "") {
        $("#divRowBtnPagSeguro").show();
        if (top.tpCliente === 1) {
            $("#divRowBtnPsMensal").show();
            if ($("#stPagamento").val() === 5) {
                $("#divRowBtnPsMensal").hide();
            }
        } else {
            $("#divRowBtnPsAnual").show();
        }
    }
}


function selecionarPagamento(idPagamento) {
    $('#carregando').show();
    var url = top.basePath + '/pagamento/index/selecionar';
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idPagamento: idPagamento
        },
        dataType: "json",
        success: function (data) {
            limparCamposPagamento();
            abrirTelaCadastroPagamento();
            if (data.tipoMsg === "S") {
                carregarCamposPagamento(data);
            }
            $('#carregando').hide();
        }
    });
}

function validarCamposPagamento() {
    var chk = true;
    var texto = "<ul>";

    if ($("#idClientePagamento").val() === "") {
        texto += "<li><font color='#000000'>O campo <strong>\"Nome do Cliente\"</strong> é de seleção obrigatória.</font></li>";
        chk = false;
    }
    
    var suporte = $("input[type=radio][name=tpPagamento]:checked").val();
    switch (suporte) {
        case "1":
            if ($("#noDepositante").val() === "") {
                texto += "<li><font color='#000000'>O campo <strong>\"Depositante (Nome Completo)\"</strong> é de preechimento obrigatório.</font></li>";
                chk = false;
            }
            if ($("#nuCpfDepositante").val() === "") {
                texto += "<li><font color='#000000'>O campo <strong>\"CPF do Depositante\"</strong> é de preechimento obrigatório.</font></li>";
                chk = false;
            }
            if ($("#dtDeposito").val() === "") {
                texto += "<li><font color='#000000'>O campo <strong>\"Data do Depósito\"</strong> é de preechimento obrigatório.</font></li>";
                chk = false;
            }
            break;
        case "2":
            break;
        case "3":
            if ($("#dsLocalEntrega").val() === "") {
                texto += "<li><font color='#000000'>O campo <strong>\"Local (Endereço Completo)\"</strong> é de preechimento obrigatório.</font></li>";
                chk = false;
            }
            if ($("#dtEntrega").val() === "") {
                texto += "<li><font color='#000000'>O campo <strong>\"Data do Recebimento (02 dias de antecedência)\"</strong> é de preechimento obrigatório.</font></li>";
                chk = false;
            }
            if ($("#hrEntrega").val() === "") {
                texto += "<li><font color='#000000'>O campo <strong>\"Hora do Recebimento\"</strong> é de preechimento obrigatório.</font></li>";
                chk = false;
            }
            if ($("#dsFalarCom").val() === "") {
                texto += "<li><font color='#000000'>O campo <strong>\"Falar com\"</strong> é de preechimento obrigatório.</font></li>";
                chk = false;
            }
            if ($("#nuTelefone").val() === "") {
                texto += "<li><font color='#000000'>O campo <strong>\"Telefone\"</strong> é de preechimento obrigatório.</font></li>";
                chk = false;
            }
            break;
    }
    
    if ($("#stPagamento").val() === "") {
        texto += "<li><font color='#000000'>O campo <strong>\"Situação do Pagamento\"</strong> é de seleção obrigatória.</font></li>";
        chk = false;
    }
    
    texto += "</ul>";

    if (chk === false) {
        Componentes.modalAlerta(texto, null);
        return chk;
    } else {
        $("#idClientePagamento").prop('disabled', false);
        $("#dtPagamento").prop('disabled', false);
        $("#vlPagamento").prop('disabled', false);
        $("#stPagamento").prop('disabled', false);
        $("#dtVencimento").prop('disabled', false);
        $('input[name="tpPagamento"]').prop('disabled', false);
        return chk;
    }
}

function salvarPagamento() {
    if (validarCamposPagamento()) {
        var postData = $('#formCadPagamento').serializeArray();
        var formURL = top.basePath + '/pagamento/index/salvar';
        $.ajax({
            type: "POST",
            url: formURL,
            data: postData,
            dataType: "json",
            success: function (data) {
                if (data.tipoMsg === "S") {
                    if ($("#stPagamento").val() === 5 || $("#stPagamento").val() === '5') {
                        alterarDataVencimento();
                    }
                    selecionarPagamento(data.idPagamento);
                    if (top.idClientePerfil === undefined) {
                        clicarPesquisarNovamentePagamento();
                    }
                }
                Componentes.modalAlerta(formataTextMsg(data.textoMsg), null);
            }
        });
    }
}

function alterarDataVencimento() {
    $("#idClientePagamento").prop('disabled', false);
    $('#carregando').show();
    var postData = $('#formCadPagamento').serializeArray();
    var formURL = top.basePath + '/cliente/index/salvar-data-vencimento';
    $.ajax({
        type: "POST",
        url: formURL,
        data: postData,
        dataType: "json",
        success: function (data) {
            $('#carregando').hide();
            if (data.tipoMsg === "S") {
                console.log(data.textoMsg);
            }
            $("#idClientePagamento").prop('disabled', true);
        }
    });
}

function confirmarExcluirPagamento(idPagamento) {
    top.idPagamento = idPagamento;
    Componentes.modalConfirmacao(null, 'Tem certeza que deseja remover esse Pagamento?', excluirPagamento, null);
}

function excluirPagamento() {
    var formURL = top.basePath + '/pagamento/index/excluir';
    $.ajax({
        type: "POST",
        url: formURL,
        data: {idPagamento: top.idPagamento},
        dataType: "json",
        success: function (data) {
            $('#modalConfirmacao').modal('hide');
            clicarPesquisarNovamentePagamento();
            top.idPagamento = null;
            Componentes.modalAlerta(data.textoMsg, null);
        }
    });
}

function abrirTelaPesquisaPagamento() {
    $("#cadPagamento").hide();
    $("#psqPagamento").fadeIn("slow");
}

function abrirTelaCadastroPagamento() {
    $("#psqPagamento").hide();
    $("#cadPagamento").fadeIn("slow");
}

function clicarPesquisarNovamentePagamento() {
    var pagina = $('#tablePagamentos').find('.active');
    Componentes.paginacaoGeral({
        div: 'tablePagamentos', //id da div onde sera reenderizada a tabela
        url: top.basePath + '/pagamento/index/pesquisar-pagamento', //url que sera usada para a pesquisa
        botaoBusca: 'btnPesquisarPagamento',
        form: 'formPsqPagamento',
        paginaAtual: pagina.attr('page'),
        executarOnReady: false
    });
}

function listarPagamentos() {
    Componentes.paginacaoGeral({
        div: 'tablePagamentos', //id da div onde sera reenderizada a tabela
        url: top.basePath + '/pagamento/index/pesquisar-pagamento', //url que sera usada para a pesquisa
        botaoBusca: 'btnPesquisarPagamento',
        form: 'formPsqPagamento',
        paginaAtual: DadosEtapas.pagina
    });
}

function carregarComboClientePagamento() {
    $.ajax({
        type: "POST",
        url: top.basePath + "/cliente/index/carregar-select-cliente",
        dataType: "json",
        success: function (data) {
            var optionsCliente = "";
            $.each(data, function (key, value) {//percorro o array de etapas e confiro se o id da etapa == ao id da ultima etapa inserida e seto
                optionsCliente += '<option ' + (top.idCliente == key ? 'selected="selected"' : '') + ' value="' + key + '">' + value + '</option>';
            });
            $("#idClientePagamento").html('<option value=""> - - Selecione - - </option>' + optionsCliente);
        }
    });
}

function verificarTpPagamento() {
    $("#divDepositoBancario").hide();
    $("#divPagSeguro").hide();
    $("#divRowBtnPagSeguro").hide();
    $("#divPagamentoDomicilio").hide();
    var suporte = $("input[type=radio][name=tpPagamento]:checked").val();
    switch (suporte) {
        case "1":
            $("#divDepositoBancario").show();
            if ($("#stPagamento").val() !== 5 && $("#stPagamento").val() !== '5') {
                $("#stPagamento").val(2);
            } else {
                $("#stPagamento").val(5);
            }
            break;
        case "2":
            $("#divPagSeguro").show();
            $("#divRowBtnPagSeguro").show();
            if ($("#stPagamento").val() !== 5 && $("#stPagamento").val() !== '5') {
                $("#stPagamento").val(3);
            } else {
                $("#stPagamento").val(5);
            }
            break;
        case "3":
            $("#divPagamentoDomicilio").show();
            if ($("#stPagamento").val() !== 5 && $("#stPagamento").val() !== '5') {
                $("#stPagamento").val(4);
            } else {
                $("#stPagamento").val(5);
            }
            break;
        default:
            if ($("#stPagamento").val() !== 5 && $("#stPagamento").val() !== '5') {
                $("#stPagamento").val(1);
            } else {
                $("#stPagamento").val(5);
            }
        break;
    }
    if ($("#idClientePagamento").val() !== "") {
        montarItensPagamento();
    }
    var tpPagamento = $("input[type=radio][name=tpPagamento]:checked").val();
    if (tpPagamento === '2') {
        mostrarBotaoPagSeguro();
    }
}
        
function verificarPagamentoAberto() {
    $('#carregando').show();
    var idCliente = $("#idClientePagamento").val();
    if (top.idClientePerfil !==  undefined) {
        idCliente = top.idClientePerfil;
    }
    var url = top.basePath + '/pagamento/index/verificar-pagamento-aberto';
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idCliente: idCliente
        },
        dataType: "json",
        success: function (data) {
            if (data.tipoMsg === "S") {
                selecionarPagamento(data.idPagamento);
            } else {
                buscarDadosCliente();
            }
        }
    });
}

function buscarDadosCliente() {
    $('#carregando').show();
    var idCliente = $("#idClientePagamento").val();
    if (top.idClientePerfil !==  undefined) {
        idCliente = top.idClientePerfil;
    }
    var url = top.basePath + '/cliente/index/selecionar';
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idCliente: idCliente
        },
        dataType: "json",
        success: function (data) {
            carregarDadosCliente(data);
        }
    });
}

function carregarDadosCliente(data) {
    $("#dtVencimento").val(data.dtVencimento);
    top.tpCliente = data.tpCliente;
    $("#noDepositante").val(data.noCliente);
    $("#nuCpfDepositante").val(data.nuCpf);
    $("#dsLocalEntrega").val(data.dsEndereco);
    $("#dsFalarCom").val(data.noCliente);
    $("#nuTelefone").val(data.nuTelefone);
    montarItensPagamento();
    if (top.idClientePerfil !== undefined || top.stCadPagamentoCliente !== undefined) {
        $("#idClientePagamento").prop('disabled', true);
    }
    //Verificar e Buscar Dados da Ultima Fatura do Cliente
    $('#carregando').hide();
}

function montarItensPagamento() {
    if (top.tpCliente === 1) {
        var itensAnuncioComum;
        itensAnuncioComum = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small> - Página de Perfil de Usuário</small><br />";
        itensAnuncioComum += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>Dados de Estatísticas</small><br />";
        itensAnuncioComum += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>Quadro \"Minhas Favoritas\"</small><br />";
        itensAnuncioComum += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>Configuração Página de Perfil</small><br />";
        itensAnuncioComum += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>Cadastro de Dados de Anunciante</small><br />";
        itensAnuncioComum += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>Cadastro de Caracteristicas de Atendimento e Serviço</small><br />";
        itensAnuncioComum += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>Configuração Página de Anunciante</small><br />";
        itensAnuncioComum += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>Cadastro de Videos</small><br />";
        itensAnuncioComum += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>Cadastro de Cachês</small><br />";
        itensAnuncioComum += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>Aprovação Depoimentos</small><br />";
        itensAnuncioComum += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>Cadastro de Albuns de Fotos</small><br />";
        itensAnuncioComum += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small> - Curtir Páginas e Fotos</small><br />";
        itensAnuncioComum += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small> - Registrar Depoimentos</small><br />";
        itensAnuncioComum += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small> - Página de Anuncio de produtos e serviços</small><br />";
        itensAnuncioComum += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>Meu Diário (Blog)*</small><br />";
        itensAnuncioComum += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>Ensaio Sensual</small><br />";
        itensAnuncioComum += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>Minhas Fotos</small><br />";
        itensAnuncioComum += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>Albúns de Fotos</small><br />";
        itensAnuncioComum += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>Mural de Depoimentos</small><br />";
        itensAnuncioComum += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>Meus Cachês</small><br />";
        itensAnuncioComum += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>Meus Videos</small><br />";
        itensAnuncioComum += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>Marcação com Geolocalização e navegação por Mapa</small><br />";
        itensAnuncioComum += "<br />";
        itensAnuncioComum += "<small><strong><i>* Modulos em construção</i></strong></small>";

        var conteudo = "<table width='100%' border='1'>";
        var vlTotal = 0;
        conteudo += "<tr>";
        conteudo += "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>- Anuncio Comum Mensal \"Integral\"</strong><br />";
        conteudo += itensAnuncioComum;
        conteudo += "</td>";
        conteudo += "<td align='right' valign='top'><strong>R$ " + parseInt(top.vlAnuncioComum) + ",00</strong></td>";
        conteudo += "</tr>";
        
        vlTotal = parseInt(top.vlAnuncioComum);
        $("#vlAnuncioComum").val(top.vlAnuncioComum);
                
        conteudo += "<tr>";
        conteudo += "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>- Total</strong></td>";
        conteudo += "<td align=\"right\" valign=\"top\"><strong>R$ " + parseInt(vlTotal) + ",00</strong></td>";
        conteudo += "</tr>";
        conteudo += "</table>";
        $("#divRowBtnPagSeguro").css('top', 950);
    } else {
        var radiosTpPagamento = $('input:radio[name=tpPagamento]');
        radiosTpPagamento.filter('[value=2]').prop('checked', true);
        $('input[name="tpPagamento"]').prop('disabled', true);
        
        if ($("#stPagamento").val() !== 5 && $("#stPagamento").val() !== '5') {
            $("#stPagamento").val(3);
        } else {
            $("#stPagamento").val(5);
        }
   
        $("#divDepositoBancario").hide();
        $("#divPagSeguro").show();
        if (top.idClientePerfil === undefined) {
            $("#divRowBtnPagSeguro").css('top', 625);
        } else {
            $("#divRowBtnPagSeguro").css('top', 825);
        }
        $("#divRowBtnPagSeguro").show();
        $("#divRowBtnPs01Msg").show();
        $("#divPagamentoDomicilio").hide();
        
        var itensPacoteSocio;
        itensPacoteSocio = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small> - Página de Perfil de Usuário</small><br />";
        itensPacoteSocio += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>Quadro \"Minhas Favoritas\"</small><br />";
        itensPacoteSocio += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>Configuração Página de Perfil</small><br />";
        itensPacoteSocio += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>Visialização de Videos das Anunciantes</small><br />";
        itensPacoteSocio += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>Visialização de Albuns de Fotos das Anunciantes</small><br />";
        itensPacoteSocio += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>Visialização de Localização de Rotas das Anunciantes</small><br />";
        itensPacoteSocio += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small> - Curtir Páginas e Fotos</small><br />";
        itensPacoteSocio += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small> - Registrar Depoimentos</small><br />";
        itensPacoteSocio += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small> - Modulo de Avaliação e Relatos de TD´s*</small><br />";
        itensPacoteSocio += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>Acesso a todos os conteúdos restritos do site (Fotos, Vídeos, Localização e Diários);</small><br />";
        itensPacoteSocio += "<br />";
        itensPacoteSocio += "<small><strong><i>* Modulos em construção</i></strong></small>";

        var conteudo = "<table width='100%' border='1'>";
        var vlTotal = 0;
        conteudo += "<tr>";
        conteudo += "<td>";
        conteudo += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>- Pacote Anual de Acesso (Validade 01 ano)</strong><br />";
        conteudo += itensPacoteSocio;
        conteudo += "</td>";
        conteudo += "<td align='right' valign='top'><strong>R$ " + parseInt(top.vlPacoteSocioCL) + ",00</strong></td>";
        conteudo += "</tr>";
        vlTotal = parseInt(top.vlPacoteSocioCL);
        conteudo += "<tr>";
        conteudo += "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>- Total</strong></td>";
        conteudo += "<td align=\"right\" valign=\"top\"><strong>R$ " + parseInt(vlTotal) + ",00</strong></td>";
        conteudo += "</tr>";
        conteudo += "</table>";
    }
    $("#vlPagamento").val("R$ " + parseInt(vlTotal) + ",00");
    $("#divItensFatura").html(conteudo);
}

function selecionarPagamentosCliente(idCliente) {
    top.idCliente = idCliente;
    $("#tituloPagamentoPsq").html('Pesquisar e Listar Pagamentos - Cliente: '  + $("#noArtistico").val() + ' ' + $("#nuTelefoneCliente").val());
    $("#idClientePsqPagamento").val(idCliente);
    abrirTelaPesquisaPagamento();
    carregarComboClientePagamento();
    listarPagamentos();
}

$(document).ready(function () {
    if (top.idClientePerfil === undefined) {
        $('#banner-principal').hide();
        $('#home').removeClass('active');
        $('#diarios').removeClass('active');
        $('#rotas').removeClass('active');
        $('#anuncie').removeClass('active');
        $('#cadastrese').removeClass('active');
        $('#contato').removeClass('active');
        $('#areaRestrita').addClass('active');

        $("#cadPagamento").hide();
        $("#psqPagamento").fadeIn("slow");
    }
    
    $('.guiMoneyMask').bind('input', function () {
        guiMoneyMask();
    });
    
    $("input[type=radio][name=tpPagamento]").click(function () {
        verificarTpPagamento();
    });
            
    $('#idClientePagamento').on('change', function () {
        buscarDadosCliente();
    });
    
    $('#btnNovoPagamento').on('click', function () {
        limparCamposPagamento();
        abrirTelaCadastroPagamento();
    });

    $('#btnVoltarPagamento').on('click', function () {
        location.href = top.basePath + '/perfil';
    });
    
    $('#btnNovoCadPagamento').on('click', function () {
        limparCamposPagamento();
    });

    $('#btnGravarPagamento').on('click', function () {
        salvarPagamento();
    });

    $('#btnVoltarCadPagamento').on('click', function () {
        abrirTelaPesquisaPagamento();
    });
    
    $("#nuCpfDepositante").mask("999.999.999-99");
    $("#dtDeposito").mask("99/99/9999");
    $("#hrEntrega").mask("99:99");
    $("#dtEntrega").mask("99/99/9999");

    //Data Expira em
    $('#dtDeposito').datepicker({
        todayHighlight: true,
        autoclose: true,
        format: 'dd/mm/yyyy',
        todayHighLight: true
    });//data expira em

    //Data Expira em
    $('#dtEntrega').datepicker({
        todayHighlight: true,
        autoclose: true,
        format: 'dd/mm/yyyy',
        todayHighLight: true
    });//data expira em

    $("#dtPagamento").mask("99/99/9999");
    //Data Expira em
    $('#dtPagamento').datepicker({
       todayHighlight:true,
       autoclose:true,
       format: 'dd/mm/yyyy',
       todayHighLight:true
    });//data expira em
    
    $("#dtVencimento").mask("99/99/9999");
    //Data Expira em
    $('#dtVencimento').datepicker({
       todayHighlight:true,
       autoclose:true,
       format: 'dd/mm/yyyy',
       todayHighLight:true
    });//data expira em
    
    $("#dtInicioPsq").mask("99/99/9999");
    //Data Expira em
    $('#dtInicioPsq').datepicker({
       todayHighlight:true,
       autoclose:true,
       format: 'dd/mm/yyyy',
       todayHighLight:true
    });//data expira em
    
    $("#dtFimPsq").mask("99/99/9999");
    //Data Expira em
    $('#dtFimPsq').datepicker({
       todayHighlight:true,
       autoclose:true,
       format: 'dd/mm/yyyy',
       todayHighLight:true
    });//data expira em
    if (top.stCadPagamentoCliente === undefined) {
        limparCamposPagamento();
        carregarComboClientePagamento();
    }
    if (top.idClientePerfil !== undefined) {
        top.idCliente = top.idClientePerfil;
        verificarPagamentoAberto();
        $("#btnNovoCadPagamento").hide();
        $("#btnVoltarCadPagamento").hide();
    } else {
        if (top.stCadPagamentoCliente === undefined) {
            $("#tituloPagamentoPsq").html('Pesquisar e Listar Pagamentos');
            listarPagamentos();
        }
    }
});