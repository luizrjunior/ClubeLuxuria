var DadosEtapas = {
    paginaAtual: null
};

function listarMinhasFotos() {
    Componentes.paginacaoGeral({
        div: 'tableMinhasFotos',
        url: top.basePath + '/album-foto/index/pesquisar-minhas-fotos',
        botaoBusca: 'btnPesquisarMinhasFotos',
        form: 'formPsqMinhasFotos',
        paginaAtual: DadosEtapas.pagina
    });
}

$(document).ready(function () {
    listarMinhasFotos();
});