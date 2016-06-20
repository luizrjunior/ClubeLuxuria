var DadosEtapas = {
    paginaAtual: null
};

function limparCamposUsuario() {
    $("#tituloUsuario").html('Adicionar Usuário');
    $("#idUsuario").val('');
    $("#login").val('');
    $("#email").val('');
    $("#sgUfUsuario").val('');
    $("#noUsuario").val('');
    $("#senha").val('');
    $("#confirmarsenha").val('');
    $("#tpUsuario").val('');
    $("#stUsuario").val('1');
    $('#divSenha').show();
    $('#divBtnNovoCad').hide();
}

function carregarCamposUsuario(json) {
    if (top.idUsuarioPerfil !== undefined) {
        $("#tituloUsuario").html('Dados do Usuário (Edição)');
        $("#tpUsuario").prop('disabled', true);
        $("#stUsuario").prop('disabled', true);
        $("#btnNovoCad").hide();
        $("#btnVoltarCad").hide();
    } else {
        $("#tituloUsuario").html('Editar Usuário');
    }
    $("#idUsuario").val(json.idUsuario);
    $("#login").val(json.login);
    $("#email").val(json.email);
    $("#sgUfUsuario").val(json.sgUfUsuario);
    $("#noUsuario").val(json.noUsuario);
    $("#senha").val('');
    $("#confirmarsenha").val('');
    $("#tpUsuario").val(json.tpUsuario);
    $("#stUsuario").val(json.stUsuario);
    $('#divSenha').hide();
    $('#divBtnNovoCad').show();
}

function selecionarUsuario(idUsuario) {
    var url = "../usuario/index/selecionar";
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idUsuario: idUsuario
        },
        dataType: "json",
        success: function(data) {
            if (data.tipoMsg === "S") {
                abrirTelaCadastroUsuario();
                carregarCamposUsuario(data);
            } else {
                Componentes.modalAlerta(formataTextMsg(data.textoMsg), null);
            }
        }
    });
}

function validarCamposUsuario() {
    var chk = true;
    var texto = "<ul>";
    
    if ($("#login").val() === "") {
        texto += "<li><font color='#000000'>O campo <strong>\"Login\"</strong> é de preechimento obrigatório.</font></li>";
        chk = false;
    }

    if ($("#email").val() === "") {
        texto += "<li><font color='#000000'>O campo <strong>\"Email\"</strong> é de preechimento obrigatório.</font></li>";
        chk = false;
    }

    if ($("#idUsuario").val() === "") {
        if ($("#senha").val() === "") {
            texto += "<li><font color='#000000'>O campo <strong>\"Senha\"</strong> é de preechimento obrigatório.</font></li>";
            chk = false;
        }

        if ($("#confirmarsenha").val() === "") {
            texto += "<li><font color='#000000'>O campo <strong>\"Confirmar Senha\"</strong> é de preechimento obrigatório.</font></li>";
            chk = false;
        }

        if ($("#senha").val() !== "" && $("#confirmarsenha").val() !== "") {
            if ($("#senha").val() !== $("#confirmarsenha").val()) {
                texto += "<li><font color='#000000'>O campo <strong>\"Confirmar Senha\"</strong> diferente do campo <strong>\"Senha\"</strong>.</font></li>";
                chk = false;
            }
        }
    }

    if ($("#tpUsuario").val() === "T") {
        texto += "<li><font color='#000000'>O campo <strong>\"Função\"</strong> é de seleção obrigatória.</font></li>";
        chk = false;
    }

    if ($("#stUsuario").val() === "T") {
        texto += "<li><font color='#000000'>O campo <strong>\"Status\"</strong> é de seleção obrigatória.</font></li>";
        chk = false;
    }
    texto += "</ul>";

    if (chk === false) {
        Componentes.modalAlerta(formataTextMsg(texto), null);
        return chk;
    } else {
        $("#tpUsuario").prop('disabled', false);
        $("#stUsuario").prop('disabled', false);
        return chk;
    }
}

