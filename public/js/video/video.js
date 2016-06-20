var DadosEtapas = {
    paginaAtual: null
};

function limparCamposVideo() {
    $("#idVideo").val('');
    $("#idClienteVideo").val(top.idCliente);
    $("#tpVideo").val('1');
    $("#tiVideo").val('');
    $("#dsVideo").val('');
    $('#filename').html('');
    $('#videoPlayerLink').attr("src", "");
    $('#progress').html("");
    
    abrirFecharCamposVideo();
    
    $("#tituloVideo").html('Adicionar Video - Cliente: ' + $("#noCliente").val() + ' ' + $("#nuTelefoneCliente").val());
}

function carregarCamposVideo(json) {
    $("#idVideo").val(json.idVideo);
    $("#idClienteVideo").val(json.idClienteVideo);
    $("#tpVideo").val(json.tpVideo);
    $("#tiVideo").val(json.tiVideo);
    $("#dsVideo").val(json.dsVideo);
    
    if (json.tpVideo === 1) {
        $('#videoPlayerLink').attr("src", json.dsVideo);
    }
    if (json.tpVideo === 2) {
        $('#videoPlayerEmbed').html(json.dsVideo);
    }
    
    abrirFecharCamposVideo();
    
    $("#tituloVideo").html('Editar Video - Cliente: ' + $("#noCliente").val() + ' ' + $("#nuTelefoneCliente").val());
}

function selecionarVideo(idVideo) {
    var url = top.basePath + '/video/index/selecionar';
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idVideo: idVideo
        },
        dataType: "json",
        success: function (data) {
            limparCamposVideo();
            abrirTelaCadastroVideo();
            if (data.tipoMsg === "S") {
                carregarCamposVideo(data);
            }
        }
    });
}

