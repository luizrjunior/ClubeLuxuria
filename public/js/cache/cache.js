var DadosEtapas = {
    paginaAtual: null
};

function limparCamposCache() {
    $("#idCache").val('');
    $("#idClienteCache").val(top.idCliente);
    $("#noCache").val('');
    $("#dsCache").val('');
    $("#dsValor").val('');
    
    $("#tituloCache").html('Adicionar Cachê - Cliente: ' + $("#noCliente").val() + ' ' + $("#nuTelefoneCliente").val());
}

function carregarCamposCache(json) {
    $("#idCache").val(json.idCache);
    $("#idClienteCache").val(json.idClienteCache);
    $("#noCache").val(json.noCache);
    $("#dsCache").val(json.dsCache);
    $("#dsValor").val(json.dsValor);
    
    $("#tituloCache").html('Editar Cachê - Cliente: ' + $("#noCliente").val() + ' ' + $("#nuTelefoneCliente").val());
}

function selecionarCache(idCache) {
    $('#carregando').show();
    var url = top.basePath + '/cache/index/selecionar';
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idCache: idCache
        },
        dataType: "json",
        success: function (data) {
            limparCamposCache();
            abrirTelaCadastroCache();
            if (data.tipoMsg === "S") {
                carregarCamposCache(data);
            }
            $('#carregando').hide();
        }
    });
}

function validarCamposCache() {
    var chk = true;
    var texto = "<ul>";

    if ($("#noCache").val() === "") {
        texto += "<li><font color='#000000'>O campo <strong>\"Cachê\"</strong> é de preechimento obrigatório.</font></li>";
        chk = false;
    }

    if ($("#dsCache").val() === "") {
        texto += "<li><font color='#000000'>O campo <strong>\"Descrição do Cachê\"</strong> é de preechimento obrigatório.</font></li>";
        chk = false;
    }

    if ($("#dsValor").val() === "") {
        texto += "<li><font color='#000000'>O campo <strong>\"Valor do Cachê\"</strong> é de preechimento obrigatório.</font></li>";
        chk = false;
    }
    texto += "</ul>";

    if (chk === false) {
        Componentes.modalAlerta(texto, null);
        return chk;
    } else {
        return chk;
    }
}

function salvarCache() {
    if (validarCamposCache()) {
        $('#carregando').show();
        var postData = $('#formCadCache').serializeArray();
        var formURL = top.basePath + '/cache/index/salvar';
        $.ajax({
            type: "POST",
            url: formURL,
            data: postData,
            dataType: "json",
            success: function (data) {
                $('#carregando').hide();
                if (data.tipoMsg === "S") {
                    selecionarCache(data.idCache);
                    clicarPesquisarNovamenteCaches();
                }
                Componentes.modalAlerta(formataTextMsg(data.textoMsg), null);
            }
        });
    }
}

function abrirTelaCadastroCacheCache() {
    $("#cadCache").hide();
    $("#cadCache").fadeIn("slow");
}

function abrirTelaCadastroCache() {
    $("#cadCache").hide();
    $("#cadCache").fadeIn("slow");
}

function confirmarExcluirCache(idCache) {
    top.idCache = idCache;
    Componentes.modalConfirmacao(null, 'Tem certeza que deseja remover esse Cachê?', excluirCache, null);
}

function excluirCache() {
    var formURL = top.basePath + '/cache/index/excluir';
    $.ajax({
        type: "POST",
        url: formURL,
        data: {idCache: top.idCache},
        dataType: "json",
        success: function (data) {
            $('#modalConfirmacao').modal('hide');
            clicarPesquisarNovamenteCaches();
            top.idCache = null;
            Componentes.modalAlerta(data.textoMsg, null);
        }
    });
}

function abrirTelaPesquisaCache() {
    $("#cadCache").hide();
    $("#psqCache").fadeIn("slow");
}

function abrirTelaCadastroCache() {
    $("#psqCache").hide();
    $("#cadCache").fadeIn("slow");
}

function clicarPesquisarNovamenteCaches() {
    var pagina = $('#tableCaches').find('.active');
    Componentes.paginacaoGeral({
        div: 'tableCaches', //id da div onde sera reenderizada a tabela
        url: top.basePath + '/cache/index/pesquisar-cache', //url que sera usada para a pesquisa
        botaoBusca: 'btnPesquisarCache',
        form: 'formPsqCache',
        paginaAtual: pagina.attr('page'),
        executarOnReady: false
    });
}

function listarCaches() {
    Componentes.paginacaoGeral({
        div: 'tableCaches', //id da div onde sera reenderizada a tabela
        url: top.basePath + '/cache/index/pesquisar-cache', //url que sera usada para a pesquisa
        botaoBusca: 'btnPesquisarCache',
        form: 'formPsqCache',
        paginaAtual: DadosEtapas.pagina
    });
}

function carregarComboClienteCache() {
    $.ajax({
        type: "POST",
        url: top.basePath + "/cliente/index/carregar-select-cliente",
        dataType: "json",
        success: function (data) {
            var optionsCliente = "";
            $.each(data, function (key, value) {//percorro o array de etapas e confiro se o id da etapa == ao id da ultima etapa inserida e seto
                optionsCliente += '<option ' + (top.idCliente == key ? 'selected="selected"' : '') + ' value="' + key + '">' + value + '</option>';
            });
            $("#idClienteSelectPsqCache").html(optionsCliente);
            $("#idClienteSelectCache").html(optionsCliente);
        }
    });
}

function selecionarCachesCliente(idCliente) {
    top.idCliente = idCliente;
    $("#tituloCachePsq").html('Pesquisar Cachês - Cliente: ' + $("#noCliente").val() + ' ' + $("#nuTelefoneCliente").val());
    $("#idClientePsqCache").val(idCliente);
    abrirTelaPesquisaCache();
    carregarComboClienteCache();
    listarCaches();
}

$(document).ready(function () {
    $("#cadCache").hide();
    $("#psqCache").fadeIn("slow");

    $("#idClienteSelectPsqCache").prop('disabled', true);
    $("#idClienteSelectCache").prop('disabled', true);

    $('#btnNovoCache').on('click', function () {
        limparCamposCache();
        abrirTelaCadastroCache();
    });

    $('#btnNovoCadCache').on('click', function () {
        limparCamposCache();
    });

    $('#btnGravarCache').on('click', function () {
        salvarCache();
    });

    $('#btnVoltarCadCache').on('click', function () {
        abrirTelaPesquisaCache();
    });
    
});