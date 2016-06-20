var DadosEtapas = {
    paginaAtual: null
};

function limparCamposDepoimento() {
    $("#idDepoimento").val('');
    $("#idClienteDepoimento").val(top.idCliente);
    $("#idUsuarioDepoimento").val(top.idUsuarioPerfil);
    $("#idUsuarioSelectDepoimento").val(top.idUsuarioPerfil);
    $("#dsDepoimento").val('');
    $("#stDepoimento").val(1);
    $("#dtHrDepoimento").val(top.dtAtual);
    
    $("#tituloDepoimento").html('Adicionar Depoimento - Cliente: ' + $("#noCliente").val() + ' ' + $("#nuTelefoneCliente").val());
}

function carregarCamposDepoimento(json) {
    $("#idDepoimento").val(json.idDepoimento);
    $("#idClienteDepoimento").val(json.idCliente);
    $("#idUsuarioDepoimento").val(json.idUsuario);
    $("#idUsuarioSelectDepoimento").val(json.idUsuario);
    $("#dsDepoimento").val(json.dsDepoimento);
    $("#stDepoimento").val(json.stDepoimento);
    $("#dtHrDepoimento").val(json.dtHrDepoimento);
    
    $("#tituloDepoimento").html('Editar Depoimento - Cliente: ' + $("#noCliente").val() + ' ' + $("#nuTelefoneCliente").val());
}

function selecionarDepoimento(idDepoimento) {
    var url = top.basePath + '/depoimento/index/selecionar';
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idDepoimento: idDepoimento
        },
        dataType: "json",
        success: function (data) {
            limparCamposDepoimento();
            abrirTelaCadastroDepoimento();
            if (data.tipoMsg === "S") {
                carregarCamposDepoimento(data);
            }
        }
    });
}

function validarCamposDepoimento() {
    var chk = true;
    var texto = "<ul>";

    if ($("#dsDepoimento").val() === "") {
        texto += "<li><font color='#000000'>O campo <strong>\"Depoimento\"</strong> é de preechimento obrigatório.</font></li>";
        chk = false;
    } else {
        var dsDepoimento = $("#dsDepoimento").val();
        var n = dsDepoimento.length;
        if (n < 75) {
            texto += "<li><font color='#000000'>O Texto digitado deve ter o mínimo de 75 e o máximo de 125 caracteres.</font></li>";
            chk = false;
        }
    }
    texto += "</ul>";

    if (chk === false) {
        Componentes.modalAlerta(texto, null);
        return chk;
    } else {
        return chk;
    }
}

function salvarDepoimento() {
    if (validarCamposDepoimento()) {
        var postData = $('#formCadDepoimento').serializeArray();
        var formURL = top.basePath + '/depoimento/index/salvar';
        $.ajax({
            type: "POST",
            url: formURL,
            data: postData,
            dataType: "json",
            success: function (data) {
                if (data.tipoMsg === "S") {
                    selecionarDepoimento(data.idDepoimento);
                    clicarPesquisarNovamenteDepoimento();
                }
                Componentes.modalAlerta(formataTextMsg(data.textoMsg), null);
            }
        });
    }
}

function confirmarExcluirDepoimento(idDepoimento) {
    top.idDepoimento = idDepoimento;
    Componentes.modalConfirmacao(null, 'Tem certeza que deseja remover esse Depoimento?', excluirDepoimento, null);
}

function excluirDepoimento() {
    var formURL = top.basePath + '/depoimento/index/excluir';
    $.ajax({
        type: "POST",
        url: formURL,
        data: {idDepoimento: top.idDepoimento},
        dataType: "json",
        success: function (data) {
            $('#modalConfirmacao').modal('hide');
            clicarPesquisarNovamente();
            top.idDepoimento = null;
            Componentes.modalAlerta(data.textoMsg, null);
        }
    });
}

function abrirTelaPesquisaDepoimento() {
    $("#cadDepoimento").hide();
    $("#psqDepoimento").fadeIn("slow");
}

