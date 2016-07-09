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

function abrirMeusAlbuns() {
    $("#psqGaleriaFotos").hide();
    $("#psqMeusAlbuns").fadeIn('slow');
    $("#tableGaleriaFotos").html('');
}

function abrirGaleriaFotos(idAlbum) {
    $("#idAlbumPsq").val(idAlbum);
    
    $("#psqMeusAlbuns").hide();
    $("#psqGaleriaFotos").fadeIn('slow');
    
    Componentes.paginacaoGeral({
        div: 'tableGaleriaFotos',
        url: top.basePath + '/album-foto/index/pesquisar-galeria-fotos',
        botaoBusca: 'btnPesquisarGaleriaFotos',
        form: 'formPsqGaleriaFotos',
        paginaAtual: DadosEtapas.pagina
    });
}

$(document).ready(function () {
    $("#idClientePsqMeusAlbuns").val(top.idClientePsq);
    abrirMeusAlbuns();
    listarMeusAlbuns();
});