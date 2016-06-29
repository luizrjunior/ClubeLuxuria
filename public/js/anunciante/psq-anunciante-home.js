var DadosEtapas = {
    paginaAtual: null
};

function listarAnuncianteHome() {
    Componentes.paginacaoGeral({
        div: 'tableAnuncianteHome',
        url: top.basePath + '/anunciante/index/pesquisar-anunciante-home',
        botaoBusca: 'btnPesquisarAnuncianteHome',
        form: 'formPsqAnuncianteHome',
        paginaAtual: DadosEtapas.pagina
    });
}

$(document).ready(function () {
    $('#sgUfPsq').on('change', function () {
        listarAnuncianteHome();
    });
    
    $('#idCidadePsq').on('change', function () {
        listarAnuncianteHome();
    });
    
    listarAnuncianteHome();
});