function validarCamposVideo() {
    var chk = true;
    var texto = "<ul>";

    if ($("#tiVideo").val() === "") {
        texto += "<li><font color='#000000'>O campo <strong>\"Titulo do Video\"</strong> é de preechimento obrigatório.</font></li>";
        chk = false;
    }
        
    if ($("#tpVideo").val() === "1" || $("#tpVideo").val() === 1) {
        if ($("#dsVideo").val() === "") {
            texto += "<li><font color='#000000'>O campo <strong>\"Link do Video\"</strong> é de preechimento obrigatório.</font></li>";
            chk = false;
        }
    } else {
        if ($("#dsVideo").val() === "") {
            texto += "<li><font color='#000000'>O campo <strong>\"Embed do Vídeo\"</strong> é de preechimento obrigatório.</font></li>";
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

function salvarVideo() {
    if (validarCamposVideo()) {
        var postData = $('#formCadVideo').serializeArray();
        var formURL = top.basePath + '/video/index/salvar';
        $.ajax({
            type: "POST",
            url: formURL,
            data: postData,
            dataType: "json",
            success: function (data) {
                if (data.tipoMsg === "S") {
                    selecionarVideo(data.idVideo);
                    clicarPesquisarNovamenteVideos();
                }
                Componentes.modalAlerta(formataTextMsg(data.textoMsg), null);
            }
        });
    }
}

function abrirTelaCadastroVideoVideo() {
    $("#cadVideo").fadeOut("slow");
    $("#cadVideo").fadeIn("slow");
}

function abrirTelaCadastroVideo() {
    $("#cadVideo").fadeOut("slow");
    $("#cadVideo").fadeIn("slow");
}

function confirmarExcluirVideo(idVideo) {
    top.idVideo = idVideo;
    Componentes.modalConfirmacao(null, 'Tem certeza que deseja remover esse Video?', excluirVideo, null);
}

function excluirVideo() {
    var formURL = top.basePath + '/video/index/excluir';
    $.ajax({
        type: "POST",
        url: formURL,
        data: {idVideo: top.idVideo},
        dataType: "json",
        success: function (data) {
            $('#modalConfirmacao').modal('hide');
            clicarPesquisarNovamenteVideos();
            top.idVideo = null;
            Componentes.modalAlerta(data.textoMsg, null);
        }
    });
}

function abrirTelaPesquisaVideo() {
    $("#cadVideo").fadeOut("slow");
    $("#psqVideo").fadeIn("slow");
}

function abrirTelaCadastroVideo() {
    $("#psqVideo").fadeOut("slow");
    $("#cadVideo").fadeIn("slow");
}

function clicarPesquisarNovamenteVideos() {
    var pagina = $('#tableVideos').find('.active');
    Componentes.paginacaoGeral({
        div: 'tableVideos', //id da div onde sera reenderizada a tabela
        url: top.basePath + '/video/index/pesquisar-video', //url que sera usada para a pesquisa
        botaoBusca: 'btnPesquisarVideo',
        form: 'formPsqVideo',
        paginaAtual: pagina.attr('page'),
        executarOnReady: false
    });
}

function listarVideos() {
    Componentes.paginacaoGeral({
        div: 'tableVideos', //id da div onde sera reenderizada a tabela
        url: top.basePath + '/video/index/pesquisar-video', //url que sera usada para a pesquisa
        botaoBusca: 'btnPesquisarVideo',
        form: 'formPsqVideo',
        paginaAtual: DadosEtapas.pagina
    });
}

function carregarComboClienteVideo() {
    $.ajax({
        type: "POST",
        url: top.basePath + "/cliente/index/carregar-select-cliente",
        dataType: "json",
        success: function (data) {
            var optionsCliente = "";
            $.each(data, function (key, value) {//percorro o array de etapas e confiro se o id da etapa == ao id da ultima etapa inserida e seto
                optionsCliente += '<option ' + (top.idCliente == key ? 'selected="selected"' : '') + ' value="' + key + '">' + value + '</option>';
            });
            $("#idClienteSelectPsqVideo").html(optionsCliente);
            $("#idClienteSelectVideo").html(optionsCliente);
        }
    });
}

function abrirFecharCamposVideo() {
    $("#playerLink").hide();
    $("#playerEmbed").hide();
    if ($("#tpVideo").val() === 1 || $("#tpVideo").val() === "1") {
        $("#playerLink").show();
        $("#labelDsVideo").html("Link do Vídeo:");
        $("#dsVideo").attr("placeholder", "Informar Link do Video");
    } else {
        $("#playerEmbed").show();
        $("#labelDsVideo").html("Embed do Vídeo:");
        $("#dsVideo").attr("placeholder", "Informar Embed do Video");
    }
}

function visualizarLink() {
    if (validarCamposVideo()) {
        $('#videoPlayerLink').attr("src", $("#dsVideo").val());
    }
}

function confirmarRemoverLink(name) {
    top.nameFile = name;
    Componentes.modalConfirmacao(null, 'Tem certeza que deseja remover esse Link?', removerLink, null);
}

function removerLink() {
    $("#dsVideo").val('');
    $('#videoPlayerLink').attr("src", "");
    $('#modalConfirmacao').modal('hide');
}

function playerVideo(name) {
    $('#videoPlayerLink').attr("src", "../../storage/videos/" + top.idCliente + "/"  + name);
}

function confirmarRemoverVideo(name) {
    top.nameFile = name;
    Componentes.modalConfirmacao(null, 'Tem certeza que deseja remover esse arquivo?', removerVideo, null);
}

function removerVideo() {
    var formURL = top.basePath + "/video/index/remover-arquivo";
    $.ajax({
        type: "POST",
        url: formURL,
        data: {nameFile: top.nameFile},
        dataType: "json",
        success: function (data) {
            $('#modalConfirmacao').modal('hide');
            top.nameFile = null;
            Componentes.modalAlerta(data.textoMsg, null);
            $('#videoPlayerLink').attr("src", "");
            $('#divDsArquivo').hide();
        }
    });
}

function selecionarVideosCliente(idCliente) {
    top.idCliente = idCliente;
    $("#tituloVideoPsq").html('Pesquisar Vídeos - Cliente: ' + $("#noCliente").val() + ' ' + $("#nuTelefoneCliente").val());
    $("#idClientePsqVideo").val(idCliente);
    abrirTelaPesquisaVideo();
    carregarComboClienteVideo();
    listarVideos();
}

$(document).ready(function () {
    $('#divDsArquivo').hide();

    $("#psqVideo").fadeIn("slow");
    $("#cadVideo").fadeOut("slow");
    
    $("#idClienteSelectPsqVideo").prop('disabled', true);
    $("#idClienteSelectVideo").prop('disabled', true);

    $('#btnNovoVideo').on('click', function () {
        limparCamposVideo();
        abrirTelaCadastroVideo();
    });

    $('#btnNovoCadVideo').on('click', function () {
        limparCamposVideo();
    });

    $('#linkRemover').on('click', function () {
        confirmarRemoverLink();
    });

    $('#linkVisualizar').on('click', function () {
        visualizarLink();
    });

    $('#btnGravarVideo').on('click', function () {
        salvarVideo();
    });

    $('#btnVoltarCadVideo').on('click', function () {
        abrirTelaPesquisaVideo();
    });
    
    $('#tpVideo').on('change', function () {
        abrirFecharCamposVideo();
    });
    
});