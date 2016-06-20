var DadosEtapas = {
    paginaAtual: null
};

function limparCamposCidade() {
    $("#tituloCidade").html('Adicionar Cidade');
    $("#idCidade").val('');
    $("#noCidade").val('');
    $("#sgUf").val('T');
}

function carregarCamposCidade(json) {
    $("#tituloCidade").html('Editar Cidade');
    $("#idCidade").val(json.idCidade);
    $("#noCidade").val(json.noCidade);
    $("#sgUf").val(json.sgUf);
}

function selecionarCidade(idCidade) {
    var url = "../cidade/index/selecionar";
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idCidade: idCidade
        },
        dataType: "json",
        success: function(data) {
            if (data.tipoMsg === "S") {
                carregarCamposCidade(data);
            } else {
                Componentes.modalAlerta(formataTextMsg(data.textoMsg), null);
            }
        }
    });
}

function validarCamposCidade() {
    var chk = true;
    var texto = "<ul>";
    
    if ($("#sgUf").val() === "T") {
        texto += "<li><font color='#000000'>O campo <strong>\"Tipo\"</strong> é de seleção obrigatória.</font></li>";
        chk = false;
    }

    if ($("#noCidade").val() === "") {
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
function salvarCidade() {
    if (validarCamposCidade()) {
        var postData = $('#formCadCidade').serializeArray();
        var formURL = top.basePath + '/cidade/index/salvar';
        
        //AJAX
        $.ajax({
            type: "POST",
            url: formURL,
            data: postData,
            dataType: "json",
            success: function(data) {
                Componentes.modalAlerta(formataTextMsg(data.textoMsg), null);
                if (data.tipoMsg === "S") {
                    limparCamposCidade();
                    selecionarCidade(data.idCidade);
                    if (top.idCidadePerfil === undefined) {
                        clicarPesquisarNovamente();
                    }
                }
            }
        });
    }
}

function confirmarExcluirCidade(idCidade) {
    top.idCidade = idCidade;
    Componentes.modalConfirmacao(null, 'Tem certeza que deseja remover essa Cidade?', excluirCidade, null);
}

function excluirCidade() {
    var formURL = top.basePath + "/cidade/index/excluir";
    $.ajax({
        type: "POST",
        url: formURL,
        data: {idCidade : top.idCidade},
        dataType: "json",
        success: function(data) {
            $('#modalConfirmacao').modal('hide');
            clicarPesquisarNovamente();
            top.idCidade = null;
            Componentes.modalAlerta(formataTextMsg(data.textoMsg), null);
        }
    });
}

function clicarPesquisarNovamente() {
    var pagina = $('#tableCidades').find('.active');
    Componentes.paginacaoGeral({
        div: 'tableCidades', //id da div onde sera reenderizada a tabela
        url: top.basePath + '/cidade/index/pesquisar-cidade', //url que sera usada para a pesquisa
        botaoBusca: 'btnPesquisarCidade',
        form: 'formCadCidade',
        paginaAtual: pagina.attr('page'),
        executarOnReady: false
    });
}

function listarCidades() {
    Componentes.paginacaoGeral({
        div: 'tableCidades', //id da div onde sera reenderizada a tabela
        url: top.basePath + '/cidade/index/pesquisar-cidade', //url que sera usada para a pesquisa
        botaoBusca: 'btnPesquisarCidade',
        form: 'formCadCidade',
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
    
    $('#btnPesquisarCidade').on('click', function () {
        $("#tituloCidade").html('Pesquisar e Listar Cidades');
    });
    
    $('#btnVoltarCidade').on('click', function () {
        location.href = top.basePath + '/perfil';
    });
    
    $('#btnNovoCidade').on('click', function () {
        limparCamposCidade();
    });
    
    $('#btnGravarCidade').on('click', function () {
        salvarCidade();
    });
    $("#tituloCidade").html('Pesquisar e Listar Cidades');
    listarCidades();
});