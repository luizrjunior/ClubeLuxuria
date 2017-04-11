var DadosEtapas = {
    paginaAtual: null
};

function limparCamposAlbum() {
    top.idAlbum = '';
    $("#idAlbum").val('');
    $("#idClienteAlbum").val(top.idCliente);
    $("#tpAlbum").val('2');
    $("#tpAlbum").prop('disabled', true);
    $("#stAlbum").val('1');
    $('input[name="stComentarioAlbum"]').prop('checked', false);
    $("#noAlbum").val('');
    $("#dsAlbum").val('');
    abrirFecharCamposAlbum();
    $("#tituloAlbum").html('Adicionar Album - Cliente: ' + $("#noCliente").val() + ' ' + $("#nuTelefoneCliente").val());
    $("#divCadFotoInfo").show();
    $("#divCadFoto").hide();
    if (top.idClientePerfil !== undefined) {
        $("#btnNovoCadAlbum").show();
        $("#btnGravarAlbum").show();
        $("#divFileFoto").show();
        $("#divNotaFoto").show();
    }
    //Esta funcao encontra-se no arquivo foto.js
    limparCamposFoto();
}

function carregarCamposAlbum(json) {
    top.idAlbum = json.idAlbum;
    $("#idAlbum").val(json.idAlbum);
    $("#idClienteAlbum").val(json.idCliente);
    $("#tpAlbum").val(json.tpAlbum);
    $("#tpAlbum").prop('disabled', true);
    if (json.tpAlbum === 1) {
        if (top.idClientePerfil !== undefined) {
            $("#btnNovoCadAlbum").hide();
            $("#btnGravarAlbum").hide();
            $("#divFileFoto").hide();
            $("#divNotaFoto").hide();
        }
    }
    $("#stAlbum").val(json.stAlbum);
    if (json.stComentario === 1) {
        $('input[name="stComentarioAlbum"]').prop('checked', true);
    } else {
        $('input[name="stComentarioAlbum"]').prop('checked', false);
    }
    $("#noAlbum").val(json.noAlbum);
    $("#dsAlbum").val(json.dsAlbum);
    $("#tituloAlbum").html('Editar Album - Cliente: ' + $("#noCliente").val() + ' ' + $("#nuTelefoneCliente").val());
    $("#divCadFotoInfo").hide();
    $("#divCadFoto").show();
    
    abrirFecharCamposAlbum();
    //Esta funcao encontra-se no arquivo foto.js
    verificarFotos(json.idAlbum);
}

function selecionarAlbum(idAlbum) {
    var url = top.basePath + '/album-foto/album/selecionar';
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idAlbum: idAlbum
        },
        dataType: "json",
        success: function (data) {
            limparCamposAlbum();
            abrirTelaCadastroAlbum();
            if (data.tipoMsg === "S") {
                carregarCamposAlbum(data);
            }
        }
    });
}

function validarCamposAlbum() {
    var chk = true;
    var texto = "<ul>";

    if ($("#noAlbum").val() === "") {
        texto += "<li><font color='#000000'>O campo <strong>\"Nome do Album\"</strong> é de preechimento obrigatório.</font></li>";
        chk = false;
    }
        
    if ($("#tpAlbum").val() === "") {
        texto += "<li><font color='#000000'>O campo <strong>\"Tipo do Album\"</strong> é de preechimento obrigatório.</font></li>";
        chk = false;
    }
        
    texto += "</ul>";

    if (chk === false) {
        Componentes.modalAlerta(texto, null);
        return chk;
    } else {
        $("#tpAlbum").prop('disabled', false);
        return chk;
    }
}

function salvarAlbum() {
    if (validarCamposAlbum()) {
        var postData = $('#formCadAlbum').serializeArray();
        var formURL = top.basePath + '/album-foto/album/salvar';
        $.ajax({
            type: "POST",
            url: formURL,
            data: postData,
            dataType: "json",
            success: function (data) {
                if (data.tipoMsg === "S") {
                    selecionarAlbum(data.idAlbum);
                    clicarPesquisarNovamenteAlbum();
                }
                Componentes.modalAlerta(formataTextMsg(data.textoMsg), null);
            }
        });
    }
}

function abrirTelaCadastroAlbumAlbum() {
    $("#cadAlbum").fadeOut("slow");
    $("#cadAlbum").fadeIn("slow");
}

function abrirTelaCadastroAlbum() {
    $("#cadAlbum").fadeOut("slow");
    $("#cadAlbum").fadeIn("slow");
}

function confirmarExcluirAlbum(idAlbum) {
    top.idAlbum = idAlbum;
    Componentes.modalConfirmacao(null, 'Tem certeza que deseja remover esse Album?', excluirAlbum, null);
}

