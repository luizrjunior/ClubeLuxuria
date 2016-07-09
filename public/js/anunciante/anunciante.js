var DadosEtapas = {
    paginaAtual: null
};

function confirmarExcluirAnunciante(idAnunciante) {
    Componentes.modalAlerta('Não é permitido remover o Anunciante neste sistema!', null);
    top.idAnunciante = idAnunciante;
//    Componentes.modalConfirmacao(null, 'Tem certeza que deseja remover esse Anunciante?', excluirAnunciante, null);
}

function excluirAnunciante() {
    $('#carregando').show();
    var formURL = top.basePath + '/anunciante/index/excluir';
    $.ajax({
        type: "POST",
        url: formURL,
        data: {idAnunciante : top.idAnunciante},
        dataType: "json",
        success: function(data) {
            $('#carregando').hide();
            $('#modalConfirmacao').modal('hide');
            clicarPesquisarNovamenteCliente();
            top.idAnunciante = null;
            Componentes.modalAlerta(formataTextMsg(data.textoMsg), null);
        }
    });
}

function clicarPesquisarNovamenteCliente() {
    var pagina = $('#tableAnunciantes').find('.active');
    Componentes.paginacaoGeral({
        div: 'tableAnunciantes', //id da div onde sera reenderizada a tabela
        url: top.basePath + '/anunciante/index/pesquisar-anunciante', //url que sera usada para a pesquisa
        botaoBusca: 'btnPesquisarAnunciante',
        form: 'formPsqAnunciante',
        paginaAtual: pagina.attr('page'),
        executarOnReady: false
    });
}

function listarAnunciantes() {
    Componentes.paginacaoGeral({
        div: 'tableAnunciantes', //id da div onde sera reenderizada a tabela
        url: top.basePath + '/anunciante/index/pesquisar-anunciante', //url que sera usada para a pesquisa
        botaoBusca: 'btnPesquisarAnunciante',
        form: 'formPsqAnunciante',
        paginaAtual: DadosEtapas.pagina
    });
}

function abrirTelaPesquisaCliente() {
    $("#cadCliente").hide();
    $("#psqAnunciante").fadeIn("slow");
}

function abrirTelaCadastroCliente() {
    $("#psqAnunciante").hide();
    $("#cadCliente").fadeIn("slow");
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

    $("#cadCliente").hide();
    $("#psqAnunciante").show();

    $("#dtVencimentoPsq").mask("99/99/9999");
    
    //Data Expira em
    $('#dtVencimentoPsq').datepicker({
       todayHighlight:true,
       autoclose:true,
       format: 'dd/mm/yyyy',
       todayHighLight:true
    });//data expira em
    
    $('#menuAnunciantesCad').on('click', function () {
        selecionarAnuncianteCliente($("#idCliente").val());
    });
    
    $('#menuCaracteristicasCad').on('click', function () {
        selecionarCaracteristicasCliente($("#idCliente").val());
    });
    
    $('#menuCacheCad').on('click', function () {
        selecionarCachesCliente($("#idCliente").val());
    });
    
    $('#menuPagamentoCad').on('click', function () {
        selecionarPagamentosCliente($("#idCliente").val());
    });
    
    $('#menuVideosCad').on('click', function () {
        selecionarVideosCliente($("#idCliente").val());
    });
    
    $('#menuFotosCad').on('click', function () {
        verificarAlbumPrincipal($("#idCliente").val());
    });
    
    $('#menuConfiguracoesCad').on('click', function () {
        selecionarConfigPaginaCliente($("#idCliente").val());
    });
    
    $('#menuDepoimentoCad').on('click', function () {
        selecionarDepoimentosCliente($("#idCliente").val());
    });
    
    $('#menuAlbumFotosCad').on('click', function () {
        selecionarAlbunsCliente($("#idCliente").val());
    });
    
    $('#btnNovoAnunciante').on('click', function () {
        limparCamposAnunciante();
        limparCamposUsuarioAnuncianteForm();
        abrirTelaCadastroAnunciante();
    });
    
    $('#btnVoltarAnunciante').on('click', function () {
        location.href = top.basePath + '/perfil';
    });
    
    listarAnunciantes();
});