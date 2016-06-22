var DadosEtapas = {
    paginaAtual: null
};

function limparCamposContato() {
    $("#tituloContato").html('Adicionar Contato');
    $("#idContato").val('');
    $("#nome").val('');
    $("#email").val('');
    $("#idAssunto").val('');
    $("#assunto").val('');
    $("#mensagem").val('');
    $("#status").val('');
}

function carregarCamposContato(json) {
    $("#tituloContato").html('Editar Contato');
    $("#idContato").val(json.idContato);
    $("#nome").val(json.nome);
    $("#email").val(json.email);
    $("#idAssunto").val(json.idAssunto);
    $("#assunto").val(json.assunto);
    $("#mensagem").val(json.mensagem);
    $("#status").val(json.status);
}

function selecionarContato(idContato) {
    $('#carregando').show();
    var url = top.basePath + "/contato/selecionar";
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idContato: idContato
        },
        dataType: "json",
        success: function(data) {
            $('#carregando').hide();
            limparCamposContato();
            abrirTelaCadastroContato();
            if (data.tipoMsg === "S") {
                carregarCamposContato(data);
            }
        }
    });
}

function validarCamposContato() {
    var chk = true;
    var texto = "<ul>";
    
    if ($("#nome").val() === "") {
        texto += "<li><font color='#000000'>O campo <strong>\"Nome\"</strong> é de preechimento obrigatório.</font></li>";
        chk = false;
    }

    if ($("#email").val() === "") {
        texto += "<li><font color='#000000'>O campo <strong>\"Email\"</strong> é de preechimento obrigatório.</font></li>";
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

function salvarContato() {
    if (validarCamposContato()) {
        $('#carregando').show();
        var postData = $('#formCad').serializeArray();
        var formURL = top.basePath + '/contato/salvar';
        $.ajax({
            type: "POST",
            url: formURL,
            data: postData,
            dataType: "json",
            success: function(data) {
                $('#carregando').hide();
                if (data.tipoMsg === "S") {
                    limparCamposContato();
                    selecionarContato(data.idContato);
                    clicarPesquisarNovamente();
                }
                Componentes.modalAlerta(formataTextMsg(data.textoMsg), null);
            }
        });
    }
}

function confirmarExcluirContato(idContato) {
    top.idContato = idContato;
    Componentes.modalConfirmacao(null, 'Tem certeza que deseja remover esse contato?', excluirContato, null);
}

function excluirContato() {
    $('#carregando').show();
    var formURL = top.basePath + "/contato/excluir";
    $.ajax({
        type: "POST",
        url: formURL,
        data: {idContato: top.idContato},
        dataType: "json",
        success: function(data) {
            $('#modalConfirmacao').modal('hide');
            $('#carregando').hide();
            clicarPesquisarNovamente();
            top.idContato = null;
            Componentes.modalAlerta(formataTextMsg(data.textoMsg), null);
        }
    });
}

function abrirTelaPesquisaContato() {
    $("#cadContato").hide();
    $("#psqContato").fadeIn("slow");
}

function abrirTelaCadastroContato() {
    $("#psqContato").hide();
    $("#cadContato").fadeIn("slow");
}

function clicarPesquisarNovamente() {
    var pagina = $('#tableContatos').find('.active');
    Componentes.paginacaoGeral({
        div: 'tableContatos',
        url: top.basePath + '/contato/pesquisar',
        botaoBusca: 'btnPesquisar',
        form: 'formPsq',
        paginaAtual: pagina.attr('page'),
        executarOnReady: false
    });
}

function listarContatos() {
    Componentes.paginacaoGeral({
        div: 'tableContatos',
        url: top.basePath + '/contato/pesquisar',
        botaoBusca: 'btnPesquisar',
        form: 'formPsq',
        paginaAtual: DadosEtapas.pagina
    });
}

$(function(){
    //Oculta Banner
    $('#banner-principal').hide();
    
    $('#home').removeClass('active');
    $('#diarios').removeClass('active');
    $('#rotas').removeClass('active');
    $('#anuncie').removeClass('active');
    $('#cadastrese').removeClass('active');
    $('#contato').removeClass('active');
    $('#areaRestrita').addClass('active');
    
    $("#cadContato").hide();
    $("#psqContato").fadeIn("slow");
    
    $('#btnNovo').css( "display", "none");
    $('#btnNovo').on('click', function () {
       limparCamposContato();
    });

    $('#btnGravar').on('click', function () {
       salvarContato();
    });

    $('#btnVoltar').on('click', function () {
        location.href = top.basePath + '/perfil';
    });

    $('#btnRemover').on('click', function () {
       confirmarExcluirContato();
    });
    
    $('#btnVoltarCad').on('click', function () {
        abrirTelaPesquisaContato();
    });
    
    listarContatos();
});