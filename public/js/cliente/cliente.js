var DadosEtapas = {
    paginaAtual: null
};

function confirmarExcluirCliente(idCliente) {
    Componentes.modalAlerta('Não é permitido remover o Cliente neste sistema!', null);
    top.idCliente = idCliente;
//    Componentes.modalConfirmacao(null, 'Tem certeza que deseja remover esse Cliente?', excluirCliente, null);
}

function excluirCliente() {
    $('#carregando').show();
    var formURL = top.basePath + '/cliente/index/excluir';
    $.ajax({
        type: "POST",
        url: formURL,
        data: {idCliente : top.idCliente},
        dataType: "json",
        success: function(data) {
            $('#carregando').hide();
            $('#modalConfirmacao').modal('hide');
            clicarPesquisarNovamenteCliente();
            top.idCliente = null;
            Componentes.modalAlerta(formataTextMsg(data.textoMsg), null);
        }
    });
}

function clicarPesquisarNovamenteCliente() {
    var pagina = $('#tableClientes').find('.active');
    Componentes.paginacaoGeral({
        div: 'tableClientes', //id da div onde sera reenderizada a tabela
        url: top.basePath + '/cliente/index/pesquisar-cliente', //url que sera usada para a pesquisa
        botaoBusca: 'btnPesquisarCliente',
        form: 'formPsqCliente',
        paginaAtual: pagina.attr('page'),
        executarOnReady: false
    });
}

function listarClientes() {
    Componentes.paginacaoGeral({
        div: 'tableClientes', //id da div onde sera reenderizada a tabela
        url: top.basePath + '/cliente/index/pesquisar-cliente', //url que sera usada para a pesquisa
        botaoBusca: 'btnPesquisarCliente',
        form: 'formPsqCliente',
        paginaAtual: DadosEtapas.pagina
    });
}

function abrirTelaPesquisaCliente() {
    $("#cadCliente").hide();
    $("#psqCliente").fadeIn("slow");
}

function abrirTelaCadastroCliente() {
    $("#psqCliente").hide();
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
    $("#psqCliente").show();

    $("#nuCpfPsq").mask("999.999.999-99");
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
    
    $('#btnNovoCliente').on('click', function () {
        limparCamposCliente();
        limparCamposUsuarioClienteForm();
        abrirTelaCadastroCliente();
    });
    
    $('#btnVoltarCliente').on('click', function () {
        location.href = top.basePath + '/perfil';
    });
    
    listarClientes();
});