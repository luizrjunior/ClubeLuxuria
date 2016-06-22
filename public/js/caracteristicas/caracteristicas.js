var DadosEtapas = {
    paginaAtual: null
};

function limparCamposCaracteristica() {
    $("#tituloCaracteristica").html('Adicionar Característica');
    $("#idCaracteristica").val('');
    $("#noCaracteristica").val('');
    $("#tpCaracteristica").val('T');
}

function carregarCamposCaracteristica(json) {
    $("#tituloCaracteristica").html('Editar Característica');
    $("#idCaracteristica").val(json.idCaracteristica);
    $("#noCaracteristica").val(json.noCaracteristica);
    $("#tpCaracteristica").val(json.tpCaracteristica);
}

function selecionarCaracteristica(idCaracteristica) {
    var url = top.basePath + "/caracteristicas/index/selecionar";
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idCaracteristica: idCaracteristica
        },
        dataType: "json",
        success: function(data) {
            if (data.tipoMsg === "S") {
                carregarCamposCaracteristica(data);
            } else {
                Componentes.modalAlerta(formataTextMsg(data.textoMsg), null);
            }
        }
    });
}

function validarCamposCaracteristica() {
    var chk = true;
    var texto = "<ul>";
    
    if ($("#tpCaracteristica").val() === "T") {
        texto += "<li><font color='#000000'>O campo <strong>\"Tipo\"</strong> é de seleção obrigatória.</font></li>";
        chk = false;
    }

    if ($("#noCaracteristica").val() === "") {
        texto += "<li><font color='#000000'>O campo <strong>\"Nome\"</strong> é de preechimento obrigatório.</font></li>";
        chk = false;
    }

    texto += "</ul>";

    if (chk === false) {
        Componentes.modalAlerta(formataTextMsg(texto), null);
        return chk;
    } else {
        return chk;
    }
}

//Função para cadastrar ou alterar dados do usuário.
function salvarCaracteristica() {
    if (validarCamposCaracteristica()) {
        var postData = $('#formCadCaracteristica').serializeArray();
        var formURL = top.basePath + '/caracteristicas/index/salvar';
        
        //AJAX
        $.ajax({
            type: "POST",
            url: formURL,
            data: postData,
            dataType: "json",
            success: function(data) {
                Componentes.modalAlerta(formataTextMsg(data.textoMsg), null);
                if (data.tipoMsg === "S") {
                    limparCamposCaracteristica();
                    selecionarCaracteristica(data.idCaracteristica);
                    if (top.idCaracteristicaPerfil === undefined) {
                        clicarPesquisarNovamente();
                    }
                }
            }
        });
    }
}

function confirmarExcluirCaracteristica(idCaracteristica) {
    top.idCaracteristica = idCaracteristica;
    Componentes.modalConfirmacao(null, 'Tem certeza que deseja remover essa Característica?', excluirCaracteristica, null);
}

function excluirCaracteristica() {
    var formURL = top.basePath + "/caracteristicas/index/excluir";
    $.ajax({
        type: "POST",
        url: formURL,
        data: {idCaracteristica : top.idCaracteristica},
        dataType: "json",
        success: function(data) {
            $('#modalConfirmacao').modal('hide');
            clicarPesquisarNovamente();
            top.idCaracteristica = null;
            Componentes.modalAlerta(formataTextMsg(data.textoMsg), null);
        }
    });
}

function clicarPesquisarNovamente() {
    var pagina = $('#tableCaracteristicas').find('.active');
    Componentes.paginacaoGeral({
        div: 'tableCaracteristicas', //id da div onde sera reenderizada a tabela
        url: top.basePath + '/caracteristicas/index/pesquisar-caracteristicas', //url que sera usada para a pesquisa
        botaoBusca: 'btnPesquisarCaracteristica',
        form: 'formCadCaracteristica',
        paginaAtual: pagina.attr('page'),
        executarOnReady: false
    });
}

function listarCaracteristicas() {
    Componentes.paginacaoGeral({
        div: 'tableCaracteristicas', //id da div onde sera reenderizada a tabela
        url: top.basePath + '/caracteristicas/index/pesquisar-caracteristicas', //url que sera usada para a pesquisa
        botaoBusca: 'btnPesquisarCaracteristica',
        form: 'formCadCaracteristica',
        paginaAtual: DadosEtapas.pagina
    });
}

$(document).ready(function () {
    $('#banner-principal').hide();
    $('#home').removeClass('active');
    $('#diarios').removeClass('active');
    $('#rotas').removeClass('active');
    $('#anuncie').removeClass('active');
    $('#cadastrese').removeClass('active');
    $('#contato').removeClass('active');
    $('#areaRestrita').addClass('active');
    
    $('#btnPesquisarCaracteristica').on('click', function () {
        $("#tituloCaracteristica").html('Pesquisar e Listar Características');
    });
    
    $('#btnVoltarCaracteristica').on('click', function () {
        location.href = top.basePath + '/perfil';
    });
    
    $('#btnNovoCaracteristica').on('click', function () {
        limparCamposCaracteristica();
    });
    
    $('#btnGravarCaracteristica').on('click', function () {
        salvarCaracteristica();
    });
    $("#tituloCaracteristica").html('Pesquisar e Listar Características');
    listarCaracteristicas();
});