function abrirTelaCadastroDepoimento() {
    $("#psqDepoimento").hide();
    $("#cadDepoimento").fadeIn("slow");
}

function clicarPesquisarNovamenteDepoimento() {
    var pagina = $('#tableDepoimentos').find('.active');
    Componentes.paginacaoGeral({
        div: 'tableDepoimentos', //id da div onde sera reenderizada a tabela
        url: top.basePath + '/depoimento/index/pesquisar-depoimento', //url que sera usada para a pesquisa
        botaoBusca: 'btnPesquisarDepoimento',
        form: 'formPsqDepoimento',
        paginaAtual: pagina.attr('page'),
        executarOnReady: false
    });
}

function listarDepoimentos() {
    Componentes.paginacaoGeral({
        div: 'tableDepoimentos', //id da div onde sera reenderizada a tabela
        url: top.basePath + '/depoimento/index/pesquisar-depoimento', //url que sera usada para a pesquisa
        botaoBusca: 'btnPesquisarDepoimento',
        form: 'formPsqDepoimento',
        paginaAtual: DadosEtapas.pagina
    });
}

function carregarComboClienteDepoimento() {
    $.ajax({
        type: "POST",
        url: top.basePath + "/cliente/index/carregar-select-cliente",
        dataType: "json",
        success: function (data) {
            var optionsCliente = "";
            $.each(data, function (key, value) {//percorro o array de etapas e confiro se o id da etapa == ao id da ultima etapa inserida e seto
                optionsCliente += '<option ' + (top.idCliente == key ? 'selected="selected"' : '') + ' value="' + key + '">' + value + '</option>';
            });
            $("#idClienteSelectPsqDepoimento").html(optionsCliente);
            $("#idClienteSelectDepoimento").html(optionsCliente);
        }
    });
}

function carregarComboUsuarioDepoimento() {
    $.ajax({
        type: "POST",
        url: top.basePath + "/usuario/index/carregar-select-usuario",
        dataType: "json",
        success: function (data) {
            var optionsUsuario = "";
            $.each(data, function (key, value) {//percorro o array de etapas e confiro se o id da etapa == ao id da ultima etapa inserida e seto
                optionsUsuario += '<option value="' + key + '">' + value + '</option>';
            });
            $("#idUsuarioSelectPsqDepoimento").html('<option value="T"> -- Todos -- </option>' + optionsUsuario);
            $("#idUsuarioSelectDepoimento").html(optionsUsuario);
        }
    });
}

function selecionarDepoimentosCliente(idCliente) {
    top.idCliente = idCliente;
    $("#tituloDepoimentoPsq").html('Pesquisar Depoimentos - Cliente: ' + $("#noCliente").val() + ' ' + $("#nuTelefoneCliente").val());
    $("#idClientePsqDepoimento").val(idCliente);
    abrirTelaPesquisaDepoimento();
    carregarComboClienteDepoimento();
    carregarComboUsuarioDepoimento();
    setTimeout(listarDepoimentos, 1500);
}

$(document).ready(function () {
    $("#cadDepoimento").hide();
    $("#psqDepoimento").fadeIn("slow");

    $("#idClienteSelectPsqDepoimento").prop('disabled', true);
    $("#idClienteSelectDepoimento").prop('disabled', true);
    $("#dtHrDepoimento").prop('disabled', true);
    $("#idUsuarioSelectDepoimento").prop('disabled', true);

    $('#btnNovoDepoimento').on('click', function () {
        limparCamposDepoimento();
        abrirTelaCadastroDepoimento();
    });

    $('#btnNovoCadDepoimento').on('click', function () {
        limparCamposDepoimento();
    });

    $('#btnGravarDepoimento').on('click', function () {
        salvarDepoimento();
    });

    $('#btnVoltarCadDepoimento').on('click', function () {
        abrirTelaPesquisaDepoimento();
    });
    
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
    
});