//Função para cadastrar ou alterar dados do usuário.
function salvarUsuario() {
    if (validarCamposUsuario()) {
        $('#carregando').show();
        var postData = $('#formCadUsuario').serializeArray();
        var formURL = top.basePath + '/usuario/index/salvar';
        //AJAX
        $.ajax({
            type: "POST",
            url: formURL,
            data: postData,
            dataType: "json",
            success: function(data) {
                $('#carregando').hide();
                Componentes.modalAlerta(formataTextMsg(data.textoMsg), null);
                if (data.tipoMsg === "S") {
                    limparCamposUsuario();
                    selecionarUsuario(data.idUsuario);
                    if (top.idUsuarioPerfil === undefined) {
                        clicarPesquisarNovamente();
                    }
                }
            }
        });
    }
}

function confirmarExcluirUsuario(idUsuario) {
    top.idUsuario = idUsuario;
    Componentes.modalConfirmacao(null, 'Tem certeza que deseja remover esse usuário?', excluirUsuario, null);
}

function excluirUsuario() {
    var formURL = top.basePath + "usuario/index/excluir";
    $.ajax({
        type: "POST",
        url: formURL,
        data: {idUsuario : top.idUsuario},
        dataType: "json",
        success: function(data) {
            $('#modalConfirmacao').modal('hide');
            clicarPesquisarNovamente();
            top.idUsuario = null;
            Componentes.modalAlerta(formataTextMsg(data.textoMsg), null);
        }
    });
}

function abrirTelaPesquisaUsuario() {
    $("#cadUsuario").hide();
    $("#psqUsuario").fadeIn("slow");
}

function abrirTelaCadastroUsuario() {
    $("#psqUsuario").hide();
    $("#cadUsuario").fadeIn("slow");
}

function clicarPesquisarNovamente() {
    var pagina = $('#tableUsuarios').find('.active');
    Componentes.paginacaoGeral({
        div: 'tableUsuarios', //id da div onde sera reenderizada a tabela
        url: top.basePath + '/usuario/index/pesquisar-usuario', //url que sera usada para a pesquisa
        botaoBusca: 'btnPesquisar',
        form: 'formPsq',
        paginaAtual: pagina.attr('page'),
        executarOnReady: false
    });
}

function listarUsuarios() {
    Componentes.paginacaoGeral({
        div: 'tableUsuarios', //id da div onde sera reenderizada a tabela
        url: top.basePath + '/usuario/index/pesquisar-usuario', //url que sera usada para a pesquisa
        botaoBusca: 'btnPesquisar',
        form: 'formPsq',
        paginaAtual: DadosEtapas.pagina
    });
}

$(document).ready(function () {
    if (top.idUsuarioPerfil === undefined) {
        $('#banner-principal').hide();
        $('#home').removeClass('active');
        $('#diarios').removeClass('active');
        $('#rotas').removeClass('active');
        $('#anuncie').removeClass('active');
        $('#cadastrese').removeClass('active');
        $('#contato').removeClass('active');
        $('#areaRestrita').addClass('active');
    }
    
    $("#psqUsuario").fadeIn("slow");
    $("#cadUsuario").hide();

    $('#btnNovo').on('click', function () {
        limparCamposUsuario();
        abrirTelaCadastroUsuario();
    });
    
    $('#btnVoltar').on('click', function () {
        location.href = top.basePath + '/perfil';
    });
    
    $('#btnNovoCad').on('click', function () {
        limparCamposUsuario();
    });
    
    $('#btnGravar').on('click', function () {
        salvarUsuario();
    });
    
    $('#btnVoltarCad').on('click', function () {
        abrirTelaPesquisaUsuario();
    });
    
    if (top.idUsuarioPerfil !== undefined) {
        selecionarUsuario(top.idUsuarioPerfil);
    } else {
        $("#tituloUsuarioPsq").html('Pesquisar e Listar Usuários');
        listarUsuarios();
    }

});