function excluirAlbum() {
    var formURL = top.basePath + '/album-foto/index/excluir';
    $.ajax({
        type: "POST",
        url: formURL,
        data: {idAlbum: top.idAlbum},
        dataType: "json",
        success: function (data) {
            $('#modalConfirmacao').modal('hide');
            clicarPesquisarNovamente();
            top.idAlbum = null;
            Componentes.modalAlerta(data.textoMsg, null);
        }
    });
}

function abrirTelaPesquisaAlbum() {
    $("#cadAlbum").fadeOut("slow");
    $("#psqAlbum").fadeIn("slow");
}

function abrirTelaCadastroAlbum() {
    $("#psqAlbum").fadeOut("slow");
    $("#cadAlbum").fadeIn("slow");
}

function clicarPesquisarNovamenteAlbum() {
    var pagina = $('#tableAlbums').find('.active');
    Componentes.paginacaoGeral({
        div: 'tableAlbums', //id da div onde sera reenderizada a tabela
        url: top.basePath + '/album-foto/index/pesquisar-album', //url que sera usada para a pesquisa
        botaoBusca: 'btnPesquisarAlbum',
        form: 'formPsqAlbum',
        paginaAtual: pagina.attr('page'),
        executarOnReady: false
    });
}

function listarAlbums() {
    Componentes.paginacaoGeral({
        div: 'tableAlbums', //id da div onde sera reenderizada a tabela
        url: top.basePath + '/album-foto/index/pesquisar-album', //url que sera usada para a pesquisa
        botaoBusca: 'btnPesquisarAlbum',
        form: 'formPsqAlbum',
        paginaAtual: DadosEtapas.pagina
    });
}

function carregarComboClienteAlbum() {
    $.ajax({
        type: "POST",
        url: top.basePath + "/cliente/index/carregar-select-cliente",
        dataType: "json",
        success: function (data) {
            var optionsCliente = "";
            $.each(data, function (key, value) {//percorro o array de etapas e confiro se o id da etapa == ao id da ultima etapa inserida e seto
                optionsCliente += '<option ' + (top.idCliente == key ? 'selected="selected"' : '') + ' value="' + key + '">' + value + '</option>';
            });
            $("#idClienteSelectPsqAlbum").html(optionsCliente);
            $("#idClienteSelectAlbum").html(optionsCliente);
        }
    });
}

function abrirFecharCamposAlbum() {
    if ($("#tpAlbum").val() === 1 || $("#tpAlbum").val() === "1") {
        $('#divDsAlbum').show();
        $('#divDsArquivo').hide();
    } else {
        $('#divDsAlbum').hide();
        $('#divDsArquivo').show();
    }
}

function confirmarRemoverAlbum(name) {
    top.nameFile = name;
    Componentes.modalConfirmacao(null, 'Tem certeza que deseja remover esse arquivo?', removerAlbum, null);
}

function removerAlbum() {
    var formURL = top.basePath + "/album-foto/index/remover-arquivo";
    $.ajax({
        type: "POST",
        url: formURL,
        data: {nameFile: top.nameFile},
        dataType: "json",
        success: function (data) {
            $('#modalConfirmacao').modal('hide');
            top.nameFile = null;
            Componentes.modalAlerta(data.textoMsg, null);
            $('#videoPlayer').attr("src", "");
            $('#divDsArquivo').show();
            $('#divDsArquivo2').hide();
        }
    });
}

function selecionarAlbunsCliente(idCliente) {
    top.idCliente = idCliente;
    $("#tituloAlbumPsq").html('Pesquisar Albuns de Fotos - Cliente: ' + $("#noCliente").val() + ' ' + $("#nuTelefoneCliente").val());
    $("#idClientePsqAlbum").val(idCliente);
    abrirTelaPesquisaAlbum();
    carregarComboClienteAlbum();
    listarAlbums();
}

$(document).ready(function () {
    $("#psqAlbum").show();
    $("#cadAlbum").hide();
    
    $("#idClienteSelectPsqAlbum").prop('disabled', true);
    $("#idClienteSelectAlbum").prop('disabled', true);

    $('#btnNovoAlbum').on('click', function () {
        limparCamposAlbum();
        abrirTelaCadastroAlbum();
    });

    $('#btnNovoCadAlbum').on('click', function () {
        limparCamposAlbum();
    });

    $('#linkRemoverAlbum').on('click', function () {
        confirmarRemoverLink();
    });

    $('#linkVisualizarAlbum').on('click', function () {
        visualizarLink();
    });

    $('#btnGravarAlbum').on('click', function () {
        salvarAlbum();
    });

    $('#btnVoltarAlbum').on('click', function () {
        location.href = top.basePath + '/cliente/index';
    });

    $('#btnVoltarCadAlbum').on('click', function () {
        abrirTelaPesquisaAlbum();
    });
    
    $('#tpAlbum').on('change', function () {
        abrirFecharCamposAlbum();
    });
});