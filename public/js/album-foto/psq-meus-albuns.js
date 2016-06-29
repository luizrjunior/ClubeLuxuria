var DadosEtapas = {
    paginaAtual: null
};

function listarMeusAlbuns() {
    Componentes.paginacaoGeral({
        div: 'tableMeusAlbuns',
        url: top.basePath + '/album-foto/index/pesquisar-meus-albuns',
        botaoBusca: 'btnPesquisarMeusAlbuns',
        form: 'formPsqMeusAlbuns',
        paginaAtual: DadosEtapas.pagina
    });
}

$(document).ready(function () {
    $("#idClientePsqMeusAlbuns").val(top.idClientePsq);
    listarMeusAlbuns();
});